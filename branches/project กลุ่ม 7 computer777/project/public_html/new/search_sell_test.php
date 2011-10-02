<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<?   session_start();
  session_register("bar");
  session_register("state_sell");
 ?>
</head>

<body>
<form name="frmSearch" method="get" action="<?=$_SERVER['SCRIPT_NAME'];?>">
  <table width="1066" border="1">
    <tr>
      <th width="1056">Keyword
      <input name="txtKeyword" type="text" id="txtKeyword" value="<?=$_GET["txtKeyword"];?>">
      <input type="submit" value="Search"></th>
    </tr>
  </table>
</form>
<p>
  <? 
  
if($_GET["txtKeyword"] != "")
	{
	$key_search = $_GET["txtKeyword"];
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT * FROM ITEM WHERE BARCODE='".$key_search."'";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);

	?>
</p>
<p>&nbsp; </p>
<form name="form1" action="set_bin_sell.php" method="post">
<table width="1070" border="1">
<tr>
		<th width="144" name="t1"> <div align="center">Barcode</div></th>
		<th width="137" name="t2"> <div align="center">Type</div></th>
		<th width="171" name="t3"> <div align="center">Brand </div></th>
		<th width="443" name="t4"> <div align="center">DESCP</div></th>
		<th width="49" name="t5> <div align="center">Price</div></th>
		<th width="86" name="t6"> <div align="center">ADD </div></th>
	  </tr>
	<?
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>
	  <tr>
		<td><div align="center"><?=$row["BARCODE"];?></div></td>
		<td><div align="center"><?=$row["TYPE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="center"><?=$row["DESCP"];?></div></td>
		<td align="center"><?=$row["PRICE"];?></td>    
		<td align="center" ></td>
	  </tr>
	<?
	 $_SESSION["bar"]=$row["BARCODE"];
	 echo $_SESSION["bar"];
	}
	?>
	</table>
    <input type="submit" value="Add">
    </form>
	<?
	oci_close($connect);
}
?>

</body>

<? 
function click_insert($B_code)
{
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "INSERT INTO BIN_SELL ";
	$strSQL .="(BARCODE) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$B_code."') ";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if($objExecute)
{
	oci_commit($connect); //*** Commit Transaction ***//
	echo "Save Done.";
	$_SESSION["check"]=1;
}
else
{
	oci_rollback($connect); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL."";
	$check_in = 0;
}

oci_close($connect);
}
?>
</html>
