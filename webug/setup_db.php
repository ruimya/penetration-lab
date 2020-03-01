<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据库初始化</title>
</head>

<body bgcolor="#000000">

<div style=" margin-top:10px;color:#FFF; font-size:23px; text-align:left">
<font size="3" color="#FFFF00">
正在初始化数据库...
<br><br> 

<?php
	include("./sql/db-creds.inc");

   // 连接数据库
	$con = mysql_connect($host,$dbuser,$dbpass);
	if (!$con)
	{
		die('[*]...................Could not connect to DB, check the creds in db-creds.inc: ' . mysql_error());
	}

	// 清空旧数据库
	foreach ($dbnames as $name) {
		$sql="DROP DATABASE IF EXISTS `" . $name . "`";
		if (mysql_query($sql)) {
			echo "[*]...................Old database '" . $name . "' purged if exists"; echo "<br><br>\n";
		}
		else {echo "[*]...................Error purging database: " . mysql_error(); echo "<br><br>\n";
		}
	}

	// 创建新数据库
	foreach ($dbnames as $name) {
		$sql="CREATE database `" . $name . "`";
		if (mysql_query($sql))
		{
			echo "[*]...................Creating New database '" . $name . "' successfully";echo "<br><br>\n";
		}
		else 
		{
			echo "[*]...................Error creating database: " . mysql_error();echo "<br><br>\n";
		}
	}

	// 根据SQL文件到数据
	foreach ($dbnames as $name) 
	{
		$db_selected = mysql_select_db($name, $con);
		if (!$db_selected)
	    {
	  		die ("Can\'t use " . $name . ": " . mysql_error());
	    } else {
	    	echo "Select DB: ". $name . "<br>";
	    }

		$sql=file_get_contents("./sql/". $name .".sql"); 
		$rows=explode(";",$sql); 

		foreach($rows as $row)
		{
			$sql=trim($row) . ";";
			if (mysql_query($sql)) {
				// echo htmlspecialchars($sql) . "<br>";
			} else {
				echo "[*]...................Error: " . mysql_error() . "<br>" . htmlspecialchars($sql) . "<br>";
			}
		} 
	}
?>


</font>
</div>
</body>
</html>
