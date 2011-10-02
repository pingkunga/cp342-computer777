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
<? 
  $barcode_a =array();
  $unit_a =array();
  $unit_ab =array();
 // echo $_POST["unit_up1"];
 
  add_array();
 // update_main();
 ?>

<?
include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
?>

</body>


<?
function add_array()
{
	session_start();
	echo $_session['get_searchs'];
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT B.BARCODE,I.BRAND,I.DESCP,I.COST,I.PRICE,M.UNIT,B.UNIT_B FROM MAIN_STOCK M JOIN ITEM I ON (M.BARCODE=I.BARCODE) JOIN BRANCH B ON (M.BARCODE=B.BARCODE) WHERE TYPE ='CPU' and B.LOC_ID=".$_SESSION['LOC_ID']." ";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	
	for($i=0;$row = oci_fetch_array($objParse,OCI_BOTH);$i++)
	{
		$unit_ab[$i]= $row["UNIT_B"];
		$barcode_a[$i] = $row["BARCODE"];
		//echo $barcode_a[$i] + "  ";
		$y=$i+1;
		$unit_a[$i] = $_POST["unit_up$y"];
		//echo $unit_a[$i] + "<BR>";		
	}
	oci_close($connect);
	
	for($i=0;$i<count($barcode_a);$i++)
	{
		//echo $barcode_a[$i] . "  ";
		//echo $unit_a[$i] . "  ";
		//echo $unit_ab[$i] . " <BR> ";
	}
	include("./include/config.inc.php");
	//echo count($barcode_a);
	for($i=0;$i<count($barcode_a);$i++)
	{
	$unit_sum=$unit_a[$i]+$unit_ab[$i];
	//echo $unit_sum;
	//echo $barcode_a[$i];
	$connect1 = OCILogon($dbuser,$dbpass,$db);
	$strSQL1 = "UPDATE BRANCH SET UNIT_B = ".$unit_sum." WHERE BARCODE = '".$barcode_a[$i]."' ";
	$objParse = oci_parse($connect1, $strSQL1);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	
if($objExecute)
{
	oci_commit($connect1); //*** Commit Transaction ***//
	echo "Save Done.";
}
else
{
	oci_rollback($connect1); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL1."]";
}
oci_close($connect1);
	}
	
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "select BARCODE,UNIT FROM MAIN_STOCK  JOIN BRANCH USING(BARCODE) WHERE LOC_ID=".$_SESSION['LOC_ID']."";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	
	for($i=0;$row = oci_fetch_array($objParse,OCI_BOTH);$i++)
	{
		$unit_ab[$i]= $row["UNIT"];
		$barcode_a[$i] = $row["BARCODE"];
		//echo $barcode_a[$i] + "  ";
		$y=$i+1;
		$unit_a[$i] = $_POST["unit_up$y"];
		//echo $unit_a[$i] + "<BR>";		
	}
	oci_close($connect);
	
	for($i=0;$i<count($barcode_a);$i++)
	{
		//echo $barcode_a[$i] . "  ";
		//echo $unit_a[$i] . "  ";
		//echo $unit_ab[$i] . " <BR> ";
	}
	include("./include/config.inc.php");
	//echo count($barcode_a);
	for($i=0;$i<count($barcode_a);$i++)
	{
	$unit_sum=$unit_ab[$i]-$unit_a[$i];
	//echo $unit_sum;
	//echo $barcode_a[$i];
	$connect1 = OCILogon($dbuser,$dbpass,$db);
	$strSQL1 = "UPDATE MAIN_STOCK SET UNIT = ".$unit_sum." WHERE BARCODE = '".$barcode_a[$i]."' ";
	$objParse = oci_parse($connect1, $strSQL1);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	
if($objExecute)
{
	oci_commit($connect1); //*** Commit Transaction ***//
	echo "Save Done.";
}
else
{
	oci_rollback($connect1); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL1."]";
}
oci_close($connect1);
	}
	
	echo "<meta http-equiv=\"refresh\" content=\"0;url=testjquery.php\" />";

	
}

function update_main()
{
	include("./include/config.inc.php");
	//echo count($barcode_a);
	for($i=0;$i<count($barcode_a);$i++)
	{
	$unit_sum=$unit_a[$i]+$unit_ab[$i];
	//echo $unit_sum;
	//echo $barcode_a[$i];
	$connect1 = OCILogon($dbuser,$dbpass,$db);
	$strSQL1 = "UPDATE BRANCH SET UNIT_B = ".$unit_sum." WHERE BARCODE = '".$barcode_a[$i]."' ";
	$objParse = oci_parse($connect1, $strSQL1);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	
if($objExecute)
{
	oci_commit($connect1); //*** Commit Transaction ***//
	echo "Save Done.";
}
else
{
	oci_rollback($connect1); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL1."]";
}
oci_close($connect1);
	}

}
?>
<?php 
include("./include/footer.php");
?>