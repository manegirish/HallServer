<?php
session_start();

include_once("../config.php");
include_once("header.php");
include_once("menu.php");
?>
   
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
   <script src="js/jquery-ui.min.js"></script> 
   <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ce33jspvbxp3g7gqjj8zynhkwgizkvqqmhii4n9xio7roqtp"></script>
   <script>
   tinymce.init({ selector:'textarea',fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect" });
    $(function () {
	$("#save").click(function(){
		$("#desc").val(tinyMCE.activeEditor.getContent());
		if($("#desc").val()=="")
		{
			$("#error_description").show().html("Please enter description");
		}
		else
		{	
			$("#error_description").hide().html("");
			var myform = document.getElementById("my_form");
			var fd = new FormData(myform);
			$.ajax({
				url: "ajax/get_data.php",
				data: fd,
				cache: false,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function (dataofconfirm) {
					if($.trim(dataofconfirm)=='1')
					{
						$("#msg").removeClass("alert-danger");	
						$("#msg").addClass("alert-success");	
						$("#msg").show();
						$("#msg").html("Description added Successfully.");
						setTimeout(function(){ $("#msg").hide();}, 3000);
					}	
					else if($.trim(dataofconfirm)=='2')
					{
						$("#msg").removeClass("alert-success");	
						$("#msg").addClass("alert-danger");	
						$("#msg").show();
						$("#msg").html("Error while adding.");
						setTimeout(function(){ $("#msg").hide();}, 3000);
					}
					location.href="#msg";
					
				}
			});
		}
			
	});
	});
   </script>
<style>
.entry-select{background:#FF0000;}
.error{color:#FF0000 !important;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Cash On Delivery
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cash On Delivery</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
			<div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
			<div id="msg" class="alert" style="display:none"></div>
			<?php
				$description="";
				$sel=mysqli_query($con,"select description from about_us where type='cash_on_delivery'");
				if(mysqli_num_rows($sel)>0)
				{
					$row=mysqli_fetch_array($sel,MYSQLI_ASSOC);
					$description=$row['description'];
				}	
			?>
				<form role="form" name="my_form" id="my_form" method="POST">
					  <div class="box-body">
						
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" name="description" placeholder="Enter some description about product"><?php echo $description;?></textarea>
							<div id="error_description" style="display:none" class="error"></div>
							<input type="hidden" id="desc" name="desc" value="">
						</div>
											
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					  <input type="hidden" id="action" name="action" value="add_cash_on_delivery"/>
						<button type="button" class="btn btn-primary" id="save">Submit</button>
						
					  </div>
				</form>
			   
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->

<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->



<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->

<script>
 
</script>
  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>