<?php
session_start();
include_once("../../config.php");
if(isset($_POST['action']) && $_POST['action']=="get_members")
{
	
	$sel=mysqli_query($con,"select user_id,CONCAT(firstname,' ',lastname) as name,email,image,is_active from users order by user_id DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Name</th>
								<th>Email</th>								
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			
			?>
				<tr>
					  <td><?php echo $i?></td>
					  <td><?php echo $row_user['name']?></td>
					  <td><?php echo $row_user['email']?></td>
					  <td><?php echo $row_user['is_active']==1 ? "Active" : "Inactive"; ?></td>
					  <td>
					  <a href="view_contacts.php?<?php echo "id=".$row_user['user_id'];?>" title="View Contacts"><i class="fa fa-user"></i></a>
					 &nbsp;|&nbsp;<a href="javascript:void(0)" title="Delete" onclick="delete_user(<?php echo $row_user['user_id']?>)"><i class="fa fa-trash"></i></a>
					 <?php
						if($row_user['is_active']==1)
						{	
						?>
							&nbsp;|&nbsp;<a href="javascript:void(0)" title="Inactive" onclick="inactive_user(<?php echo $row_user['user_id']?>)"><i class="fa fa-times"></i></a>
						<?php
						}
						else
						{	
						?>
							&nbsp;|&nbsp;<a href="javascript:void(0)" title="Active" onclick="active_user(<?php echo $row_user['user_id']?>)"><i class="fa fa-check"></i></a>
						<?php
						}	
						?>
					 </td>
				</tr>
		<?php
			$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Members</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="delete_user")
{
	$del=mysqli_query($con,"delete from users where user_id=".$_POST['id']."");
	if($del)
	{	
		$del1=mysqli_query($con,"delete from user_contacts where user_id=".$_POST['id']."");
		echo 1;
	}
	else 
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="change_user_status")
{
	$up=mysqli_query($con,"update users set is_active=".$_POST['status']." where user_id=".$_POST['id']."");
	if($up)
	{	
		echo 1;
	}
	else 
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="get_contacts")
{
	
	$sel=mysqli_query($con,"select CONCAT(firstname,' ',lastname) as name,email,phone_no,relation,is_active from user_contacts where user_id=".$_REQUEST['id']." order by id DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Name</th>
								<th>Email</th>								
								<th>Phone</th>								
								<th>Relation</th>
								<th>Status</th>
								
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			
			?>
				<tr>
					  <td><?php echo $i?></td>
					  <td><?php echo $row_user['name']?></td>
					  <td><?php echo $row_user['email']!="" ? $row_user['email'] : "N/A"?></td>
					  <td><?php echo $row_user['phone_no']!="" ? $row_user['phone_no'] : "N/A";?></td>
					  <td><?php echo $row_user['relation']!="" ? $row_user['relation'] : "N/A";?></td>
					  <td><?php echo $row_user['is_active']==1 ? "Active" : "Inactive"; ?></td>
					  
				</tr>
		<?php
			$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Contacts</div>
		<?php
	}	
}




else if(isset($_POST['action']) && $_POST['action']=="get_products_arrange")
{
	$sel=mysqli_query($con,"select * from product order by sort_order,last_updated ASC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
		<ul id="sortable">
						
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			$img_path="";
			if($row_user['image_path']!="")
			{
				$img=explode(",",$row_user['image_path']);
				$img_path=$img[0];
			}
				
			
			?>
			<li class="ui-state-default" id="<?php echo $row_user['product_id']; ?>" style="height:50px;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $row_user['product_name']?>
			<?php
						if($img_path!="")
						{  
					  ?>
					  <img src="<?php echo "../images/".$img_path?>" height="50" width="50"></img>
					  <?php
						}
						else
							echo "N/A";
					  ?>
			
			</li>
				
		<?php
			
		}
		echo "</ul>";
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Products</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="get_images_arrange")
{
	$sel=mysqli_query($con,"select image_path from product where product_id='".$_POST['product_id']."'");
	if(mysqli_num_rows($sel)>0)
	{
		$row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC);
		$image_path=explode(",",$row_user['image_path']);
		
		?>
		
		<ul id="sortable">
						
		
		<?php
			foreach($image_path as $img_path)
			{	
			?>
				<li class="ui-state-default" id="<?php echo $img_path; ?>" style="height:50px;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
				<?php
							if($img_path!="")
							{  
						  ?>
						  <img src="<?php echo "../images/".$img_path?>" height="50" width="50"></img>
						  <?php
							}
							else
								echo "N/A";
						  ?>
				
				</li>
				
		<?php
			}
			
		echo "</ul>";
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Products</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="get_banner_products_arrange")
{
	$sel=mysqli_query($con,"select * from product where is_banner='1' order by banner_sort_order,last_updated ASC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
		<ul id="sortable">
						
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			$img_path="";
			if($row_user['image_path']!="")
			{
				$img=explode(",",$row_user['image_path']);
				$img_path=$img[0];
			}
				
			
			?>
			<li class="ui-state-default" id="<?php echo $row_user['product_id']; ?>" style="height:50px;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $row_user['product_name']?>
			<?php
						if($img_path!="")
						{  
					  ?>
					  <img src="<?php echo "../images/".$img_path?>" height="50" width="50"></img>
					  <?php
						}
						else
							echo "N/A";
					  ?>
			
			</li>
				
		<?php
			
		}
		echo "</ul>";
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Products</div>
		<?php
	}	
}

