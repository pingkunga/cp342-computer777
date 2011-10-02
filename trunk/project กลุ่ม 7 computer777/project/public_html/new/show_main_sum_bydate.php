<?php   

// Initialize a session.
session_start();
session_register("bar");
session_register("state_sell");
session_register("del_bar");
require_once("./include/config.inc.php");
	
if (!isset($_SESSION['userid']) AND (!isset($_SESSION['logged_in']))) { //ตรวจสอบ session ถ้าไม่ตรงกัน
header("Location: $login_page"); // ถ้าไม่มีกลับไปหน้า login
exit(); 
}
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: $logout_page"); }
}
$_SESSION['timeout'] = time();

?>
<?php
$q=$_GET["date"];

include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
//--------BRANCH1--------
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='1'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);

?>


<table width="624" border="1">
  <tr>
  	<th width="162"> <div align="center">TYPE</div></th>
    <th width="162"> <div align="center">SELL(unit)</div></th>


  </tr>
<?
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
?>
  <tr>
  	<td><?=$row["TYPE"];?></td>
  	<td><?=$row["COUNT(BARCODE)"];?></td>
  </tr>
<?
}
?>
</table>
<?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='1'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];
?>

<br /><br /><br />
<?
//----------BRANCH2
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='2'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);

?>


<table width="624" border="1">
  <tr>
  	<th width="162"> <div align="center">TYPE</div></th>
    <th width="162"> <div align="center">SELL(unit)</div></th>


  </tr>
<?
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
?>
  <tr>
  	<td><?=$row["TYPE"];?></td>
  	<td><?=$row["COUNT(BARCODE)"];?></td>
  </tr>
<?
}
?>
</table>
<?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='2'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];

?>

<br /><br /><br />
<?
//--------BRANCH3--------
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='3'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
?>
<table width="624" border="1">
  <tr>
  	<th width="162"> <div align="center">TYPE</div></th>
    <th width="162"> <div align="center">SELL(unit)</div></th>


  </tr>
<?
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
?>
  <tr>
  	<td><?=$row["TYPE"];?></td>
  	<td><?=$row["COUNT(BARCODE)"];?></td>
  </tr>
<?
}
?>
</table>
<?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='3'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];

?>


<br /><br /><br />
<?
//-------------BRANCH4
$strSQL = "SELECT EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='3'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."ผู้จัดการ : ".$row["EMP_NAME"];

?>

<table width="624" border="1">
  <tr>
  	<th width="162"> <div align="center">TYPE</div></th>
    <th width="162"> <div align="center">SELL(unit)</div></th>


  </tr>
<?
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
?>
  <tr>
  	<td><?=$row["TYPE"];?></td>
  	<td><?=$row["COUNT(BARCODE)"];?></td>
  </tr>
<?
}
?>
</table>
<?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='4'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];

?>



<?
oci_close($connect);
?>
<?php 
include("./include/footer.php");
?>