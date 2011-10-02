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

echo $_GET["del_barcode"];

include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "DELETE FROM BIN_SELL ";
	$strSQL .="WHERE barcode = '".$_GET["del_barcode"]."' ";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if($objExecute)
{
	oci_commit($connect); //*** Commit Transaction ***//
	echo "Record Deleted.";
}
else
{
	oci_rollback($connect); //*** RollBack Transaction ***//
	echo "Error Save [".$strSQL."";
}
oci_close($connect);
//header( 'refresh: 5; url=testjquery.php' );
 echo "<meta http-equiv=\"refresh\" content=\"0;url=testjquery.php\" />";
?>
<?php 
include("./include/footer.php");
?>