else if(isset($_POST['action']) && $_POST['action']=="arrange_images")
{
	if($_POST['data']!="")
	{
		$total_sort="";
		$data=explode(",",rtrim($_POST['data'],","));
		if(sizeof($data) > 0)
		{
			for($i=0;$i<=sizeof($data);$i++)
			{
				if(isset($data[$i]))
				{	
					$dt=explode("=",$data[$i]);
					$total_sort.=$dt[0].",";
				}
			}
			
			$update=mysqli_query($con,"update product set image_path='".rtrim($total_sort,',')."' where product_id=".$_POST['product_id']."");
			
			//echo 1;
		}
		else
			echo 0;	
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="arrange_products")
{
	if($_POST['data']!="")
	{
		
		$data=explode(",",rtrim($_POST['data'],","));
		if(isset($data) && sizeof($data) > 0)
		{
			for($i=0;$i<=sizeof($data);$i++)
			{
				$dt=explode("=",$data[$i]);
				$update=mysqli_query($con,"update product set sort_order=".$dt[1]." where product_id=".$dt[0]."");
				
			}	
			echo 1;
		}
		else
			echo 0;	
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="arrange_banner_products")
{
	if($_POST['data']!="")
	{
		
		$data=explode(",",rtrim($_POST['data'],","));
		if(sizeof($data) > 0)
		{
			$update1=mysqli_query($con,"update product set banner_sort_order='0'");
			if($update1)
			{	
				for($i=0;$i<=sizeof($data);$i++)
				{
					$dt=explode("=",$data[$i]);
					$update=mysqli_query($con,"update product set banner_sort_order=".$dt[1]." where product_id=".$dt[0]." and is_banner='1'");
					
				}	
				echo 1;
			}
			else
				echo 0;	
		}
		else
			echo 0;	
	}	
}	
else if(isset($_POST['action']) && $_POST['action']=="get_orders")
{
	$sel=mysqli_query($con,"select o.*,CONCAT(u.firstname,' ',u.lastname) as uname,u.phone,u.email from orders o INNER JOIN users u ON o.user_id=u.user_id order by o.order_date DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Cutomer</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Total</th>
								<th>Address</th>
								<th>Date</th>
								<th>Last Updated</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			$status="";
			$last_updated="N/A";
			if($row_user['status']==1)
				$status="Ordered";
			else if($row_user['status']==2)
			{	
				$status="Canceled";	
				$last_updated=$row_user['cancled_on'];
			}
			else if($row_user['status']==3)
			{	
				$status="Delivered";	
				$last_updated=$row_user['delivered_on'];
			}
			?>
				<tr>
					  <td><?php echo $i?></td>
					  <td><?php echo $row_user['uname']?></td>
					  <td><?php echo $row_user['phone']?></td>
					  <td><?php echo $row_user['email']?></td>
					  <td><?php echo $row_user['total_amt']?></td>
					  <td><?php echo $row_user['address']?></td>
					  <td><?php echo $row_user['order_date']?></td>
					  <td><?php echo $last_updated?></td>
					  <td><?php echo $status?></td>
					  <td><a href="order_details.php?<?php echo "id=".$row_user['order_id'];?>" title="View"><i class="fa fa-eye"></i></a>&nbsp;|&nbsp;<a href="javascript:void(0)" title="Cancel" onclick="cancel_order(<?php echo $row_user['order_id']?>)"><i class="fa fa-trash"></i></a>&nbsp;|&nbsp;<a href="javascript:void(0)" title="Deliver" onclick="deliver_order(<?php echo $row_user['order_id']?>)"><i class="fa fa-truck"></i></td>
				</tr>
		<?php
			$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Orders</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="get_order_details")
{
	$sel=mysqli_query($con,"select o.*,p.product_name from order_details o LEFT JOIN product p ON o.product_id=p.product_id group by o.details_id order by o.details_id ASC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Product</th>
								<th>Size</th>
								<th>Quantity</th>
								<th>Total Amt</th>
							</tr>
						</thead>
						<tbody>	
		
		<?php
		
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			$status="";
			if($row_user['status']==1)
				$status="Ordered";
			else if($row_user['status']==2)
				$status="Canceled";	
			else if($row_user['status']==3)
				$status="Delivered";	
			
			?>
				<tr>
					  <td><?php echo $row_user['product_name']?></td>
					  <td><?php echo $row_user['size']!="undefined" ? strtoupper($row_user['size']) : "N/A";?></td>
					  <td><?php echo $row_user['qantity']?></td>
					  <td><?php echo $row_user['total_amt']?></td>
				</tr>
		<?php
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Orders</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="cancel_order")
{
	$sel_ord=mysqli_query($con,"select u.email,CONCAT(u.firstname,' ',u.lastname) as name from orders o LEFT JOIN users u ON o.user_id=u.user_id");
	$row_ord=mysqli_fetch_array($sel_ord,MYSQL_ASSOC);
	
	$can=mysqli_query($con,"update orders set status='2',cancled_on='".date('Y-m-d')."' where order_id=".$_POST['id']."");
	if($can)
	{
		echo 1;
		$to=$row_ord['email'];
		$subject = "Bokshat - Order Cancled";
		$message = "Dear ".$row_ord['name'].",<br/><br/> Your order number :".$_POST['id']." has been canceled by bokshat admin.<br/><br/>For more detials please contact us on info @bokshat.com";
		$from = $site_mail;
		
		
		// Additional headers
		$headers= 'From: '.$from."\r\n";
		$headers.= 'MIME-Version: 1.0' . "\r\n";
		$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		
		
		mail($to,$subject,$message,$headers);
	}
	else	
		echo 2;	
}
else if(isset($_POST['action']) && $_POST['action']=="deliver_order")
{
	$sel_ord=mysqli_query($con,"select u.email,CONCAT(u.firstname,' ',u.lastname) as name from orders o LEFT JOIN users u ON o.user_id=u.user_id");
	$row_ord=mysqli_fetch_array($sel_ord,MYSQL_ASSOC);
	
	$can=mysqli_query($con,"update orders set status='3',delivered_on='".date('Y-m-d')."' where order_id=".$_POST['id']."");
	if($can)
	{
		echo 1;
		$to=$row_ord['email'];
		$subject = "Bokshat - Order Delivered";
		$message = "Dear ".$row_ord['name'].",<br/><br/> Your order number :".$_POST['id']." has been delivered by bokshat on ".date('Y-m-d').".<br/><br/>For more detials please contact us on info @bokshat.com";
		$from = $site_mail;
		
		
		// Additional headers
		$headers= 'From: '.$from."\r\n";
		$headers.= 'MIME-Version: 1.0' . "\r\n";
		$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		
		
		mail($to,$subject,$message,$headers);
	}
	else	
		echo 2;	
}
else if(isset($_POST['action']) && $_POST['action']=="add_product")
{
	$dest_name="";
	if($_POST['youtube']=="")
	{
		if($_FILES["upload_file"]["name"]!="")
		{
			$file=time()."_".$_FILES["upload_file"]["name"];
			if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],"../../images/".$file))
			{
				$dest_name.=$file.",";
			
				$file_path="../../images/".$file;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file,200);
				imagedestroy($thumb);
				
				
				
			}		
		}	
		if($_FILES["upload_file2"]["name"]!="")
		{
			$file2=time()."_".$_FILES["upload_file2"]["name"];
			if(move_uploaded_file($_FILES["upload_file2"]["tmp_name"],"../../images/".$file2))
			{
				$dest_name.=$file2.",";	
				
				$file_path="../../images/".$file2;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file2,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file2,200);
				imagedestroy($thumb);
			}		
		}
		if($_FILES["upload_file3"]["name"]!="")
		{
			$file3=time()."_".$_FILES["upload_file3"]["name"];
			if(move_uploaded_file($_FILES["upload_file3"]["tmp_name"],"../../images/".$file3))
			{
				$dest_name.=$file3.",";	
				
				
				$file_path="../../images/".$file3;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file3,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file3,200);
				imagedestroy($thumb);
			}		
		}
		if($_FILES["upload_file4"]["name"]!="")
		{
			$file4=time()."_".$_FILES["upload_file4"]["name"];
			if(move_uploaded_file($_FILES["upload_file4"]["tmp_name"],"../../images/".$file4))
			{
				$dest_name.=$file4.",";	
				
				$file_path="../../images/".$file4;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file4,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file4,200);
				imagedestroy($thumb);
			}		
		}
		if($_FILES["upload_file5"]["name"]!="")
		{
			$file5=time()."_".$_FILES["upload_file5"]["name"];
			if(move_uploaded_file($_FILES["upload_file5"]["tmp_name"],"../../images/".$file5))
			{
				$dest_name.=$file5.",";	
				
				
				$file_path="../../images/".$file5;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file5,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file5,200);
				imagedestroy($thumb);
			}		
		}
		if($_FILES["upload_file6"]["name"]!="")
		{
			$file6=time()."_".$_FILES["upload_file6"]["name"];
			if(move_uploaded_file($_FILES["upload_file6"]["tmp_name"],"../../images/".$file6))
			{
				$dest_name.=$file6.",";	
				
				
				$file_path="../../images/".$file6;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file6,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file6,200);
				imagedestroy($thumb);
			}		
		}
		if($_FILES["upload_file7"]["name"]!="")
		{
			$file7=time()."_".$_FILES["upload_file7"]["name"];
			if(move_uploaded_file($_FILES["upload_file7"]["tmp_name"],"../../images/".$file7))
			{
				$dest_name.=$file7.",";	
				
				
				$file_path="../../images/".$file7;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file7,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file7,200);
				imagedestroy($thumb);
			}		
		}
	}
	$sizes="";	
	if(isset($_POST['sizes']))
	{	
		$sz=$_POST['sizes']!="" ? $_POST['sizes'] : "";
		if(sizeof($sz)>0)
		{
			foreach($sz as $sz1)
			{
				$sizes.=$sz1.",";
			}
			$sizes=rtrim($sizes,",");
		}		
	}	
	
	$price=$_POST['price']!="" ? $_POST['price'] : 0; 
		$youtube_url="";
		if($_POST['youtube']!="")
		{	
			if (strpos($_POST['youtube'], 'v=') !== false) {
				$youtube_url=ltrim(substr($_POST['youtube'], strrpos($_POST['youtube'], 'v=') + 1),"=");
			}
			else
			{
				$youtube_url=substr($_POST['youtube'], strrpos($_POST['youtube'], '/') + 1);
			}
			
			if($_FILES["upload_file_vid"]["name"]!="")
			{
				$file_vid=time()."_".$_FILES["upload_file_vid"]["name"];
				if(move_uploaded_file($_FILES["upload_file_vid"]["tmp_name"],"../../images/".$file_vid))
				{
					$dest_name=$file_vid;	
					
					
					$file_path="../../images/".$file_vid;
					$filename = $file_path;
					//the resize will be a percent of the original size
					$percent = 0.5;

					// Content type
					//header('Content-Type: image/jpeg');

					// Get new sizes
					list($width, $height) = getimagesize($filename);
					$newwidth = 300;//$width * $percent;
					$newheight = 400;//$height * $percent;

					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($filename);

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					// Output and free memory
					//the resized image will be 400x300
					imagejpeg($thumb,"../../images/300/".$file_vid,200);
					imagedestroy($thumb);
					
					
					$newwidth = 250;//$width * $percent;
					$newheight = 300;//$height * $percent;

					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($filename);

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					// Output and free memory
					//the resized image will be 400x300
					imagejpeg($thumb,"../../images/250/".$file_vid,200);
					imagedestroy($thumb);
				}		
			}
			
			
			
		}
		$ins=mysqli_query($con,"insert into product (product_name,description,category,price,image_path,youtube_url,sizes,date_of_added,last_updated,is_active) values('".addslashes($_POST['product_name'])."','".addslashes($_POST['desc'])."',".$_POST['category'].",'".$price."','".rtrim($dest_name,",")."','".$youtube_url."','".$sizes."','".$_TODAY."','".$_TODAY."','".$_POST['is_active']."')");
		if($ins)
		{
			$ins_id=mysqli_insert_id($con);
			if(isset($_POST['related_products']) && sizeof($_POST['related_products']) > 0)
			{
				$rel_prod=$_POST['related_products'];
				foreach($rel_prod as $rel_id)
				{
					mysqli_query($con,"insert into related_products (prod_id,relate_prod) values(".$ins_id.",".$rel_id.")");
				}
			}
			echo 1;
		}
		else
			echo 2;	
	
		
}	
else if(isset($_POST['action']) && $_POST['action']=="edit_product")
{
	
	$odl_fl="";
	$dest_name="";
	
	if($_POST['youtube']=="")
	{
		if($_FILES["upload_file"]["name"]!="")
		{
			$file=time()."_".$_FILES["upload_file"]["name"];
			if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],"../../images/".$file))
			{
				$dest_name=$file.",";	
				
				$file_path="../../images/".$file;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file,200);
				imagedestroy($thumb);
			}		
		}	
		$old_file=explode(",",ltrim($_POST['old_file'],","));
		if($_POST['removed_img']!="")
		{
			$rm_img=explode("|",$_POST['removed_img']);
			if(sizeof($rm_img)>0)
			{
				foreach($rm_img as $key => $value) {

				  if(in_array($value, $old_file)) {  
					unset($old_file[$key]);
				  }

				}	
			}	
		}
		if(sizeof($old_file)>0)
		{
			$odl_fl=implode(",",$old_file);
		}		
		if($dest_name!="")
			$odl_fl=$odl_fl.",".$dest_name;
		
		$odl_fl=rtrim($odl_fl,",");
		$odl_fl=ltrim($odl_fl,",");
	}
	else
		$odl_fl=ltrim($_POST['old_file'],",");
	
	
	
	$sizes="";	
	if(isset($_POST['sizes']))
	{	
		$sz=$_POST['sizes']!="" ? $_POST['sizes'] : "";
		if(sizeof($sz)>0)
		{
			foreach($sz as $sz1)
			{
				$sizes.=$sz1.",";
			}
			$sizes=rtrim($sizes,",");
		}		
	}
		$is_banner="";
		$youtube_url="";
		if($_POST['youtube']!="")
		{	
			if (strpos($_POST['youtube'], 'v=') !== false) {
				$youtube_url=ltrim(substr($_POST['youtube'], strrpos($_POST['youtube'], 'v=') + 1),"=");
			}
			else
			{
				$youtube_url=substr($_POST['youtube'], strrpos($_POST['youtube'], '/') + 1);
			}
			
			$is_banner=",is_banner='0'";
			
			if($_FILES["upload_file_vid"]["name"]!="")
			{
				$file_vid=time()."_".$_FILES["upload_file_vid"]["name"];
				if(move_uploaded_file($_FILES["upload_file_vid"]["tmp_name"],"../../images/".$file_vid))
				{
					$dest_name=$file_vid;	
					
					
					$file_path="../../images/".$file_vid;
					$filename = $file_path;
					//the resize will be a percent of the original size
					$percent = 0.5;

					// Content type
					//header('Content-Type: image/jpeg');

					// Get new sizes
					list($width, $height) = getimagesize($filename);
					$newwidth = 300;//$width * $percent;
					$newheight = 400;//$height * $percent;

					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($filename);

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					// Output and free memory
					//the resized image will be 400x300
					imagejpeg($thumb,"../../images/300/".$file_vid,200);
					imagedestroy($thumb);
					
					
					$newwidth = 250;//$width * $percent;
					$newheight = 300;//$height * $percent;

					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($filename);

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					// Output and free memory
					//the resized image will be 400x300
					imagejpeg($thumb,"../../images/250/".$file_vid,200);
					imagedestroy($thumb);
					$odl_fl=$dest_name;
				}
					
			}
			
			
		}
		
		$price=$_POST['price']!="" ? $_POST['price'] : 0; 
		$ins=mysqli_query($con,"update product set product_name='".addslashes($_POST['product_name'])."',description='".addslashes($_POST['desc'])."',category=".$_POST['category'].",price='".$price."',image_path='".addslashes($odl_fl)."',youtube_url='".$youtube_url."',sizes='".$sizes."',last_updated='".$_TODAY."',is_active='".$_POST['is_active']."' $is_banner where product_id=".$_POST['id']."");
		if($ins)
		{
			
			if(sizeof($_POST['related_products']) > 0)
			{
				$del=mysqli_query($con,"delete from related_products where prod_id=".$_POST['id']."");
				if($del)
				{	
					$rel_prod=$_POST['related_products'];
					foreach($rel_prod as $rel_id)
					{
						mysqli_query($con,"insert into related_products (prod_id,relate_prod) values(".$_POST['id'].",".$rel_id.")");
					}
				}
			}
			echo 1;
		}
		else
			echo 2;	
	
}
else if(isset($_POST['action']) && $_POST['action']=="delete_product")
{
	$del=mysqli_query($con,"delete from product where product_id=".$_POST['id']."");
	if($del)
		echo 1;
	else 
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="set_banner")
{
	$upd=mysqli_query($con,"update product set is_banner='1' where product_id=".$_POST['id']."");
	if($upd)
		echo 1;
	else 
		echo 2;
		
}
else if(isset($_POST['action']) && $_POST['action']=="remove_banner")
{
	$upd=mysqli_query($con,"update product set is_banner='0' where product_id=".$_POST['id']."");
	if($upd)
		echo 1;
	else 
		echo 2;
		
}

