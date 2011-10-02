<html>
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" media="all" href="inc/style.css" />
<script src="inc/jquery.js" type="text/javascript"></script>
<script src="inc/jquery.validate.js" type="text/javascript"></script>
<script src="inc/start.js" type="text/javascript"></script>
</head>
<body>
<?php
		include("db.php");
		$do=$_GET['do'];
		if($do=="check") {
					$user=$_POST[user];
					$pass=$_POST[pass];
					if ($user =="peter" && $pass =="peter")  // ตรวจสอบเงื่อนไขว่าได้ทำการ login มาถูกต้องหรือไม่
					{
							//ถ้าถูกต้อง
							session_start();
 							$_SESSION[logged_in]=session_id();
 							header("Location: $main");
					} else {
							//ถ้าไม่ถูกต้องให้กลับไปหน้า Login
   							echo "<h1><a href=\"$login\">Error : Username หรือ Password ไม่ถูกต้อง...ลองใหม่</a></h1>";
   							echo "<meta http-equiv=\"refresh\" content=\"1;url=$login\" />";
					}
		} elseif ($do=="logout") {
					session_start();
					session_destroy();
					echo "<h1>ออกจากระบบแล้วครับ</h1><br />";
					//header("Location: $main");
					echo "<a href=\"$main\"><h2>Go to the main page</h2></a>";
					echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
		} else {
		echo "
		<center><br /><a href=\"index.php\" class=\"btn-slide1\">หน้าหลัก</a>&nbsp;&nbsp;<a href=\"add.php\" class=\"btn-slide1\">เพิ่มข้อมูล</a><br /><br /><h1>เข้าสู่ระบบ</h1>
		<form method=\"post\" action=\"login.php?do=check\">
 		<label for=\"textfield\">Username : </label>
		<input type=\"text\" name=\"user\" id=\"name\" class=\"required\" minlength=\"4\">
 		<label for=\"label2\"><br /> password : </label>
 		<input type=\"password\" name=\"pass\" id=\"pass\" class=\"required\"minlength=\"4\">
 		<br /><br />
 		<input type=\"submit\" name=\"Submit\" value=\"เข้าสู่ระบบ\" id=\"Submit\" class=\"btn\"  onmouseover=\"hov(this,'btn btnhov')\" onmouseout=\"hov(this,'btn')\">
 		<input type=\"button\" name=\"reset\" value=\"ล้างค่า\" onclick=\"window.location.reload()\" id=\"label3\" class=\"btn\"  onmouseover=\"hov(this,'btn btnhov')\" onmouseout=\"hov(this,'btn')\">
 		</form></center>";
		}
	
		?>
</body>
</html>