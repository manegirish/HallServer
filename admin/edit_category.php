<?php
session_start();

include_once("../config.php");
include_once("header.php");
include_once("menu.php");
?>
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
   <script src="js/jquery-ui.min.js"></script> 
<style>
.entry-select{background:#FF0000;}
.error{color:#FF0000 !important;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Category
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Category</li>
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
					$sel=mysqli_query($con,"select category_name,is_active from category where id=".$_GET['id']."");
					$row=mysqli_fetch_array($sel,MYSQLI_ASSOC);
				?>
				<form role="form" name="my_form" id="my_form" method="POST">
					  <div class="box-body">
						<div class="form-group">
							<label for="category_name">Category Name</label>
							<input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name" value="<?php echo $row['category_name']?>">
							<div id="error_category_name" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="is_active">Active</label>
							<select class="form-control" name="is_active" id="is_active">
							<option value="1" <?php if($row['is_active']==1) echo 'selected';?>>Yes</option>
							<option value="0" <?php if($row['is_active']==0) echo 'selected';?>>No</option>
							</select>
							<div id="error_is_active" style="display:none" class="error"></div>
						</div>
						
						
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					  <input type="hidden" id="action" name="action" value="edit_category"/>
					  <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id'];?>"/>
						<button type="button" class="btn btn-primary" id="save">Submit</button>
						<a href="category.php"><button type="button" class="btn btn-primary">Cancel</button></a>
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
  
  
  
  $(function () {
	$("#save").click(function(){
	
	var category_name=$("#category_name");
	
	
	
	var err=0; 
	if(category_name.val()=="")
	{
		$("#error_category_name").show();
		$("#error_category_name").html("Please enter category name.");
		location.href="#error_category_name";
		err++;
	}
	else
	{
		$("#error_category_name").hide();
	}
		
	
	if(err==0)
	{	
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
					$("#msg").html("Category updated Successfully.");
					setTimeout(function(){ $("#msg").hide(); location.href="category.php"; }, 3000);
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
	  total=0;

  });
  function check_service(id)
{
	var spt=id.split("_");
	if($('#'+spt[0]).is(':checked')) {
		total=Number(total)+Number(spt[1]);
	}
	else
	{
		total=Number(total)-Number(spt[1]);
	}	
	if(total!=0)
	{
		$('#total_cost').html("Total Cost: "+total+" AED");
		$('#total_services_cost').val(total);
	}
	else
	{
		$('#total_cost').html("Total Cost: 0 AED");
		$('#total_services_cost').val("");
	}		

}
</script>
  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>