else if(isset($_POST['action']) && $_POST['action']=="add_to_cart")
{
	if($_POST['user_id'] > 0)
	{
		if(!isset($_POST['size']) || $_POST['size']=="undefined")
			$size_o="N/A";
		else
			$size_o=$_POST['size'];
		$select=mysqli_query($con,"select quantity,cart_id,size from cart where user_id=".$_POST['user_id']." and product_id=".$_POST['id']." and size='".$size_o."' and is_active='1'");
		if(mysqli_num_rows($select)>0)
		{
			$row_qt=mysqli_fetch_array($select,MYSQLI_ASSOC);
			$qantity=$row_qt['quantity']+$_POST['quantity'];
			$update=mysqli_query($con,"update cart set quantity='".$qantity."' where cart_id=".$row_qt['cart_id']."");
		}
		else
		{
			$update=mysqli_query($con,"insert into cart (user_id,product_id,quantity,size) values(".$_POST['user_id'].",".$_POST['id'].",'".$_POST['quantity']."','".$size_o."')");
		}
		if($update)
			echo 1;
		else
			echo 2;	
	}	
	else
	{
		
		$_SESSION['cart'][]=array("product_id"=>$_POST['id'],"quantity"=>$_POST['quantity'],"size"=>$_POST['size']);
		
		
		
		
		
		if(sizeof($_SESSION['cart']) > 0)
			echo 1;
		else
			echo 2;			
	}	
	
}
else if(isset($_POST['action']) && $_POST['action']=="remove_cart")
{
	$del=mysqli_query($con,"delete from cart where cart_id=".$_POST['cart_id']."");
	if($del)
		echo 1;
	else 
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="checkout")
{	global $con;
	$product=$_POST['product'];
	if(sizeof($product)>0)
	{
		$cart_amt=$_POST['cart_amt'];
		$size=$_POST['size'];
		$price=$_POST['price'];
		$address=$_POST['address'];
		$total_cart_value=$_POST['total_cart_value'];
		$qtyinput=$_POST['qtyinput'];
		$cart_ids=$_POST['cart_ids'];
		$pro_stock=0;
		$next_pro_id="";
		
		for($j=0;$j<sizeof($product);$j++)
		{
			$next_pro_id[$product[$j]][]=$qtyinput[$j];
		}
		
		
		$sumArray = array();

	foreach ($next_pro_id as $k=>$subArray) {
	  foreach ($subArray as $id=>$value) {
		$sumArray[$k]+=$value;
	  }
	}
	$prod_names="";
foreach ($sumArray as $key=>$value) {
	
	
	$chk=mysqli_query($con,"select product_name,stock from product where product_id=".$key."");
	if(mysqli_num_rows($chk) > 0)
	{
		$row_st=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		if($row_st['stock'] < $value)
		{
			$pro_stock++;
			$prod_names.=$row_st['product_name'].",";
		}	
	}
}	

		if($pro_stock > 0)
		{
			echo "4##_##".rtrim($prod_names,",");//Quantity not available
			exit;
		}
		else
		{
			foreach ($sumArray as $key=>$value) {
			$chk=mysqli_query($con,"select stock from product where product_id=".$key."");
				if(mysqli_num_rows($chk) > 0)
				{
					$row_st=mysqli_fetch_array($chk,MYSQLI_ASSOC);
					$new_stock=$row_st['stock']-$value;
					$new_stock=$new_stock >=0 ? $new_stock : "0";
					$update=mysqli_query($con,"update product set stock=".$new_stock." where product_id=".$key."");
				}
			}
		}	
		
		$ins=mysqli_query($con,"insert into orders (user_id,total_amt,order_date,address) values(".$_SESSION['user_id'].",'".$total_cart_value."','".date('Y-m-d')."','".addslashes($address)."')");
		$ins_id=mysqli_insert_id($con);
		$a=0;
		$msg="<table>
		<tr>
		<th>Name</th>
		<th>Size</th>
		<th>Qty</th>
		<th>Amt</th>
		</tr>
		";
		for($i=0;$i<sizeof($product);$i++)
		{
			if($size[$i]=="" || $size[$i]=="undefined")
				$size_o="N/A";
			else
				$size_o=$size[$i];
			
			$ins1=mysqli_query($con,"insert into order_details (order_id,product_id,size,qantity,total_amt) values(".$ins_id.",".$product[$i].",'".$size_o."','".$qtyinput[$i]."','".$cart_amt[$i]."')");	
			if($ins1)
			{	
				$a++;
			
				$sel_pro=mysqli_query($con,"select product_name from product where product_id=".$product[$i]."");$row_pr=mysqli_fetch_array($sel_pro,MYSQL_ASSOC);		
				$msg.="<tr>
					<td>".$row_pr['product_name']."</td>
					<td>".$size_o."</td>
					<td>".$qtyinput[$i]."</td>
					<td>".$cart_amt[$i]."</td>
				</tr>";
				$del=mysqli_query($con,"delete from cart where cart_id=".$cart_ids[$i]."");
			}
		}
		$msg.="</table>";
		if($ins && $a > 0)
		{
			echo 1;
			
			$sel=mysqli_query($con,"select * from users where user_id=".$_SESSION['user_id']."");
			$row=mysqli_fetch_array($sel,MYSQL_ASSOC);
			$to=$row['email'];
			$subject = "Bokshat - Order Details";
			$message = "Your order details:<br/><br/>
			
			On: ".date('Y-m-d')."<br/>
			From Name : ".$row['firstname'].' '.$row['lastname']."<br/>
			Details : <br/><br/>
			".$msg;
			$from = $site_mail;
			
			
			// Additional headers
			$headers= 'From: '.$from."\r\n";
			$headers.= 'MIME-Version: 1.0' . "\r\n";
			$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			
			
			mail($to,$subject,$message,$headers);
		}
		else
		{
			echo 2;
		}		
	}
	else
	{
		echo 3;
	}		
}
else if(isset($_POST['action']) && $_POST['action']=="contactus")
{
	
	$to=$site_mail;
	$subject = "Bokshat - Contact";
	$message = "Some one is contacted you:<br/><br/>
	
	On: ".date('Y-m-d H:i:s')."<br/>
	Name : ".$_POST['firstname'].' '.$_POST['lastname']."<br/>
	Comment : ".$_POST['comment'];
	$from = $_POST['email'];
	
	
	// Additional headers
	$headers= 'From: '.$from."\r\n";
	$headers.= 'MIME-Version: 1.0' . "\r\n";
	$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	
	
	mail($to,$subject,$message,$headers);
	echo 1;
}
else if(isset($_POST['action']) && $_POST['action']=="signup")
{
	$chk=mysqli_query($con,"select user_id from users where email='".$_POST['email']."'");
	if(mysqli_num_rows($chk)>0)
	{
		echo 3;
	}
	else
	{
		$ins=mysqli_query($con,"insert into users (firstname,lastname,email,password,phone,added_date) values('".addslashes($_POST['firstname'])."','".addslashes($_POST['lastname'])."','".addslashes($_POST['email'])."','".md5($_POST['password'])."','".$_POST['phoneno']."','".date('Y-m-d H:i:s')."')");
		if($ins)
			echo 1;
		else
			echo 2;
	}		
}
else if(isset($_POST['action']) && $_POST['action']=="get_categories")
{
	$sel=mysqli_query($con,"select * from category order by added_date DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Name</th>
								<th>Added Date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
				
			?>
				<tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo $row_user['category_name']?></td>
					  <td><?php echo $row_user['added_date']?></td>
					  <td><?php echo $row_user['is_active']==1 ? "Active" : "Inactive"; ?></td>
					  <td>
					  <a href="edit_category.php?<?php echo "id=".$row_user['id'];?>" title="Edit"><i class="fa fa-edit"></i></a>
					  &nbsp;|&nbsp;<a href="javascript:void(0)" title="Delete" onclick="delete_category(<?php echo $row_user['id']?>)"><i class="fa fa-trash"></i></a>
					  </td>
				</tr>
		<?php
		$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Category</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="add_category")
{
	$ins=mysqli_query($con,"insert into category (category_name,added_date,is_active) values('".addslashes($_POST['category_name'])."','".date('Y-m-d H:i:s')."',".$_POST['is_active'].")");
	if($ins)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="edit_category")
{
	$ins=mysqli_query($con,"update category set category_name='".$_POST['category_name']."',added_date='".date('Y-m-d H:i:s')."',is_active=".$_POST['is_active']." where id=".$_POST['id']."");
	if($ins)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="delete_category")
{
	$ins=mysqli_query($con,"delete from category where id=".$_POST['id']."");
	if($ins)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="get_news")
{
	$sel=mysqli_query($con,"select * from news order by added_date DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Title</th>
								<th>Image</th>
								<th>Added Date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
			
			?>
				<tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo $row_user['title']?></td>
					  
					  <td><img src="<?php echo "../images/". $row_user['image_path'];?>" height="50" width="50"></img></td>
					  <td><?php echo $row_user['added_date']?></td>
					  <td><?php echo $row_user['is_active']==1 ? "Active" : "Inactive"; ?></td>
					  <td><a href="edit_news.php?<?php echo "id=".$row_user['news_id'];?>" title="Edit"><i class="fa fa-edit"></i></a>
					  &nbsp;|&nbsp;<a href="javascript:void(0)" title="Delete" onclick="delete_news(<?php echo $row_user['news_id']?>)"><i class="fa fa-trash"></i></a>
					  
					  </td>
				</tr>
		<?php
			$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No News</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="add_news")
{
	$dest_name="";
	$youtube_url="";
		if($_POST['youtube']!="")
		{	
			if (strpos($_POST['youtube'], 'v=') !== false) {
				$youtube_url=ltrim(substr($_POST['youtube'], strrpos($_POST['youtube'], 'v=') + 1),"=");
			}
			else
			{
				$youtube_url=substr($_POST['youtube'], strrpos($_POST['youtube'], '/') + 1);
			}
		}	
		if($_FILES["upload_file"]["name"]!="")
		{
			$file_vid=time()."_".$_FILES["upload_file"]["name"];
			if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],"../../images/".$file_vid))
			{
				$dest_name=$file_vid;	
				
				
				$file_path="../../images/".$file_vid;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file_vid,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file_vid,200);
				imagedestroy($thumb);
			}		
		}
			
			
			
		
	
	
	if($dest_name!="")
	{	
		$ins=mysqli_query($con,"insert into news (title,description,image_path,youtube_url,added_date,is_active) values('".addslashes($_POST['title'])."','".addslashes($_POST['description'])."','".$dest_name."','".$youtube_url."','".$_TODAY."','".$_POST['is_active']."')");
		if($ins)
			echo 1;
		else
			echo 2;	
	}
	else
		echo 3;
		
}
else if(isset($_POST['action']) && $_POST['action']=="edit_news")
{
	
	$dest_name="";
	$youtube_url="";
	if($_POST['youtube']!="")
	{	
		if (strpos($_POST['youtube'], 'v=') !== false) {
			$youtube_url=ltrim(substr($_POST['youtube'], strrpos($_POST['youtube'], 'v=') + 1),"=");
		}
		else
		{
			$youtube_url=substr($_POST['youtube'], strrpos($_POST['youtube'], '/') + 1);
		}
	}
	if($_FILES["upload_file"]["name"]!="")
		{
			$file_vid=time()."_".$_FILES["upload_file"]["name"];
			if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],"../../images/".$file_vid))
			{
				$dest_name=$file_vid;	
				
				
				$file_path="../../images/".$file_vid;
				$filename = $file_path;
				//the resize will be a percent of the original size
				$percent = 0.5;

				// Content type
				//header('Content-Type: image/jpeg');

				// Get new sizes
				list($width, $height) = getimagesize($filename);
				$newwidth = 300;//$width * $percent;
				$newheight = 400;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/300/".$file_vid,200);
				imagedestroy($thumb);
				
				
				$newwidth = 250;//$width * $percent;
				$newheight = 300;//$height * $percent;

				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);

				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

				// Output and free memory
				//the resized image will be 400x300
				imagejpeg($thumb,"../../images/250/".$file_vid,200);
				imagedestroy($thumb);
			}		
		}
	else
		$dest_name=$_POST['old_file'];
	
	
		$ins=mysqli_query($con,"update news set title='".addslashes($_POST['title'])."',description='".addslashes($_POST['description'])."',image_path='".addslashes($dest_name)."',youtube_url='".$youtube_url."',added_date='".$_TODAY."',is_active='".$_POST['is_active']."' where news_id=".$_POST['id']."");
		if($ins)
			echo 1;
		else
			echo 2;	
	
}
else if(isset($_POST['action']) && $_POST['action']=="delete_news")
{
	$sql_del=mysqli_query($con,"delete from news where news_id=".$_POST['id']);
	if($sql_del)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="add_stock")
{
	$ins=mysqli_query($con,"insert into stock (product_id,stock_type,stock_amt,added_date) values('".$_POST['id']."','1','".$_POST['stock_update']."','".date('Y-m-d H:i:s')."')");
	if($ins)
	{
		$stock=$_POST['stock_now']+$_POST['stock_update'];
		$update=mysqli_query($con,"update product set stock=".$stock." where product_id=".$_POST['id']."");
	}	
	
	if($ins && $update)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="remove_stock")
{
	$ins=mysqli_query($con,"insert into stock (product_id,stock_type,stock_amt,added_date) values('".$_POST['id']."','2','".$_POST['stock_update']."','".date('Y-m-d H:i:s')."')");
	if($ins)
	{
		$stock=$_POST['stock_now']-$_POST['stock_update'];
		
		if($stock < 0)
			$stock=0;
		
		$update=mysqli_query($con,"update product set stock=".$stock." where product_id=".$_POST['id']."");
	}	
	
	if($ins && $update)
		echo 1;
	else
		echo 2;
}
else if(isset($_POST['action']) && $_POST['action']=="rating")
{
	$chk=mysqli_query($con,"select id from ratings where user_id=".$_POST['user_id']." and product_id=".$_POST['product_id']."");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update ratings set rating=".$_POST['rating_val']." where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into ratings (user_id,product_id,rating,added_date) values(".$_POST['user_id'].",".$_POST['product_id'].",".$_POST['rating_val'].",'".date('Y-m-d H:i:s')."')");
	}	

	$total_rate=0;
	$total_rate=mysqli_query($con,"select SUM(rating) as rate,COUNT(user_id) as uid from ratings where product_id=".$_POST['product_id']."");
	if(mysqli_num_rows($total_rate)>0)
	{
		$row_tot_rate=mysqli_fetch_array($total_rate);
		if($row_tot_rate['rate']>0)
			$total_rate=round($row_tot_rate['rate']/$row_tot_rate['uid']);
		else
			$total_rate=0;
		
	}
	
	if($total_rate > 0)
	{
	?>
		<?php
		for($i=0;$i < $total_rate;$i++)
		{	
		?>
		<a href="javascript:void(0);"> <i class="fa fa_star"></i> </a> 
		<?php
		}
		?>
		
	<?php
	}
	else
		echo "N/A";
	
}	
else if(isset($_POST['action']) && $_POST['action']=="add_about_us")
{
	$chk=mysqli_query($con,"select id from about_us where type='about'");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update about_us set description='".addslashes($_POST['desc'])."',last_updated='".date('Y-m-d H:i:s')."' where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into about_us (description,type,last_updated) values('".addslashes($_POST['desc'])."','about','".date('Y-m-d H:i:s')."')");
	}
	if($up)
		echo 1;
	else
		echo 2;	
		
}	

