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


 #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  .ui-draggable, .ui-droppable {
	background-position: top;
	
	
}
#sortable li img{float: right;}
#sortable li {min-height: 68px;}
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Arrange Banner Products
        
      </h1>
	  <br/>
	  
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Arrange Banner Products</li>
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
   


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script>

$( document ).ready(function() {
get_data();

	
});	
function get_data()
{
$.ajax({
	type: "POST",
	url: "ajax/get_data.php",
	data: 'action=get_banner_products_arrange',
	cache: false,
	success: function(result){
		$("#show_booking_data").html(result);
	   $("#sortable").sortable({
       stop: function(event, ui) {
        var data = "";

        $("#sortable li").each(function(i, el){
            var p = $(this).attr("id");
            data += p+"="+$(el).index()+",";
        });
		
		
		
	$.ajax({
		type: "POST",
		url: "ajax/get_data.php",
		data: 'action=arrange_banner_products&data='+data,
		success: function(result){
			
		}
	});	
    }
    });
    $( "#sortable" ).disableSelection();
	
	
	
	
	
	}
});
}



</script>



  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>