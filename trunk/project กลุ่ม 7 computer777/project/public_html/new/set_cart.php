<?
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


//addall();
//setnewcart();
//setnewcart();
/*
echo $_POST["hdnLine"];
for($i=1;$i<$_POST["hdnLine"];$i++)
	{
		echo $_POST["unit_set$i"] ;
		echo $_POST["barcodes$i"] ;
	}
	$strSQL2 = "INSERT INTO SELL_DETAIL (LOC_ID,BARCODE,UNIT,DATE_SELL) ";
			$strSQL2 .="VALUES ";
			$strSQL2 .="('1','".$row["BARCODE"]."', ";
			$strSQL2 .="'".$_POST["unit_set$i"]."', ";
			$strSQL2 .="'".date("Y-m-d")."')";
			
			echo $strSQL2;
			*/
			

?>

<p>
  <?
addall();
include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "select L.LOC_NAME,B.BARCODE,I.DESCP,I.PRICE,S.UNIT,S.DATE_SELL,S.TIME_SELL 
from BIN_SELL B Left JOIN SELL_DETAIL S  ON(B.BARCODE=S.BARCODE)  left JOIN ITEM I ON(I.BARCODE=S.BARCODE) left JOIN LOCATION L ON(B.LOC_ID=L.LOC_ID) WHERE   S.LOC_ID = '".$_SESSION['LOC_ID']."' and S.TIME_SELL= '".date("H:i:s")."'";
	
	
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	?>   
</p>
<table width="690" border="0">
  <tr>
  <? 
  
  ?>
    <td width="199">BRANCH :  <?=$_SESSION['LOC_ID']; ?> </td>
    <td width="172">Name  :  <?=$_SESSION['first_name']; ?></td>
    <td width="305">DATE : <?=date("Y-m-d"); ?></td>
  </tr>
</table>
<br>
<form name="BIN_create" >
  <table width="1070" border="1" class="tablesorter">
<tr>
		<!--<th width="102" name="t1"> <div align="center">LOC_NAME</div></th>-->
		<th width="90" height="24" name="t2"> <div align="center">BARCODE</div></th>
    <th width="278" name="t4"> <div align="center">DESCP</div></th>
		<th width="115" name="t3"> <div align="center">UNIT </div></th>
		<th width="115" name="t4"> <div align="center">PRICE</div></th>
        <th width="106" name="t5> <div align="center">SUM PRICE</div></th>
    </tr>
	<?
	$sum_all_price=0;
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		$sum_all_price=$sum_all_price+$row["UNIT"]*$row["PRICE"];
	?>
	  <tr>
		<td><div align="center"><?=$row["BARCODE"];?></div></td>
		<td><div align="center"><?=$row["DESCP"];?></div></td>
		<td><div align="center"><?=$row["UNIT"];?></div></td>
		<td><div align="center"><?=$row["PRICE"];?></div></td>
        <td align="center"><?=$row["UNIT"]*$row["PRICE"];?></td>
    </tr>
	<?
	}
	setnewcart();
	?>
  </table>
</form>

<form name="sum_bin" action="testjquery.php">
<table width="1076" border="1">
  <tr>
    <td width="891" height="23"><div align="center">SUM OF <span id="result_box" lang="en">RECEIPT</span></div></td>
    <td width="169"><div align="center">
      <?
echo $sum_all_price;
?>
    </div></td>
  </tr>
</table>
<p>
  <input type="submit" name="button" id="button" value="Submit" onclick>
</p>

</form>
</body>




<?			
function addall() //เอาของลง sell_detail
{
	$a[$_POST["hdnLine"]-2];
	$unit_ab =array();
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "select * from BIN_SELL";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	$c_array=0;
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		$a[$c_array]=$row["BARCODE"];
		$unit_ab[$c_array]=$row["UNIT_B"];
		//echo $_POST["hdnLine"];
		$c_array++;
	}
	oci_close($connect);
	
	
	
		$line=$_POST["hdnLine"];
	for( $check_line=1; $check_line<$line; $check_line++)
	{		$mkdate=date("d-M-Y");
			$strSQL2 = "INSERT INTO SELL_DETAIL (LOC_ID,BARCODE,UNIT,DATE_SELL,TIME_SELL) ";
			$strSQL2 .="VALUES ";
			$strSQL2 .="('".$_SESSION['LOC_ID']."','".$a[$check_line-1]."', ";
			$strSQL2 .="'".$_POST["unit_set$check_line"]."', ";
			$strSQL2 .="'".$mkdate."', ";
			$strSQL2 .="'".date("H:i:s")."')";
			$connect1 = OCILogon($dbuser,$dbpass,$db);
			$objParse2 = oci_parse ($connect1, $strSQL2);
			$objExecute= oci_execute ($objParse2,OCI_DEFAULT);
			if($objExecute)
			{
				oci_commit($connect1);
				
				//echo "Save Done.";  oci_close($connect1);
			}
			else
			{
				oci_rollback($connect1); 
				echo "กรอกข้อมูลที่เป็นตัวเลข"; 
				header( 'refresh: 5; url=testjquery.php' );
			}
		oci_close($connect1);
	}
	
	echo $line."  ";
	// Check
	/*for( $check_line=1; $check_line<$line; $check_line++)
			{
			
			echo $a[$check_line-1]."  ";
			echo $unit_ab[$check_line-1]."  ";
			echo $_POST["unit_set$check_line"];
			}*/
	
		for( $check_line=1; $check_line<$line; $check_line++)
			{
			$strSQL3 = "UPDATE BRANCH SET UNIT_B = UNIT_B-".$_POST["unit_set$check_line"]." WHERE BARCODE='".$a[$check_line-1]."' ";
			$connect2 = OCILogon($dbuser,$dbpass,$db);
			$objParse3 = oci_parse ($connect2, $strSQL3);
			$objExecute= oci_execute ($objParse3,OCI_DEFAULT);
			if($objExecute)
			{
				oci_commit($connect2);
				
				//echo "Save Done.";  oci_close($connect1);
			}
			else
			{
				oci_rollback($connect2); 
				echo "กรอกข้อมูลที่เป็นตัวเลข"; 
				//header( 'refresh: 5; url=testjquery.php' );
			}
		oci_close($connect2);
	}
	
}





function setnewcart(){
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "truncate table bin_sell";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if($objExecute)
{
	oci_commit($connect); //*** Commit Transaction ***//
	//echo "Record Deleted.";
}
else
{
	oci_rollback($connect); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL."";
}
oci_close($connect);
//header( 'refresh: 5; url=testjquery.php' );
//header("Location: testjquery.php");
}
?>

         
        <!-- // footer starts here // -->

<?php 
include("./include/footer.php");
?>