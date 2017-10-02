<?php
session_start();
if(isset($_SESSION['admin_id']))
	$url="login.php";
session_destroy();
?>
<script>
location.href="<?php echo $url;?>";
</script>