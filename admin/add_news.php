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
        Add News
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add News</li>
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
			
				<form role="form" name="my_form" id="my_form" method="POST">
					  <div class="box-body">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="Title">
							<div id="error_title" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" name="description" placeholder="Enter some description"></textarea>
							<div id="error_description" style="display:none" class="error"></div>
						</div>
						
						
						<div class="form-group">
							<label for="product_image">News Images</label>
							<input type="file" class="form-control" id="upload_file" name="upload_file">
							<div id="error_upload_file" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="title">Youtube Video</label>
							<input type="text" class="form-control" id="youtube" name="youtube">
							
						</div>
						
						<div class="form-group">
							<label for="is_active">Active</label>
							<select class="form-control" name="is_active" id="is_active">
							<option value="1" selected>Yes</option>
							<option value="0">No</option>
							</select>
							<div id="error_is_active" style="display:none" class="error"></div>
						</div>
						
						
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					  <input type="hidden" id="action" name="action" value="add_news"/>
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
	
	var title=$("#title");
	var upload_file=$("#upload_file");
	var description=$("#description");
	var fileExtension = ['jpeg', 'jpg', 'png'];
	var regexp = /^[0-9]+([,.][0-9]+)?$/g;
	
	
	var err=0; 
	if(title.val()=="")
	{
		$("#error_title").show();
		$("#error_title").html("Please enter title.");
		location.href="#error_title";
		err++;
	}
	else
	{
		$("#error_title").hide();
	}
	if(description.val()=="")
	{
		$("#error_description").show();
		$("#error_description").html("Please enter product description.");
		location.href="#error_description";
		err++;
	}
	else
	{
		$("#error_description").hide();
	}	
		
	if($('#upload_file').val().length<='0')
	{
		$("#error_upload_file").show();
		$("#error_upload_file").html("Please select product image");
		err++;
		return false;
	}
	else if($('#upload_file').val().length > '0' && $.inArray($('#upload_file').val().split('.').pop().toLowerCase(), fileExtension) == -1) 
	{
		$("#error_upload_file").show();
		$("#error_upload_file").html("Only formats are allowed : "+fileExtension.join(', '));
		err++;
	} 
	else
	{
		$("#error_upload_file").hide();
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
					$("#msg").html("News added Successfully.");
					setTimeout(function(){ $("#msg").hide(); location.href="news.php"; }, 3000);
				}	
				else if($.trim(dataofconfirm)=='2')
				{
					$("#msg").removeClass("alert-success");	
					$("#msg").addClass("alert-danger");	
					$("#msg").show();
					$("#msg").html("Error while adding.");
					setTimeout(function(){ $("#msg").hide();}, 3000);
				}
				else if($.trim(dataofconfirm)=='3')
				{
					$("#msg").removeClass("alert-success");	
					$("#msg").addClass("alert-danger");	
					$("#msg").show();
					$("#msg").html("Error while uploading image.");
					setTimeout(function(){ $("#msg").hide();}, 3000);
				}
				location.href="#msg";
				
			}
		});
	}
	
		
		
});
	  

  });
 
</script>
  <!-- /.content-wrapper -->
  <?php include_once("footer.php"); ?>