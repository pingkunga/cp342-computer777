<?php   

// Initialize a session.
session_start();
session_register("bar");
session_register("state_sell");
session_register("del_bar");
include("./include/config.inc.php");	
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
<script language="javascript">
function B_alert()
{	
	
	 alert("Add stock complete.");
}
</script>

<?php


function barcode_mke()
{
	$key = "123456789100987654321ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
srand((double)microtime()*1000000); 
	for($i=0; $i<5; $i++) { 
	$pass_rand .= $key[rand()%strlen($key)]; 
	} 
	return $pass_rand;
}



$connect = OCILogon($dbuser,$dbpass,$db);

for($i=1;$i<=$_POST["hdnLine"];$i++)
	{
		if($_POST["txtType$i"] != "")
		{	echo "test";
			$code=barcode_mke();
		// insert ตารางitem 
			$strSQL = "INSERT INTO ITEM ";
			$strSQL .="VALUES ";
			$strSQL .="('".$code."','".$_POST["txtType$i"]."', ";
			$strSQL .="'".$_POST["txtBrand$i"]."', ";
			$strSQL .="'".$_POST["txtDescp$i"]."',";
			$strSQL .="'".$_POST["txtCost$i"]."' ";
			$strSQL .=",'".$_POST["txtPrice$i"]."')";
			$objParse = oci_parse ($connect, $strSQL);
			$objExecute=oci_execute ($objParse,OCI_DEFAULT);
			if($objExecute)
			{
				oci_commit($connect); //*** Commit Transaction ***//
				
				echo "Save Done.";  
			}
			else
			{
				oci_rollback($connect); //*** RollBack Transaction ***//
				echo "Error Save [".$strSQL."]"; 
			}
			
			//insert ตาราง main_stock
			$connect1 = OCILogon($dbuser,$dbpass,$db);
			$strSQL1  = "INSERT INTO MAIN_STOCK(BARCODE,UNIT)";
			$strSQL1 .="VALUES ";
			$strSQL1 .="('".$code."','".$_POST["txtUnit$i"]."') ";

			$objParse1 = oci_parse ($connect1, $strSQL1);
			$objExecute1=oci_execute ($objParse1,OCI_DEFAULT);
			if($objExecute1)
			{
				oci_commit($connect1); //*** Commit Transaction ***//
				
				echo "Save Done."; 
				
			}
			else
			{
				oci_rollback($connect1); //*** RollBack Transaction ***//
				echo "Error Save [".$strSQL1."]"; 
			}
			
		}
	}oci_close($connect);
	echo '<script>B_alert();</script>';
	
   echo "<meta http-equiv=\"refresh\" content=\"0;url=add_main_addform.php\" />";







?>
         
        <!-- // footer starts here // -->
<?php 
include("./include/footer.php");
?>