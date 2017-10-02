<?php
include_once("config.php");
$email=$_REQUEST['email'];
$password=$_REQUEST['password'];
if($email!="" && $password!="")
{
	$sql=mysqli_query($con,"select CONCAT(firstname,' ',lastname) as name,email,image,user_id from users where email='".$email."' and password='".md5($password)."' and is_active='1'");
	if(mysqli_num_rows($sql)>0)
	{
		while($row=mysqli_fetch_array($sql,MYSQLI_ASSOC))
		{
		    $result['user_id']=$row['user_id'];
			$result['name']=$row['name'];
			$result['email']=$row['email'];
			$result['image']=$row['image'];
			$result['msg']="Login Successfully.";
			$result['status']=1;
			$result1[]=$result;
			
		}	
	}
	else
	{
		$result['error']="Wrong username password.";
		$result['status']=2;
		$result1[]=$result;
	}		
}
$array_all['login']=$result1;
echo json_encode($array_all);
?>