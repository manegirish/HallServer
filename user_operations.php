<?php
include_once("config.php");



$action=$_REQUEST['action'];

if($action=="add_contact")
{
	
	$sel_email=mysqli_query($con,"select user_id from users where email='".$_REQUEST['email']."'");
	if(mysqli_num_rows($sel_email)==0)
	{
		$user_id=$_REQUEST['user_id'];
		$family_id=$_REQUEST['family_id'];
		$firstname=$_REQUEST['firstname'];
		$lastname=$_REQUEST['lastname'];
		$password=$_REQUEST['password'];
		
		$email=$_REQUEST['email'];
		$password=$_REQUEST['password'];
		$primary_phone=$_REQUEST['primary_phone'];
		$secondary_phone=$_REQUEST['secondary_phone'];
		$relation=$_REQUEST['relation'];

		$ins=mysqli_query($con,"insert into users (firstname,lastname,email,password,primary_phone,secondary_phone,family_id) values('".$firstname."','".$lastname."','".$email."','".md5($password)."','".$primary_phone."','".$secondary_phone."',".$family_id.")");
		if($ins)
		{	
			$ins_id=mysqli_insert_id($con);
			$ins2=mysqli_query($con,"insert into family_members (family_id,owner_id,member_id,relation,added_date) values('".$family_id."','".$user_id."','".$ins_id."','".addslashes($relation)."','".date('Y-m-d H:i:s')."')");
			if($ins2)
			{	
				$result['msg']="Contact added Successfully.";
				$result['status']=1;
				$result1[]=$result;
			}
			else
			{
				$result['error']="Error while adding";
				$result['status']=2;
				$result1[]=$result;
			}
		}
		else
		{
			$result['error']="Error while adding";
			$result['status']=2;
			$result1[]=$result;
		}
	}
	else
	{
		$result['error']="Email aleardy exits";
		$result['status']=3;
		$result1[]=$result;
	}
	
}

else if($action=="create_family")
{
	$user_id=$_REQUEST['user_id'];
	$name=$_REQUEST['name'];
	$ins=mysqli_query($con,"insert into family (name,created_by,created_date) values('".addslashes($name)."',".$user_id.",'".date('Y-m-d H:i:s')."')");
	if($ins>0)
	{	
		$result['msg']="Created succesfully.";
		$result['status']=1;
		$result1[]=$result;
		
	}
	else
	{
		$result['error']="Error while creating";
		$result['status']=2;
		$result1[]=$result;
	}
}	
else if($action=="get_families")
{
	$sel=mysqli_query($con,"Select f.family_id,f.name,f.created_by,f.created_date,CONCAT(u.firstname,' ',u.lastname) as uname,count(fm.id) as cnt from family f INNER JOIN users u ON f.created_by=u.user_id LEFT JOIN family_members fm ON f.family_id=fm.family_id where f.is_active='1'");
	if(mysqli_num_rows($sel)>0)
	{	
		while($row=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{	
			$result['id']=$row['family_id'];
			$result['name']=$row['name'];
			$result['created_by']=$row['uname'];
			$result['created_by_id']=$row['created_by'];
			$result['total_members']=$row['cnt'];
			$result['created_date']=strtotime($row['created_date']);			
			$result['status']=1;
			$result1[]=$result;
		}
	}
	else
	{
		$result['error']="No data";
		$result['status']=2;
		$result1[]=$result;
	}
}
else if($action=="get_members")
{
	$family_id=$_REQUEST['id'];
	
	$sel=mysqli_query($con,"Select fm.member_id,fm.relation,CONCAT(u.firstname,' ',u.lastname) as uname,u.email,u.primary_phone,u.secondary_phone from family_members fm INNER JOIN  users u ON fm.member_id=u.user_id where fm.family_id='".$family_id."' and u.is_active=1 and fm.is_active=1");
	if(mysqli_num_rows($sel)>0)
	{	
		while($row=mysqli_fetch_array($sel,MYSQLI_ASSOC))
		{	
			$result['id']=$row['member_id'];
			$result['name']=$row['uname'];
			$result['email']=$row['email'];
			$result['primary_phone']=$row['primary_phone'];
			$result['secondary_phone']=$row['secondary_phone'];
			$result['status']=1;
			$result1[]=$result;
		}
	}
	else
	{
		$result['error']="No data";
		$result['status']=2;
		$result1[]=$result;
	}
}
$array_all[$action]=$result1;
echo json_encode($array_all);
?>