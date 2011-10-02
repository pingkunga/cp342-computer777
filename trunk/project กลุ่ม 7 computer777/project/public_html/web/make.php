<?php
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: login.php?do=logout"); }
}
$_SESSION['timeout'] = time();
?>
<html>
<head>
<title>We will Do as your wishes.</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	include("db.php");
	$Conn=mysql_connect($hostname, $dbuser, $dbpassword) or die("could not connect");
	mysql_db_query("$dbname","SET NAMES UTF8") or die ("No Database that you selected");
	$do=$_GET['do'];
	
	
		if($do=="delete") {
		session_start();
		if ($_SESSION[logged_in] != session_id()) { //ตรวจสอบ session ถ้าไม่ตรงกัน
		header("Location: login.php"); // ถ้าไม่มีกลับไปหน้า login
		exit(); 
		}
			$id=$_GET['id'];
			$query="DELETE FROM `tblstudent` WHERE `tblstudent`.`ID` = '$id'";
			mysql_query($query);
				if (mysql_affected_rows() == 1){
				echo "<h1>ลบแล้ววววววววว!</h1>";
				echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
			} else {
				echo "<h1>ลบไม่ได้, something is wrong! ToT.......</h1>";
				echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
				}
				mysql_close($Conn);
				
		} elseif ($do=="logout") {
					session_destroy();
					echo "<h1>ออกจากระบบแล้วครับ</h1><br />";
					//header("Location: $main");
					echo "<a href=\"$main\"><h2>Go to the main page</h2></a>";
					echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
					
		} elseif ($do=="update") {
					session_start();
					if ($_SESSION[logged_in] != session_id()) { //ตรวจสอบ session ถ้าไม่ตรงกัน
					header("Location: login.php"); // ถ้าไม่มีกลับไปหน้า login
					exit(); 
					}
					$data=$_POST['data'];
					$id=$_POST['id'];
					$title=$_POST['title'];
					$first=$_POST['first'];
					$last=$_POST['last'];
					$faculty=$_POST['faculty'];
					$sql = "UPDATE  `tblstudent` SET  `ID` =  '$id',
					`Pre_Name` =  '$title',
					`First_Name` =  '$first',
					`Last_Name` =  '$last',
					`Faculty_ID` =  '$faculty' WHERE  `tblstudent`.`ID` =  '$data'";
					mysql_query($sql);
					if (mysql_affected_rows() == 1){
					echo "<h1>อัพเดทข้อมูลสำเร็จ!</h1>";
					echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
					} else {
					echo "<h1>อัพเดทข้อมูลไม่ได้</h1><h2>อาจเป็นไปได้ว่าเลขนิสิตซ้ำกันหรือว่าข้อมูลที่บันทึกเหมือนกันกับข้อมูลในระบบ!</h2>";
					echo "<meta http-equiv=\"refresh\" content=\"3;url=$main\" />";
						}
					mysql_close($Conn);
		} elseif ($do=="add") {
				$id=$_POST['id'];
				$title=$_POST['title'];
				$first=$_POST['first'];
				$last=$_POST['last'];
				$faculty=$_POST['faculty'];
				$sql = "INSERT INTO `tblstudent` (`ID`, `Pre_Name`, `First_Name`, `Last_Name`, `Faculty_ID`) VALUES ('$id','$title','$first','$last','$faculty')";
				mysql_query($sql);
				if (mysql_affected_rows() == 1){
						echo "<h1>บันทึกข้อมูลสำเร็จ!</h1>";
						echo "<meta http-equiv=\"refresh\" content=\"1;url=$main\" />";
				} else {
						echo "<h1>บัญทึกไม่ได้, ลองเปลี่ยนรหัสนิสิตดูเผื่อมีคนเอาไปใช้ก่อนหน้าแล้ว...ลองอีกรอบ</h1>";
						echo "<meta http-equiv=\"refresh\" content=\"1;url=add.php\" />";
				}
					mysql_close($Conn);
		}
		
		else { 
					echo "<h1>nothing</h1>"; 
				}
?>
</body>
</html>