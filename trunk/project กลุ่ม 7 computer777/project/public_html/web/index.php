<?php
session_start();
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: login.php?do=logout"); }
}
$_SESSION['timeout'] = time();

include("db.php");
$Conn=oci_connect("$dbuser", "$dbpassword", "$hostname","$encode");
?>
<html>
<head>
<title>Show Students list</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="inc/jquery.js" type="text/javascript"></script>
<script src="inc/slide.js" type="text/javascript"></script>
<script src="inc/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="inc/jquery.metadata.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() { 
    // call the tablesorter plugin, the magic happens in the markup 
    $("table").tablesorter(); 
}); 
</script>
 <link type="text/css" rel="stylesheet" media="all" href="inc/style.css" />
  <link type="text/css" rel="stylesheet" media="all" href="inc/table.css" />
</head>
<body>

<div id="slide-panel"><!--SLIDE PANEL STARTS-->
<h2>Login</h2>
            <div class="loginform">
            
                    <div class="formdetails">
                    <form method="post" action="login.php?do=check">
                    <label for="log">Username : </label><input type="text" name="user" id="log" value="" size="20" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="pwd">Password : </label><input type="password" name="pass" id="pwd" size="20" />
                    <input type="submit" name="submit" value="Login" class="button" />
                    </form>
                    </div>
                    
                    <div class="loginregister">
                    <a href="add.php">Register</a> 
                    </div>
                    
            </div><!--loginform ends-->

</div><!--SLIDE PANEL ENDS-->

<?php 
if ($_SESSION[logged_in] == session_id()) { 
echo "<h2><font color=\"red\">ยินดีต้อนรับครับ&nbsp;<span style=\"color:blue;text-decoration:underline;font-weight:bold;\">คุณ Peter </span><br />คุณสามารถแก้ไขข้อมูลต่างๆได้นะครับ</font></h2><br />";
} else { 
echo "<div class=\"slide\"><a href=\"#\" class=\"btn-slide\">Login &darr;</a></div>"; 
echo "<h2><font color=\"blue\">คุณยังไม่ได้ Login<br />หากยังไม่ได้ Login จะดูข้อมูลได้อย่างเดียวนะครับ</font></h2><br />"; 
}
?>
<center><h1>Students list</h1><br />
<table  cellspacing='0' cellpadding='0' border='1'  id="myTable" class="tablesorter">
 <thead>
 <tr>
    <th>รหัสนิสิต</th>
    <th>ชื่อ-นามสกุล</th>
    <th>คณะ</th>
    <th>ลบ</th>
  </tr>
</thead>
<tbody>
<?php
//$result = mysql_query("SELECT *, COUNT(ID) AS count FROM tblstudent GROUP BY ID ORDER BY ID") or die ("Invalid query");
$strSQL = "SELECT * FROM  tblstudent";
$objParse = oci_parse ($Conn, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while ($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		if ($_SESSION[logged_in] == session_id()) { 
			echo "<tr><td><a href=\"edit.php?data=$row[0]\">$row[0]</a></td><td>$row[1] $row[2] $row[3]</td><td>$row[4]</td><td><a href=\"make.php?do=delete&id=$row[0]\">Delete</a></td></tr>"; 
				} else {
			echo("<tr><td>$row[0]</td><td>$row[1] $row[2] $row[3]</td><td>$row[4]</td><td>คุณไม่มีสิทธิ์</td></tr>"); 
		} 
	}
oci_close($Conn);
?>
</tbody>
</table>
<br />
<?php
if ($_SESSION[logged_in] == session_id()) {
echo "<a href=\"login.php?do=logout\" class=\"btn-slide1\">ออกจากระบบ</a>
&nbsp;&nbsp;
<a href=\"add.php\" class=\"btn-slide1\">เพิ่มข้อมูล</a>";
} else {
echo "<a href=\"login.php\" class=\"btn-slide1\">เข้าสู่ระบบ</a>
&nbsp;&nbsp;
<a href=\"add.php\" class=\"btn-slide1\">เพิ่มข้อมูล</a>"; 
}
?>
</center>
<center>
<br />
</center>
</body>
</html>