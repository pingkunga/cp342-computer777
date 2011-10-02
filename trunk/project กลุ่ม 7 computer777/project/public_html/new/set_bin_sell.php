<?php   

// Initialize a session.
session_start();
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
	
	echo $_SESSION['userid']."<br>";
	echo $_SESSION['LOC_ID'];
	$B_code = $_SESSION["bar"];
	$unit = $_POST['unit_set'];
	echo $unit;
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "INSERT INTO BIN_SELL (BARCODE,LOC_ID,EMP_ID)VALUES ('".$B_code."','".$_SESSION['LOC_ID']."','".$_SESSION['userid']."') ";
	$objParse = oci_parse ($connect, $strSQL);
	$objExecute = oci_execute($objParse, OCI_DEFAULT);
	if($objExecute)
{
	oci_commit($connect); 
	echo "Save Done.";
	$_SESSION["check"]=1;
	$_SESSION["state_sell"]=1;
}
else
{
	oci_rollback($connect);
	echo "Error Save [".$strSQL."";
	$check_in = 0;
}

oci_close($connect);

//header( 'refresh: 10; url=testjquery.php' );
//header("Location: testjquery.php");
   echo "<meta http-equiv=\"refresh\" content=\"0;url=testjquery.php\" />";


?>

<?php 
include("./include/footer.php");
?>