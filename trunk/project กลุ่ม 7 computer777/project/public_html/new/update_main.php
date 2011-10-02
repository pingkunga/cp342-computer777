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


<form name="frmSearch" method="get" action="<?=$_SERVER['SCRIPT_NAME'];?>">
  <table width="1066" border="1"  >
    <tr>
      <th width="1056">Select type   
     <? include("../new/include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT DISTINCT TYPE FROM ITEM";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	?>
    
   <select name="txtKeyword" id="txtKeyword">
   <option value="..."><?=$objResult["TYPE"];?></option>
	<?
	while($objResult = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>  
	<option value="<?=$objResult["TYPE"];?>"><?=$objResult["TYPE"];?></option>
	<?
	}
	?>	
	</select> 
           
    <input type="submit" value="Search"></th>
    </tr>
  </table>
</form>

  <? 
  
if(true)
	{
	echo "<br>".$_session['get_search'];
	include("../new/include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT BARCODE,BRAND,DESCP,COST,PRICE,UNIT 
FROM MAIN_STOCK NATURAL JOIN ITEM 
WHERE TYPE ='".$_session['get_search']."'";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);

	?>


<form name="form1" action="update_main_form.php" method="post">
<table width="944" border="1" class="tablesorter">
<tr>
		<th width="115" name="t3"> <div align="center">Barcode</div></th>
		<th width="115" name="t3"> <div align="center">Brand</div></th>
		<th width="278" name="t4"> <div align="left">DESCP</div></th>
        <th width="106" name="t5> <div align="center">COST</div></th>
        <th width="106" name="t5> <div align="center">PRICE</div></th>
		<th width="106" name="t5> <div align="center">UNIT</div></th>
    </tr>
	<?
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>
	  <tr>
		<td><div align="center"><?=$row["BARCODE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="left"><?=$row["DESCP"];?></div></td>
        <td><div align="center"><?=$row["COST"];?></div></td>
		<td align="center"><?=$row["PRICE"];?></td>
        <td align="center"><?=$row["UNIT"];?></td>
        <td width="72" align="center"><a href="update_main_form.php?bar=<?=$row["BARCODE"];?>">EDIT</a>
        
        </td>
    </tr>
	<?
	}
	?>
  </table>
 <input type="submit" value="Add">
</form>
   
	<?
	oci_close($connect);
	

}


	?>

         
        <!-- // footer starts here // -->

<?php 
include("./include/footer.php");
?>