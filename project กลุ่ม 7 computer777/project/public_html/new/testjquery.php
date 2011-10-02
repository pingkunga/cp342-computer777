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
include("./include/header.php");

?>
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
  
if(true)
	{
	$key_search = $_GET["txtKeyword"];
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	
	$strSQL = "SELECT B.BARCODE,I.TYPE,I.BRAND,I.DESCP,I.COST,I.PRICE FROM BRANCH B LEFT OUTER JOIN ITEM I ON(B.BARCODE=I.BARCODE) WHERE B.BARCODE='".$key_search."' and B.LOC_ID=".$_SESSION['LOC_ID']."";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);

	?>
</p>
<p>&nbsp; </p>
<form name="form1" action="set_bin_sell.php" method="post">
<table width="1070" border="1" class="tablesorter">
<tr>
		<th width="102" name="t1"> <div align="center">Barcode</div></th>
		<th width="90" name="t2"> <div align="center">Type</div></th>
		<th width="115" name="t3"> <div align="center">Brand </div></th>
		<th width="278" name="t4"> <div align="center">DESCP</div></th>
        <th width="106" name="t5> <div align="center">COST</div></th>
		<th width="106" name="t5> <div align="center">Price</div></th>
    </tr>
	<?
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>
	  <tr>
		<td><div align="center"><?=$row["BARCODE"]; $_SESSION["bar"]=$row["BARCODE"];?></div></td>
		<td><div align="center"><?=$row["TYPE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="center"><?=$row["DESCP"];?></div></td>
        <td align="center"><?=$row["COST"];?></td>
		<td align="center"><?=$row["PRICE"];?></td>
    </tr>
	<?
	}
	?>
  </table>
    <input type="submit" value="Add">
</form>
	<?
	oci_close($connect);
	
	show_add();	
}

	function show_add()
	{
		include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "select BARCODE,TYPE,BRAND,DESCP,PRICE FROM BIN_SELL JOIN ITEM using(BARCODE)";
	
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	$Num_Rows = oci_fetch_all($objParse, $Result);
	oci_execute ($objParse,OCI_DEFAULT);
	//echo $Num_Rows;
	?>
    
<form action="set_cart.php" method="post" enctype="multipart/form-data" name="form2">
	<table width="1070" border="1" class="tablesorter">
	<tr>
		<th width="109" name="t1"> <div align="center">Barcode</div></th>
		<th width="98" name="t2"> <div align="center">Type</div></th>
		<th width="123" name="t3"> <div align="center">Brand </div></th>
		<th width="305" name="t4"> <div align="center">DESCP</div></th>
		<th width="41" name="t5> <div align="center">Price</div></th>
        <th width="58" align="center" name="t6> <div align="center">Unit</div></th>
        <th width="31" name="t7> <div align="center">Delete</div></th>
		
	  </tr>
	<?
	 $line = $Num_Rows;
  if($line == 0)
  {$line=1;}
	for($check_line=1;$row = oci_fetch_array($objParse,OCI_BOTH);$check_line++)
	{

	?>
	  <tr>
		<td><label name="barcodes<?=$check_line;?>"><?=$row["BARCODE"];?></label></td>
		<td><div align="center"><?=$row["TYPE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="center"><?=$row["DESCP"];?></div></td>
		<td align="center"><?=$row["PRICE"];?></td>
        <td><div align="center"><input name="unit_set<?=$check_line;?>" type="text" size="2" value="1"/></div></td>
        <td align="center" ><a href="del_cart.php?del_barcode=<?=$row["BARCODE"];?>">Delete</a></td>
            
	  </tr>
      <?
	}
	oci_close($connect); 
	?>
    </table>
    
    <input type="submit" name="check_cart" id="check_cart" value="Submit" />
    <input type="hidden" name="hdnLine" value="<?=$check_line;?>">
</form>
    <?
	}
	?>
         
        <!-- // footer starts here // -->

<?php 
include("./include/footer.php");
?>