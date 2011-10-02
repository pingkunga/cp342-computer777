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
 <!-- // content starts here // -->
 <div id="content">
<form action="search.php?do=search" method="POST" enctype="multipart/form-data" >
   <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                    <h2>ค้นหาสินค้า</h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content" id="contacts-1a">
                    <div class="inbox-sf">
                        <input type="text" name="txtKeyword" onFocus="if(this.value=='ใส่คำค้นที่นี่')this.value='';" onBlur="if(this.value=='')this.value='ใส่คำค้นที่นี่';" value="ใส่คำค้นที่นี่" class="input-1"/>
                            <select name="Search2" class="select-1" >
     <option value="BARCODE">บาร์โค้ด</option>
     <option value="TYPE">ชนิด</option>
     <option value="BRAND">ยี่ห้อ</option>
     <option value="DESCP">คำอธิบาย</option>
</select>
                        <input type="submit" name="" value="ค้นหา" class="inbox-sf-search-btn" />
                        <input type="submit" name="" value="เพิ่ม" id="open-contacts-dialog-btn-tb" class="inbox-sf-add-btn tip" title="เพิ่มสินค้น"/>  
                    </div> 
					<table id="tablesorter-contact"> 
                    	<thead class="contacts-head-1"> 
                            <tr> 
                                <th class="contacts-head-1-select"></th>
                                <th class="contacts-head-1-date">รหัสบาร์โค้ด</th>
                                <th class="contacts-head-1-id">ชนิด</th>
                                <th class="contacts-head-1-brand">ยี่ห้อ</th>
                                <th class="contacts-head-1-des">คำอธิบาย</th>
                                <th class="contacts-head-1-id">ราคารับ</th>
                                <th class="contacts-head-1-id">ราคาขาย</th>
                                <th class="contacts-head-1-id">จำนวน</th>
                                <th class="contacts-head-1-actions">Actions</th>                        
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
     <?php
 
	$do=$_GET['do'];
	if($do=="search") {
	$key_search = $_POST['txtKeyword'];
	$Search2 = $_POST['Search2'];
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT * FROM ITEM JOIN MAIN_STOCK USING(BARCODE) WHERE ".$Search2." like '%".$key_search."%'";
	//$strSQL = "SELECT * FROM BIN_SELL JOIN ITEM using ".$Search2." like '%".$key_search."%'";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		 $_SESSION["bar"]=$row["BARCODE"];
		echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[BARCODE]</td>
	<td class=\"contacts-content-1-id\">$row[TYPE]</td>
	<td class=\"contacts-content-1-brand\">$row[BRAND]</td>
	<td class=\"contacts-content-1-des\">$row[DESCP]</td>
	<td class=\"contacts-content-1-id\">$row[COST]</td>
	<td class=\"contacts-content-1-id\">$row[PRICE]</td>
    </tr>";
	
    	}
		oci_close($connect);
	} elseif($do=="normal") {
	$key_search = $_POST['txtKeyword'];
	$Search2 = $_POST['Search2'];
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT * FROM ITEM WHERE DESCP like '%".$key_search."%'";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		 $_SESSION["bar"]=$row["BARCODE"];
		echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[BARCODE]</td>
	<td class=\"contacts-content-1-id\">$row[TYPE]</td>
	<td class=\"contacts-content-1-brand\">$row[BRAND]</td>
	<td class=\"contacts-content-1-des\">$row[DESCP]</td>
	<td class=\"contacts-content-1-id\">$row[COST]</td>
	<td class=\"contacts-content-1-id\">$row[PRICE]</td>
    </tr>";
	
    	}
		oci_close($connect);
	} else {
		$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT * FROM ITEM";
	
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	while($row = oci_fetch_array($objParse,OCI_BOTH))
	{
		 $_SESSION["bar"]=$row["BARCODE"];
		echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[BARCODE]</td>
	<td class=\"contacts-content-1-id\">$row[TYPE]</td>
	<td class=\"contacts-content-1-brand\">$row[BRAND]</td>
	<td class=\"contacts-content-1-des\">$row[DESCP]</td>
	<td class=\"contacts-content-1-id\">$row[COST]</td>
	<td class=\"contacts-content-1-id\">$row[PRICE]</td>
    </tr>";
	
    	}
		oci_close($connect);
		
		
		}
	?>                            
                        </tbody>                        
                    </table>
                    <ul class="contacts-head-1 no-border-top">
                    			<li class="contacts-head-1-select"></li>
                           		<li class="contacts-head-1-date">รหัสบาร์โค้ด</li>
                                <li class="contacts-head-1-id">ชนิด</li>
                                <li class="contacts-head-1-brand">ยี่ห้อ</li>
                                <li class="contacts-head-1-des">คำอธิบาย</li>
                                <li class="contacts-head-1-id">ราคารับ</li>
                                <li class="contacts-head-1-id">ราคาขาย</li>
                                <li class="contacts-head-1-id">จำนวน</li>
                                <li class="contacts-head-1-actions">Actions</li>       
                    </ul>                  
                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
                                   
        </form><!-- END form-->                                              
        </div><!-- END "#content" -->
         
        <!-- // footer starts here // -->

<?php 
include("./include/footer.php");
?>