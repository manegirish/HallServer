<?php
session_start();

include_once("../config.php");
include_once("header.php");
include_once("menu.php");
?>
   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
   <script src="js/jquery-ui.min.js"></script> 
   <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=leeb6f9q6hz1zac35j4iywf5ii661c5ioauuu6907eszese2"></script>
   <script>
   tinymce.init({ selector:'textarea',fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect" });
   
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
        Add Products
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Products</li>
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
							<label for="product_name">Product Name</label>
							<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
							<div id="error_product_name" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="description">Product Description</label>
							<textarea class="form-control" id="description" name="description" placeholder="Enter some description about product"></textarea>
							<div id="error_description" style="display:none" class="error"></div>
							<input id="desc" name="desc" type="hidden">
						</div>
						
						<div class="form-group">
							<label for="category">Category</label>
							<select class="form-control" name="category" id="category" onchange="change_relate(this.value)">
							<option value="0">Select</option>
							<?php
								$sel=mysqli_query($con,"select id,category_name from category where is_active='1' order by added_date DESC");
								if(mysqli_num_rows($sel)>0)
								{ 
									while($row=mysqli_fetch_array($sel,MYSQLI_ASSOC))
									{ ?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['category_name'];?></option>
									<?php	
									}															
								}	
							?>
							</select>
							<div id="error_category" style="display:none" class="error"></div>
						</div>
						
						<div class="form-group">
							<label for="price">Price (In AED)</label>
							<input type="text" class="form-control" id="price" name="price" placeholder="Price">
							<div id="error_price" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="sizes">Sizes</label><br/>
							<input type="checkbox" id="size_xs" name="sizes[]" value="xs"><label for="size_xs">XS</label>
							<input type="checkbox" id="size_s" name="sizes[]" value="s"><label for="size_s">S</label>
							<input type="checkbox" id="size_m" name="sizes[]" value="m"><label for="size_m">M</label>
							<input type="checkbox" id="size_l" name="sizes[]" value="l"><label for="size_l">L</label>
							<input type="checkbox" id="size_xl" name="sizes[]" value="xl"><label for="size_xl">XL</label>
							<input type="checkbox" id="size_free_size" name="sizes[]" value="free size"><label for="size_free_size">Free Size</label>
							<div id="error_sizes" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="product_image">Product Images</label>
							<input type="file" class="form-control" id="upload_file" name="upload_file">
							<input type="file" class="form-control" id="upload_file2" name="upload_file2">
							<input type="file" class="form-control" id="upload_file3" name="upload_file3">
							<input type="file" class="form-control" id="upload_file4" name="upload_file4">
							<input type="file" class="form-control" id="upload_file5" name="upload_file5">
							<input type="file" class="form-control" id="upload_file6" name="upload_file6">
							<input type="file" class="form-control" id="upload_file7" name="upload_file7">
							
							<div id="error_upload_file" style="display:none" class="error"></div>
						</div>
						<div class="form-group">
							<label for="Or">OR</label>
						</div>	
						<div class="form-group">
							<label for="youtube">Youtube Url</label>
							<input type="text" class="form-control" id="youtube" name="youtube">
							<input type="file" class="form-control" id="upload_file_vid" name="upload_file_vid">
							
						</div>
						<div class="form-group" id="rel_prod">
							<label for="related_products">Related Products</label>
							<select class="form-control" name="related_products[]" id="related_products" multiple>
							
							</select>
							
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
					  <input type="hidden" id="action" name="action" value="add_product"/>
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
  
  function change_relate(id)
  {
	  $.ajax({
	type: "POST",
	url: "ajax/get_data.php",
	data: 'action=get_related_prod&id='+id,
	cache: false,
	success: function(result){
		
		$("#rel_prod").html(result);
	
	}
});	
  }
  
  $(function () {
	$("#save").click(function(){
	
	var product_name=$("#product_name");
	var price=$("#price");
	var upload_file=$("#upload_file");
	var upload_file2=$("#upload_file2");
	var upload_file3=$("#upload_file3");
	var upload_file4=$("#upload_file4");
	var upload_file5=$("#upload_file5");
	var upload_file6=$("#upload_file6");
	var upload_file7=$("#upload_file7");
	/* var size_xs=$("#size_xs");
	var size_s=$("#size_s");
	var size_m=$("#size_m");
	var size_l=$("#size_l");
	var size_xl=$("#size_xl");
	var size_free_size=$("#size_free_size"); */
	var description=$("#description");
	var category=$("#category");
	var fileExtension = ['jpeg', 'jpg', 'png'];
	var regexp = /^[0-9]+([,.][0-9]+)?$/g;
	
	
	var err=0; 
	if(product_name.val()=="")
	{
		$("#error_product_name").show();
		$("#error_product_name").html("Please enter product name.");
		location.href="#error_product_name";
		err++;
	}
	else
	{
		$("#error_product_name").hide();
	}
	/* if(description.val()=="")
	{
		$("#error_description").show();
		$("#error_description").html("Please enter product description.");
		location.href="#error_description";
		err++;
	}
	else
	{
		$("#error_description").hide();
	} */	
	if(category.val()=="0")
	{
		$("#error_category").show();
		$("#error_category").html("Please select category.");
		location.href="#error_category";
		err++;
	}
	else
	{
		$("#error_category").hide();
	}	
	
	/* if(price.val()=="")
	{
		$("#error_price").html("Please enter price");
		$("#error_price").show();
		err++;
		
	}
	else */ if(price.val()!="" && !regexp.test(price.val()))
	{
		$("#error_price").html("Please enter valid price");
		$("#error_price").show();
		err++;
	}	
	else
	{
		$("#error_price").hide();
	}
	/* if($("#size_xs").is(':checked')!=true && $("#size_s").is(':checked')!=true && $("#size_m").is(':checked')!=true && $("#size_l").is(':checked')!=true && $("#size_xl").is(':checked')!=true && $("#size_free_size").is(':checked')!=true)
	{
		$("#error_sizes").show();
		$("#error_sizes").html("Please select atleast one size.");
		err++;
	}
	else
	{
		$("#error_sizes").hide();
	}	 */
	/* if($('#upload_file').val().length<='0' && $('#upload_file2').val().length<='0' && $('#upload_file3').val().length<='0' && $('#upload_file4').val().length<='0' && $('#upload_file5').val().length<='0')
	{
		$("#error_upload_file").show();
		$("#error_upload_file").html("Please select product image");
		err++;
		return false;
	}
	else */ if(($('#upload_file').val().length > '0' && $.inArray($('#upload_file').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file2').val().length > '0' && $.inArray($('#upload_file2').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file3').val().length > '0' && $.inArray($('#upload_file3').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file4').val().length > '0' && $.inArray($('#upload_file4').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file5').val().length > '0' && $.inArray($('#upload_file5').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file6').val().length > '0' && $.inArray($('#upload_file6').val().split('.').pop().toLowerCase(), fileExtension) == -1) || ($('#upload_file7').val().length > '0' && $.inArray($('#upload_file7').val().split('.').pop().toLowerCase(), fileExtension) == -1)) 
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
		$("#desc").val(tinyMCE.activeEditor.getContent());
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
					$("#msg").html("Product added Successfully.");
					setTimeout(function(){ $("#msg").hide(); location.href="index.php"; }, 3000);
				}	
				else if($.trim(dataofconfirm)=='2')
				{
					$("#msg").removeClass("alert-success");	
					$("#msg").addClass("alert-danger");	
					$("#msg").show();
					$("#msg").html("Error while adding.");
					setTimeout(function(){ $("#msg").hide();}, 3000);
				}
				/* else if($.trim(dataofconfirm)=='3')
				{
					$("#msg").removeClass("alert-success");	
					$("#msg").addClass("alert-danger");	
					$("#msg").show();
					$("#msg").html("Error while uploading image.");
					setTimeout(function(){ $("#msg").hide();}, 3000);
				} */
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