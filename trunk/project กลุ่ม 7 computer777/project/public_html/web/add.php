<html>
<head>
<title>Student Registration Form</title>
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
&nbsp;&nbsp;<a href="login.php" class="btn-slide1">เข้าสู่ระบบ</a><br /><br />
<h1>Registration Form</h1><br />
<form action="make.php?do=add" method="post">
<pre>รหัสนิสิต: <input type="text" id="id" name="id" class="required" minlength="11" maxlength="11"><br /><font color="red">(ตัวเลขเท่านั้น - อย่างน้อย 11ตัว และ ไม่เกิน 11ตัว)</font><br />
คำนำหน้า<select name="title" class="required">
<option selected="selected" value="">-- Please Select --</option>
<option value="นาย">นาย</option>
<option value="นาง">นาง</option>
<option value="นางสาว">นางสาว</option>
</select><br>
ชื่อ: <input type="text" name="first" class="required"><br>
นามสกุล: <input type="text" name="last" class="required"><br>
คณะ: <select name="faculty" class="required">
<option selected="selected" value="">-- Please Select --</option>
<?php 
include("db.php");

if($confa==1){

$v0 = $fa1[0];
$v1 = $fa1[1];
$v2 = $fa1[2];
$v3 = $fa1[3];

echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";

} 
elseif($confa==0) 
{
$v0 = $fa0[0];
$v1 = $fa0[1];
$v2 = $fa0[2];
$v3 = $fa0[3];
echo "
<option value=\"$v0\">$v0</option>
<option value=\"$v1\">$v1</option>
<option value=\"$v2\">$v2</option>
<option value=\"$v3\">$v3</option>";
}

?>
<!--
<option value="คณะวิทยาศาสตร์">คณะวิทยาศาสตร์</option>
<option value="คณะมนุษย์ศาสตร์">คณะมนุษย์ศาสตร์</option>
<option value="คณะเภสัชศาสตร์">คณะเภสัชศาสตร์</option>
<option value="คณะศิลปศาสตร์">คณะศิลปศาสตร์์</option>
-->
</select></pre><br /><br />
<input type="Submit" value="ลงทะเบียน" class="btn" onmouseover="hov(this,'btn btnhov')" onmouseout="hov(this,'btn')">
<input id="reset" value="ล้างค่า" type="button" onclick="window.location.reload()"  class="btn"  onmouseover="hov(this,'btn btnhov')" onmouseout="hov(this,'btn')" />
</form>
</center>
</body>
</html>