else if(isset($_POST['action']) && $_POST['action']=="add_privacy_policy")
{
	$chk=mysqli_query($con,"select id from about_us where type='privacy'");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update about_us set description='".addslashes($_POST['desc'])."',last_updated='".date('Y-m-d H:i:s')."' where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into about_us (description,type,last_updated) values('".addslashes($_POST['desc'])."','privacy','".date('Y-m-d H:i:s')."')");
	}
	if($up)
		echo 1;
	else
		echo 2;	
		
}	
else if(isset($_POST['action']) && $_POST['action']=="add_mordan_designs")
{
	$chk=mysqli_query($con,"select id from about_us where type='mordan_designs'");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update about_us set description='".addslashes($_POST['desc'])."',last_updated='".date('Y-m-d H:i:s')."' where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into about_us (description,type,last_updated) values('".addslashes($_POST['desc'])."','mordan_designs','".date('Y-m-d H:i:s')."')");
	}
	if($up)
		echo 1;
	else
		echo 2;	
		
}	

else if(isset($_POST['action']) && $_POST['action']=="add_standard_delivery")
{
	$chk=mysqli_query($con,"select id from about_us where type='standard_delivery'");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update about_us set description='".addslashes($_POST['desc'])."',last_updated='".date('Y-m-d H:i:s')."' where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into about_us (description,type,last_updated) values('".addslashes($_POST['desc'])."','standard_delivery','".date('Y-m-d H:i:s')."')");
	}
	if($up)
		echo 1;
	else
		echo 2;	
		
}

