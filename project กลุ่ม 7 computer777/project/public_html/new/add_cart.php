<?php
session_start();
$sid = session_id();

$pro_id = "";
if(isset($_POST['id'])) {
	$pro_id = $_POST['id'];
}
else {
	exit;
}

include("dbconn.inc.php");

//ข้อมูลที่ส่งเข้ามีเพียงค่า id ของสินค้า
//แต่ที่ตาราง cart เราต้องเก็บชื่อและราคาสินค้านั้นด้วย
//ดังนั้นจึงต้องไปอ่านข้อมูลนี้จากตาราง product มาไว้ก่อน
$sql = "SELECT pro_name, price FROM product
			WHERE pro_id = $pro_id;";
			
$result = mysql_query($sql);
$pro_name = mysql_result($result, 0, 0);
$price = mysql_result($result, 0, 1);

//เพิ่มข้อมูลลงในตาราง cart โดยใช้คำสั่ง REPLACE
//เพื่อว่าถ้ามีการหยิบซ้ำจะได้ไม่ถูกเพิ่มลงไปอีก
$sql = "REPLACE INTO cart VALUES
			('$sid', $pro_id, '$pro_name', $price, 1, NOW());";
		
mysql_query($sql);

//ส่งผลลัพธ์กลับไปแบบจาวาสคริปต์ โดยหลังแจ้งด้วย alert()
//จะเรียกฟังก์ชัน readCart() เพื่อให้อ่านรายการในรถเข็นมาแสดงใหม่
//ซึ่งฟังก์ชันนี้ ได้เขียนรอไว้แล้วที่เพจ index.php และ product_detail.php
header("content-type: text/javascript; charset=tis-620");
echo "alert('เพิ่มสินค้าลงในรถเข็นแล้ว'); 
		 readCart();";
?>