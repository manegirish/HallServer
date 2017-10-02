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
        Subadmins
        
      </h1>
	  <a href="add_subadmin.php"><input type="button" class="btn btn-primary" value="Add Subadmins"></a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Subadmins</li>
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

$( function() {
	get_data();
	
	
	
});	
function get_data()
{
$.ajax({
	type: "POST",
	url: "ajax/get_bookings.php",
	data: 'action=get_subadmins',
	cache: false,
	success: function(result){
	$("#show_booking_data").html(result);
	 $('#myTable').DataTable();
	
	}
});
	
}
</script>



  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>