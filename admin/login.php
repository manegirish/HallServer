<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<?php include_once("../config.php"); ?>
<div class="login-box">
  <div class="login-logo">
    <strong>Admin</strong>
  </div>
  <!-- /.login-logo -->
  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
  <div class="login-box-body">
  <?php
	if(isset($_POST['username']))
	{
		$sel_user=mysqli_query($con,"select * from admin where username='".$_POST['username']."' and password='".md5($_POST['password'])."' limit 0,1");
		if(mysqli_num_rows($sel_user)>0)
		{
			$row=mysqli_fetch_array($sel_user,MYSQLI_ASSOC);
			session_start();
			$_SESSION['admin_id']=$row['admin_id'];
			$_SESSION['admin_name']=$row['admin_name'];
			$_SESSION['is_super']=$row['is_superadmin'];
			?>
			<div id="messages" class="alert alert-success">login Successful.</div>
			<script>
				setTimeout(function(){ $("#messages").hide();location.href="index.php"; }, 3000);
			</script>
			<?php
		}
		else
		{ ?>
		 <div id="messages" class="alert alert-danger">Wrong username or password.</div>
		<script>
				setTimeout(function(){ $("#messages").hide(); }, 3000);
		</script>
		<?php	
		}				
	}	
  ?>

    <p class="login-box-msg">Sign in to start your session</p>

    <form name="login" method="post" id="login">
	  <div id="messages" style="display:none"></div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" id="username" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		<div id="for_username" style="display:none;color:#FF0000">Please enter username</div>	
	  </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<div id="for_password" style="display:none;color:#FF0000">Please enter password</div>	
      </div>
      <div class="row">
        <!--div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div-->
        <!-- /.col -->
        <div class="col-xs-12 text-right">
          <button type="button" class="btn btn-primary btn-block btn-flat" onclick="check();">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!--div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
  function check()
  {
		var err=0;
		if($("#username").val()=="")
	  	{
			$("#for_username").show();
			err++;
			return false;
		}
		else
		{
			$("#for_username").hide();
		}
		
		if($("#password").val()=="")
	  	{
			$("#for_password").show();
			err++;
			return false;
		}
		else
		{
			$("#for_password").hide();
		}
		if(err=="0")	
		{
			
			document.getElementById("login").submit();
		}		
  }
</script>
</body>
</html>
