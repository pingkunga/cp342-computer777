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
<script language="JavaScript">


	   var HttPRequest = false;

	   function doCallAjax() {
		  HttPRequest = false;
		  if (window.XMLHttpRequest) { // Mozilla, Safari,...
			 HttPRequest = new XMLHttpRequest();
			 if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			 }
		  } else if (window.ActiveXObject) { // IE
			 try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			 } catch (e) {
				try {
				   HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			 }
		  } 
		  
		  if (!HttPRequest) {
			 alert('Cannot create XMLHTTP instance');
			 return false;
		  }
	
			
	
			var url = 'show_main_sum1.php?myName='+document.getElementById("inputField").value+'&lname='+document.getElementById("txtKeyword").value;

			// var url = 'show_main_sum1.php?myName='+document.getElementById("txtName").value&my2=
			  // 2 Parameters
			HttPRequest.open('GET',url,true);
			HttPRequest.send(null);
			
			
			HttPRequest.onreadystatechange = function()
			{

				 if(HttPRequest.readyState == 3)  // Loading Request
				  {
				   document.getElementById("mySpan").innerHTML = "Now is Loading...";
				  }

				 if(HttPRequest.readyState == 4) // Return Request
				  {
				   document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
				  }
				
			}

			/*
			HttPRequest.onreadystatechange = call function .... // Call other function
			*/

	   }
	   
	    
	</script>	
<body>
<? include("../new/include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT LOC_ID, LOC_NAME FROM LOCATION";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	?>
    
  SUM OF สาขา:<select name="txtKeyword" id="txtKeyword">  
	<?
	while($objResult = oci_fetch_array($objParse,OCI_BOTH))
	{
	?>  
	<option value="<?=$objResult["LOC_ID"];?>"><?=$objResult["LOC_NAME"];?></option>
	<?
	}oci_close($connect);
	?>	
	</select> 
	
	วันที่: <input type="text" size="12" id="inputField" />
	<input name="btnButton" id="btnButton" type="button" value="Click" onClick="JavaScript:doCallAjax();">
	<br>
	<span id="mySpan"></span>
<?php 
include("./include/footer.php");
?>