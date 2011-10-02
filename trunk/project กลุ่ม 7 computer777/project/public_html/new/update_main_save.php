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


<script>
function box(){
	alert("Update complete");
	window.location='update_main.php';
}


</script>
<? 
	
	$B_code = $_POST["txtBarcode"];
	//echo $_POST["txtUnit"];
	if(is_null($B_code)){
		header("Location:http://oracle.thlol.com/new/update_main.php");
		}
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	//update unit to Mainstock
	$strSQL =  "UPDATE MAIN_STOCK SET UNIT='".$_POST["txtUnit"]."' WHERE BARCODE='".$B_code."'";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
		if($objExecute)
	{
		oci_commit($connect); //*** Commit Transaction ***//
		echo "Save Done1<br>";
		//echo $B_code."and".$_POST["txtUnit"];
		//update other to item
	$strSQL =  "UPDATE ITEM SET BRAND='".$_POST["txtBrand"]."' ,DESCP='".$_POST["txtDescp"]."' ,COST='".$_POST["txtCost"]."' ,PRICE='".$_POST["txtPrice"]."'  WHERE BARCODE='".$B_code."'";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
		if($objExecute)
	{
		oci_commit($connect); //*** Commit Transaction ***//
		echo "Save Done.";  
		echo '<script>box();</script>';
		
	}
	else
	{
		oci_rollback($connect); //*** RollBack Transaction ***//
		echo "Error Save [".$strSQL."";
	}
		
	}
	else
	{
		oci_rollback($connect); //*** RollBack Transaction ***//
		echo "Error Save [".$strSQL."";
	}
	
	

?>

<?php 
include("./include/footer.php");
?>