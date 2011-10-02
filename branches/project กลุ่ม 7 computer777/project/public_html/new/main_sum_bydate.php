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
             <!-- // content starts here // -->
        
        <div id="content">
        <form action="main_sum_bydate.php" method="get">               
	
<?php
$q=$_GET["date"];
include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);


?>
            <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                     <h2>เรียกดูยอดขายของวันที่ <?=$q;?></h2>
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
                            	<th class="contacts-head-1-date">ชนิด</th>
                                <th class="contacts-head-1-barcode">ยอดขาย</th>             
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
                                               <?php
											   //--------BRANCH1--------
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='1'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[TYPE]</td>
	<td class=\"contacts-content-1-barcode\">".$row[COUNT(BARCODE)],"</td>
	</tr>";
	
}

?>
                        </tbody>                        
                    </table>
                  <?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='1'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];
?>





                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
            
            <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                     <h2>เรียกดูยอดขายของวันที่ <?=$q;?></h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content" id="contacts-1a">
					<table id="tablesorter-contact"> 
                    	<thead class="contacts-head-1"> 
                            <tr> 
                            <th class="contacts-head-1-select"></th>
                            	<th class="contacts-head-1-date">ชนิด</th>
                                <th class="contacts-head-1-barcode">ยอดขาย</th>             
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
                                               <?php
											   //----------BRANCH2
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='2'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[TYPE]</td>
	<td class=\"contacts-content-1-barcode\">".$row[COUNT(BARCODE)],"</td>
	</tr>";
	
}

?>
                        </tbody>                        
                    </table>
                  <?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='2'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];
?>





                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
            
            
                     <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                     <h2>เรียกดูยอดขายของวันที่ <?=$q;?></h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content" id="contacts-1a">
					<table id="tablesorter-contact"> 
                    	<thead class="contacts-head-1"> 
                            <tr> 
                            <th class="contacts-head-1-select"></th>
                            	<th class="contacts-head-1-date">ชนิด</th>
                                <th class="contacts-head-1-barcode">ยอดขาย</th>             
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
                                               <?php
											   //--------BRANCH3--------
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='3'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[TYPE]</td>
	<td class=\"contacts-content-1-barcode\">".$row[COUNT(BARCODE)],"</td>
	</tr>";
	
}

?>
                        </tbody>                        
                    </table>
                  <?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='3'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];
?>





                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
            
            
                     <!-- new box --> 
           
        	<div class="box corners shadow">
                <div class="box-header">
                     <h2>เรียกดูยอดขาย วันที่ <?=$q;?> </h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content" id="contacts-1a">
					<table id="tablesorter-contact"> 
                    	<thead class="contacts-head-1"> 
                            <tr> 
                            <th class="contacts-head-1-select"></th>
                            	<th class="contacts-head-1-date">ชนิด</th>
                                <th class="contacts-head-1-barcode">ยอดขาย</th>             
                            </tr> 
                        </thead> 
                        <tbody class="contacts-content-1"> 
                                               <?php
											   //----------BRANCH4
$strSQL = "SELECT TYPE,COUNT(BARCODE)
FROM SELL_DETAIL S  JOIN ITEM I  using(BARCODE)
JOIN LOCATION L using(LOC_ID)
where DATE_SELL='".$q."' and LOC_ID='4'
GROUP BY TYPE";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	echo "
	<tr class=\"hl-row\">
	<td class=\"contacts-content-1-select\"></td>
	<td class=\"contacts-content-1-date\">$row[TYPE]</td>
	<td class=\"contacts-content-1-barcode\">".$row[COUNT(BARCODE)],"</td>
	</tr>";
	
}

?>
                        </tbody>                        
                    </table>
                  <?
$strSQL = "SELECT LOC_NAME,EMP_NAME
FROM EMPLOYEE E  JOIN LOCATION L  using(LOC_ID)
WHERE LOC_ID='4'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
$row = oci_fetch_array($objParse,OCI_BOTH);
echo "สาขา : ".$row["LOC_NAME"]."   ผู้จัดการ : ".$row["EMP_NAME"];
?>





                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" -->
            
            
        </form><!-- END form-->                                              
        </div><!-- END "#content" -->
         
        <!-- // footer starts here // -->
    
    
<?php 
include("./include/footer.php");
?>