<?php
include_once('../sys/config.php');

if (isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
	include_once('../header.php');
	$name = $_POST['user'];
	$pass = $_POST['pass'];
	//此处存在SQL注入，可绕过密码登录 Chanllege 2
	//没有验证码，可以暴力破解 Chanllege 7
    $query = "SELECT * FROM admin WHERE admin_name = '$name' AND admin_pass = SHA('$pass')";
    $data = mysqli_query($dbc, $query) or die('Error!!');

    if (mysqli_num_rows($data) == 1) {
		$_SESSION['admin'] = $name;
        header('Location: manage.php');
        }
	else {
		$_SESSION['error_info'] = '用户名或密码错误';
		header('Location: login.php');
	}
		
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>