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
//include("./include/header.php");

?>

<?php
$q=$_GET["myName"];
$s=$_GET["lname"];
include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
$strSQL = "SELECT L.LOC_NAME,S.BARCODE,S.UNIT,I.PRICE,S.TIME_SELL,S.DATE_SELL
FROM SELL_DETAIL S LEFT JOIN ITEM I  ON(S.BARCODE=I.BARCODE)
LEFT JOIN LOCATION L ON(S.LOC_ID=L.LOC_ID)
WHERE S.LOC_ID='".$s."' AND S.DATE_SELL='".$q."'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);

?>

<table width="624" border="1">
  <tr>
  	<th width="157"> <div align="center">time</div></th>
    <th width="162"> <div align="center">barcode</div></th>
    <th width="80"> <div align="center">unit </div></th>
	 <th width="84"> <div align="center">PEICE</div></th>

  </tr>
<?
$ssprice=0;
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	
?>


  <tr>
    <td><?=$row["TIME_SELL"];?></td>
    <td><?=$row["BARCODE"];?></td>
    <td><?=$row["UNIT"];?></td>
    <td><?
	
	$sprice=$row["PRICE"]*$row["UNIT"];
	echo $sprice ;
	$ssprice=$ssprice+$sprice;
	?></td>
	
  </tr>
<?
}
?>

</table>
<table width="621"><tr>
<td width="203"></td>
<td width="195"></td>
<td width="101"><a>รวม   =</a></td>
<td width="102"><?=$ssprice;?></td>
</tr></table>
<?
oci_close($connect);
?>
<?php 
//include("./include/footer.php");
?>