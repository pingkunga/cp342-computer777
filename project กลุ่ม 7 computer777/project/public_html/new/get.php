<?   session_start();
  session_register("bar");
  session_register("state_sell");
  session_register("del_bar");
  
  if($_SESSION['logged_in']!=session_id())
  {
	  session_destroy();
	  header("Location: login.php");  
  }
 ?>

<?php	

$q=$_GET["myName"];
include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
$strSQL = "SELECT LOC_ID,BARCODE,UNIT,PRICE,TIME_SELL
FROM SELL_DETAIL JOIN ITEM USING(BARCODE)
WHERE LOC_ID=1 AND DATE_SELL='".$q."'";
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
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
?>


  <tr>
    <td><?=$row["TIME_SELL"];?></td>
    <td><?=$row["BARCODE"];?></td>
    <td><?=$row["UNIT"];?></td>
    <td><?
	
	$sprice=$row["PRICE"]*$row["UNIT"];
	echo $sprice ;?></td>

  </tr>
<?
}
?>
</table>
<?
oci_close($connect);
?>