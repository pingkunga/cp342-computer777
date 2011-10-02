<?php   

// Initialize a session.
session_start();
session_register("bar");
session_register("state_sell");
session_register("del_bar");
$_session['get_search'];
$_session['get_search']=$_GET["txtKeyword"];
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
include("./include/header.php");

?>


<? 
	echo $B_code=$_GET["bar"];
	
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL =  "SELECT BARCODE,BRAND,DESCP,COST,PRICE,UNIT 
FROM MAIN_STOCK NATURAL JOIN ITEM 
WHERE BARCODE ='".$B_code."'";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
?>
<form name="form1" action="update_main_save.php" method="post">
<table width="891" border="1" class="tablesorter">
<tr>
		<th width="77" name="t3"> <div align="center">Barcode</div></th>
		<th width="178" name="t3"> <div align="center">Brand</div></th>
		<th width="301" name="t4"> <div align="left">DESCP</div></th>
        <th width="99" name="t5> <div align="center">COST</div></th>
        <th width="119" name="t5> <div align="center">PRICE</div></th>
		<th width="77" name="t5> <div align="center">UNIT</div></th>
    </tr>
	<?
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>
	  <tr>
		<td><div align="center"><input name="txtBarcode" type="text" size="9" value="<?=$row["BARCODE"];?>"/></div></td>
		<td><div align="center"><input name="txtBrand" type="text" size="20" value="<?=$row["BRAND"];?>"/></div></td>
		<td><div align="left">
        
        <textarea name="txtDescp" cols="40" rows="3" value="<?=$row["DESCP"];?>"><?=$row["DESCP"];?></textarea>
        
       </div></td>
        <td><div align="center"><input name="txtCost" type="text" size="6" value="<?=$row["COST"];?>"/></div></td>
		<td align="center"><input name="txtPrice" type="text" size="6" value="<?=$row["PRICE"];?>"/></td>
        <td align="center"><input name="txtUnit" type="text" size="6" value="<?=$row["UNIT"];?>"/></td>
    </tr>
	<?
	}
	?>
  </table>
  <input type="submit" value="save">
  </form>
          <!-- // footer starts here // -->

<?php 
include("./include/footer.php");
?>