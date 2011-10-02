<?php
session_start();
if ($_SESSION[logged_in] != session_id()) { //ตรวจสอบ session ถ้าไม่ตรงกัน
header("Location: login.php"); // ถ้าไม่มีกลับไปหน้า login
exit(); 
}
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: login.php?do=logout"); }
}
$_SESSION['timeout'] = time();
?>
<?php
include("db.php");
$Conn=oci_connect("$dbuser", "$dbpassword", "$hostname","$encode");
$data=$_GET['data'];
//echo $data;
$strSQL = "SELECT * FROM tblstudent WHERE `ID` = '$data'";
$objParse = oci_parse ($Conn, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while ($row = oci_fetch_array($objParse,OCI_BOTH))
{
$id=$row[0];
$title=$row[1];
$name=$row[2];
$last=$row[3];
$fd=$row[4];
}
oci_close($Conn);
?>
<html>
<head>
<title>Update Student list</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" media="all" href="inc/style.css" />
<script src="inc/jquery.js" type="text/javascript"></script>
<script src="inc/jquery.validate.js" type="text/javascript"></script>
<script src="inc/start.js" type="text/javascript"></script>
<script type="text/javascript" src="inc/jquery.alphanumeric.js"></script>	
<script type="text/javascript">
$(document).ready(function(){

	$('#id').numeric();

});
</script>
</head>
<body>
<center>
<br /><a href="index.php" class="btn-slide1">หน้าหลัก</a>
&nbsp;&nbsp;<a href="add.php" class="btn-slide1">เพิ่มข้อมูล</a><br /><br />
<h1>Update Students list</h1><br />
<form action="make.php?do=update" method="post">
<input type="hidden" name="data" value="<? echo $data; ?>">
รหัสนิสิต: <input type="text" name="id" class="required" minlength="11" maxlength="11" value="<?php echo $id; ?>"><br /><font color="red">(ตัวเลขเท่านั้น - อย่างน้อย 11ตัว และ ไม่เกิน 11ตัว)</font><br />
คำนำหน้า<select name="title" class="required">
<option selected="selected" value="<?php echo $title; ?>"><?php echo $title; ?></option>
<option value="นาย">นาย</option>
<option value="นาง">นาง</option>
<option value="นางสาว">นางสาว</option>
</select><br>
ชื่อ: <input type="text" name="first" class="required" value="<?php echo $name; ?>"><br>
นามสกุล: <input type="text" name="last" class="required" value="<?php echo $last; ?>"><br>
คณะ: <select name="faculty" class="required">



<option selected="selected" value="<?php echo $fd; ?>"><?php echo $fd; ?></option>

<?php 
if($confa==1){

$v0 = $fa1[0];
$v1 = $fa1[1];
$v2 = $fa1[2];
$v3 = $fa1[3];

if($fd==$v0) {
echo "
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";
} elseif($fd==$v1) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v3\">$v3</option>";
}elseif($fd==$v2) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v3\">$v3</option>";
}elseif($fd==$v3) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>";
}else{
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";
}
} elseif($confa==0){
$v0 = $fa0[0];
$v1 = $fa0[1];
$v2 = $fa0[2];
$v3 = $fa0[3];

if($fd==$v0) {
echo "
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";
} elseif($fd==$v1) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v3\">$v3</option>";
}elseif($fd==$v2) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v3\">$v3</option>";
}elseif($fd==$v3) {
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>";
}else{
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";
}
}

?>
<!--<option value="คณะวิทยาศาสตร์">คณะวิทยาศาสตร์</option>
<option value="คณะวิทยาศาสตร์">คณะมนุษย์ศาสตร์</option>
<option value="คณะเภสัชศาสตร์">คณะเภสัชศาสตร์</option>
<option value="คณะศิลปศาสตร์">คณะศิลปศาสตร์์</option>-->

</select><br>
<input type="Submit" value="อัพเดท" class="btn"  onmouseover="hov(this,'btn btnhov')" onmouseout="hov(this,'btn')">
<input id="reset" value="ล้างค่า" type="button" class="btn"  onmouseover="hov(this,'btn btnhov')" onmouseout="hov(this,'btn')" onclick="window.location.reload()" />
</form></center>
</body>
</html>
