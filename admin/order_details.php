<?php
session_start();
$page="index.php";
include_once("../config.php");
include_once("header.php");
include_once("menu.php");
?>
<style>
.pagination li {
  display:inline-block;
  padding:5px;
}


</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders Details
        
      </h1>
	  <br/>
	  <a href="javascript:void(0);" onclick="delete_order('<?php echo $_GET['id'];?>')"><input type="button" class="btn btn-primary" value="Delete This Order"></a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Order Details</li>
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
			
			
			<div class="bs-component">
				<div id="msg" class="alert" style="display:none;"></div>
				<div id="show_booking_data">
				
				</div>
				
			</div>
			
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
  <!-- page script -->

  <!-- jQuery 2.2.3 -->
   

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">




<script>

$( document ).ready(function() {
get_data();

	
});	
function delete_order(id)
{
	$.ajax({
	type: "POST",
	url: "ajax/get_data.php",
	data: 'action=delete_order&order_id='+id,
	cache: false,
	success: function(result){
	if($.trim(result)=='1')
		{
			$("#msg").removeClass("alert-danger");
			$("#msg").addClass("alert-success");
			$("#msg").html("Order deleted successfully.");
			$("#msg").show();
			setTimeout(function(){ $("#msg").hide();location.href="orders.php"; }, 3000);
			
		}	
		else if($.trim(result)=='2')
		{
			$("#msg").removeClass("alert-success");
			$("#msg").addClass("alert-danger");
			$("#msg").html("Error while deleting.");
			$("#msg").show();
			setTimeout(function(){ $("#msg").hide(); }, 3000);
		}
	
	}
});
}
function get_data()
{
$.ajax({
	type: "POST",
	url: "ajax/get_data.php",
	data: 'action=get_order_details&order_id='+<?php echo $_GET['id'];?>,
	cache: false,
	success: function(result){
	$("#show_booking_data").html(result);
	 $('#myTable').DataTable();
	
	}
});
}

function delete_product(id)
{
$.ajax({
	type: "POST",
	url: "ajax/get_data.php",
	data: 'action=delete_product&id='+id,
	cache: false,
	success: function(result){
		
		if($.trim(result)=='1')
		{
			$("#msg").removeClass("alert-danger");
			$("#msg").addClass("alert-success");
			$("#msg").html("Product deleted successfully.");
			$("#msg").show();
			setTimeout(function(){ $("#msg").hide();get_data(); }, 3000);
			
		}	
		else if($.trim(result)=='2')
		{
			$("#msg").removeClass("alert-success");
			$("#msg").addClass("alert-danger");
			$("#msg").html("Error while deleting.");
			$("#msg").show();
			setTimeout(function(){ $("#msg").hide(); }, 3000);
		}
	
	}
});	
}

</script>



  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>