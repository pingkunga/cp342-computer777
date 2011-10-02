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

<link rel="stylesheet" type="text/css" media="all" href="./include/jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="./include/jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%d-%M-%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
</script>

	<?php	
include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
$do=$_GET['do'];
	if($do=="search") {
$q=$_POST['date'];
$strSQL = "SELECT LOC_ID,BARCODE,UNIT,PRICE,TIME_SELL
FROM SELL_DETAIL JOIN ITEM USING(BARCODE)
WHERE LOC_ID=1 AND DATE_SELL='".$q."'";
	} else {
		$q='22-Sep-2011';
		$strSQL = "SELECT LOC_ID,BARCODE,UNIT,PRICE,TIME_SELL
FROM SELL_DETAIL JOIN ITEM USING(BARCODE)
WHERE LOC_ID=1 AND DATE_SELL='".$q."'";
		}
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
?>

         <!-- // content starts here // -->
        
        <div id="content">
        <form action="brance_sum.php?do=search" method="post">               
	

            <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                     <h2>เรียกดูยอดขายตามวันที่ <?=$q;?></h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content" id="contacts-1a">
                    <div class="inbox-sf">
                        <input type="text" size="12" id="inputField" name="date" class="input-1"  value="" />
                        <input type="submit" name="" value="ค้นหา" class="inbox-sf-search-btn" />
                    </div>
                    
					<table id="tablesorter-contact"> 
                    	<thead class="contacts-head-1"> 
                            <tr> 
                            <th class="contacts-head-1-select"></th>
                            	<th class="contacts-head-1-date">วันที่</th>
                                <th class="contacts-head-1-barcode">บาร์โค้ด</th>
                                <th class="contacts-head-1-unit">จำนวน</th>
                                <th class="contacts-head-1-price">ราคา</th>                 
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
                                               <?php
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	$sprice=$row["PRICE"]*$row["UNIT"]; 
	echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[TIME_SELL]</td>
	<td class=\"contacts-content-1-barcode\">$row[BARCODE]</td>
	<td class=\"contacts-content-1-unit\">$row[UNIT]</td>
	<td class=\"contacts-content-1-price\">$sprice</td>
	</tr>";
	
}
oci_close($connect);
?>
                        </tbody>                        
                    </table>
                    <ul class="contacts-head-1 no-border-top">
                    	<li class="contacts-head-1-select"></li>
                        <li class="contacts-head-1-date">วันที่</li>
                        <li class="contacts-head-1-barcode">บาร์โค้ด</li>
                        <li class="contacts-head-1-unit">จำนวน</li>
                        <li class="contacts-head-1-price">ราคา</li>
                    </ul>                        
                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
            
            
        </form><!-- END form-->                                              
        </div><!-- END "#content" -->
         
        <!-- // footer starts here // -->
<?php 
include("./include/footer.php");
?>