else if(isset($_POST['action']) && $_POST['action']=="add_cash_on_delivery")
{
	$chk=mysqli_query($con,"select id from about_us where type='cash_on_delivery'");
	if(mysqli_num_rows($chk)>0)
	{
		$row=mysqli_fetch_array($chk,MYSQLI_ASSOC);
		$up=mysqli_query($con,"update about_us set description='".addslashes($_POST['desc'])."',last_updated='".date('Y-m-d H:i:s')."' where id=".$row['id']."");
	}
	else
	{
		$up=mysqli_query($con,"insert into about_us (description,type,last_updated) values('".addslashes($_POST['desc'])."','cash_on_delivery','".date('Y-m-d H:i:s')."')");
	}
	if($up)
		echo 1;
	else
		echo 2;	
		
}
else if(isset($_POST['action']) && $_POST['action']=="delete_order")
{
	$chk=mysqli_query($con,"delete from orders where order_id=".$_POST['order_id']."");
	if($chk)
	{
		$chk1=mysqli_query($con,"delete from order_details where order_id=".$_POST['order_id']."");
		echo 1;
	}
	else
		echo 2;	
		
}
else if(isset($_POST['action']) && $_POST['action']=="get_related_prod")
{ ?>
	<label for="related_products">Related Products</label>
	<select class="form-control" name="related_products[]" id="related_products" multiple>
	<?php
		$sel_prod=mysqli_query($con,"select product_id,product_name,price from product where is_active='1' and category=".$_POST['id']."");
		while($row_prod=mysqli_fetch_array($sel_prod,MYSQLI_ASSOC))
		{	
	?>
			<option value="<?php echo $row_prod['product_id']?>"><?php echo $row_prod['product_name']." (".$row_prod['price']." AED)";?></option>
	<?php
		}
	?>
	</select>
<?php
}
else if(isset($_POST['action']) && $_POST['action']=="subscribe")
{
	$chk=mysqli_query($con,"select id from subscribe where email='".$_POST['email']."'");
	if(mysqli_num_rows($chk)==0)
	{
		$chk1=mysqli_query($con,"insert into subscribe (email,added_date) values('".$_POST['email']."','".date('Y-m-d H:i:s')."')");
		if($chk1)
			echo 1;
		else
			echo 2;
	}
	else
		echo 3;	
		
}
else if(isset($_POST['action']) && $_POST['action']=="get_subscribe_email")
{
	$sel=mysqli_query($con,"select * from subscribe order by added_date DESC");
	if(mysqli_num_rows($sel)>0)
	{
		?>
		
					<table class="table table-striped table-hover display table" id="myTable">
						<thead>
							<tr>
								<th>Sr.</th>
								<th>Email</th>
								<th>Added Date</th>
								<th>Action</th>								
							</tr>
						</thead>
						<tbody>	
		
		<?php
		$i=1;
		while($row_user=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{ 
				
			?>
				<tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo $row_user['email']?></td>
					  <td><?php echo $row_user['added_date']?></td>
					  <td><a href="javascript:void(0)" title="Delete" onclick="delete_email(<?php echo $row_user['id']?>)"><i class="fa fa-trash"></i></a></td>	
				</tr>
		<?php
		$i++;
		}
	}	
	else
	{
		?>
		<div id="messages" class="alert alert-danger">No Emails</div>
		<?php
	}	
}
else if(isset($_POST['action']) && $_POST['action']=="delete_subscribe")
{
	$chk=mysqli_query($con,"delete from subscribe where id='".$_POST['id']."'");
	if($chk)
		echo 1;
	else
		echo 2;
	
		
}

	
?>