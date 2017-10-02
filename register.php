<?php
include_once("config.php");
$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$email=$_REQUEST['email'];
$password=$_REQUEST['password'];
$primary_phone=$_REQUEST['primary_phone'];
$secondary_phone=$_REQUEST['secondary_phone'];
if($firstname!="" && $lastname!="" && $email!="" && $password!="")
{
	$sql=mysqli_query($con,"select user_id from users where email='".$email."'");
	if(mysqli_num_rows($sql)==0)
	{
			
		$ins=mysqli_query($con,"insert into users (firstname,lastname,email,password,primary_phone,secondary_phone,is_active) values('".$firstname."','".$lastname."','".$email."','".md5($password)."','".$primary_phone."','".$secondary_phone."','0')");
		if($ins)
		{	
			$result['msg']="Regiter Successfully.";
			$result['status']=1;
			$result1[]=$result;
		}
		else
		{
			$result['error']="Error while register.";
			$result['status']=2;
			$result1[]=$result;
		}
			
	}
	else
	{
		$result['error']="Email already present.";
		$result['status']=3;
		$result1[]=$result;
	}		
}
else
{
	$result['error']="Provide all data.";
	$result['status']=4;
	$result1[]=$result;
}
	
$array_all['register']=$result1;
echo json_encode($array_all);
?>