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
		<?php 
		if($_REQUEST['type']==1)
			echo "Add Stock";
		else
			echo "Remove Stock";
		?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php 
		if($_REQUEST['type']==1)
			echo "Add Stock";
		else
			echo "Remove Stock";
		?>
		</li>
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
				$get=mysqli_query($con,"select product_name,stock from product where product_id=".$_GET['product_id']."");
				$row=mysqli_fetch_array($get,MYSQLI_ASSOC);
				?>
				<form role="form" name="my_form" id="my_form" method="POST">
					  <div class="box-body">
						<div class="form-group">
							<label for="product_name">Product Name</label>
							<?php echo $row['product_name'];?>							
						</div>
						<div class="form-group">
							<label for="current_stock">Current Stock</label>
							<?php echo $row['stock'];?>							
						</div>
						
						<div class="form-group">
							<label for="stock_update"><?php 
							if($_REQUEST['type']==1)
								echo "Add Stock";
							else
								echo "Remove Stock";
							?> </label>
							<input type="text" class="form-control" id="stock_update" name="stock_update">
							<div id="error_stock_update" style="display:none" class="error"></div>							
						</div>
						
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					  <input type="hidden" id="action" name="action" value="<?php if($_REQUEST['type']==1) echo 'add_stock'; else echo 'remove_stock';?>"/>
					  <input type="hidden" id="id" name="id" value="<?php echo $_GET['product_id']; ?>">
					  <input type="hidden" id="stock_now" name="stock_now" value="<?php echo $row['stock']; ?>">
						<button type="button" class="btn btn-primary" id="save">Submit</button>
						<a href="index.php"><button type="button" class="btn btn-primary">Cancel</button></a>
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
	
	var stock_update=$("#stock_update");
	
	var reg = /^-?\d*\.?\d+$/;
	
	var err=0; 
	if(stock_update.val()=="")
	{
		$("#error_stock_update").show();
		$("#error_stock_update").html("Please enter stock.");
		location.href="#error_stock_update";
		err++;
	}
	else if(!reg.test(stock_update.val())) {
		$("#error_stock_update").show();
		$("#error_stock_update").html("Please enter stock in proper format.");
		location.href="#error_stock_update";
		err++;
    }
	else
	{
		$("#error_stock_update").hide();
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
					$("#msg").html("Stock updated Successfully.");
					setTimeout(function(){ $("#msg").hide(); location.href="index.php"; }, 3000);
				}	
				else if($.trim(dataofconfirm)=='2')
				{
					$("#msg").removeClass("alert-success");	
					$("#msg").addClass("alert-danger");	
					$("#msg").show();
					$("#msg").html("Error while updating.");
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