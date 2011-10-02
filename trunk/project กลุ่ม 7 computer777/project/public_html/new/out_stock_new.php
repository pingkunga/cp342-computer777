<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>==SELLING==</title>
<script type="text/javascript" src="../path/to/jquery-latest.js"></script> 
<script type="text/javascript" src="../path/to/jquery.tablesorter.js"></script> 

<script type="text/javascript" >
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 

function on_click(){
 var frm=document.form2;
 var id=frm.unit_set.value;
 alert (id);

 }

</script> 

<link rel="stylesheet" type="text/css" href="../path/to/themes/blue/style.css" />

</head>

<body>

<?
	session_start();
	$_session['get_searchs'];
	$_session['get_searchs']=$_GET["txtKeyword"];
?>

<form name="frmSearch" method="get" action="<?=$_SERVER['SCRIPT_NAME'];?>">
  <table width="1066" border="1"                                        >
    <tr>
      <th width="1056">Select type    
      <select name="txtKeyword" id="txtKeyword" value="<? $_session['get_searchs'];?>" >
			<option value="<?=$_GET["txtKeyword"]="CPU";?>">CPU</option>
   			<option value="<?=$_GET["txtKeyword"]="RAM";?>">RAM</option>
    		<option value="<?=$_GET["txtKeyword"]="HDD";?>">HDD</option>
    		<option value="<?=$_GET["txtKeyword"]="MB";?>">MAINBOARD</option>
  		</select>
      <input type="submit" value="Search"></th>
    </tr>
  </table>
</form>
<p>
  <? 
  
if(true)
	{
	//echo $_session['get_searchs'];
	include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "SELECT BARCODE,BRAND,DESCP,COST,PRICE,UNIT 
FROM MAIN_STOCK  JOIN ITEM USING (BARCODE) 
WHERE TYPE ='".$_session['get_searchs']."' AND BARCODE !=ALL(SELECT BARCODE FROM BRANCH)";
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);

	?>
</p>
<form name="form1" action="update_cart_new.php" method="post" enctype="multipart/form-data">
  <table width="1081" border="1" class="tablesorter">
<tr>
		<th width="143" name="t3"> <div align="center">Barcode</div></th>
		<th width="143" name="t3"> <div align="center">Brand</div></th>
		<th width="552" name="t4"> <div align="center">DESCP</div></th>
        <th width="66" name="t5> <div align="center">COST</div></th>
        <th width="76" name="t5> <div align="center">PRICE</div></th>
		<th width="61" name="t5> <div align="center">UNIT</div></th>
        <th width="61" name="t5> <div align="center">GET_UNIT</div></th>
    </tr>
	<?
	for($check_line=1;$row = oci_fetch_array($objParse,OCI_BOTH);$check_line++)
	{
	?>
	  <tr>
		<td><div align="center"><?=$row["BARCODE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="left"><?=$row["DESCP"];?></div></td>
        <td><div align="center"><?=$row["COST"];?></div></td>
		<td align="center"><?=$row["PRICE"];?></td>
        <td align="center"><?=$row["UNIT"];?></td>
        <td><div align="center"><input name="unit_up<?=$check_line;?>" type="text" size="2" value="0"/></div></td>
    </tr>
	<?
	}
	?>
  </table>
    <input type="submit" value="Add">
</form>
	<?
	oci_close($connect);
	
	/*show_add();	*/
}

	function show_add()
	{
		include("./include/config.inc.php");
	$connect = OCILogon($dbuser,$dbpass,$db);
	$strSQL = "select BARCODE,TYPE,BRAND,DESCP,PRICE FROM BIN_SELL JOIN ITEM using(BARCODE)";
	
	$objParse = oci_parse ($connect, $strSQL);
	oci_execute ($objParse,OCI_DEFAULT);
	$Num_Rows = oci_fetch_all($objParse, $Result);
	oci_execute ($objParse,OCI_DEFAULT);
	//echo $Num_Rows;
	?>
    
<form action="update_cart.php" method="post" enctype="multipart/form-data" name="form2">
	<table width="1070" border="1" class="tablesorter">
	<tr>
		<th width="109" name="t1"> <div align="center">Barcode</div></th>
		<th width="98" name="t2"> <div align="center">Type</div></th>
		<th width="123" name="t3"> <div align="center">Brand </div></th>
		<th width="305" name="t4"> <div align="center">DESCP</div></th>
		<th width="41" name="t5> <div align="center">Price</div></th>
        <th width="58" align="center" name="t6> <div align="center">Unit</div></th>
        <th width="58" align="center" name="t6> <div align="center">Unit Main</div></th>
        <th width="31" name="t7> <div align="center">Delete</div></th>
		
	  </tr>
	<?
	 $line = $Num_Rows;
  if($line == 0)
  {$line=1;}
	for($check_line=1;$row = oci_fetch_array($objParse,OCI_BOTH);$check_line++)
	{
			if($row["BARCODE"]){}
	?>
	  <tr>
		<td><label name="barcodes<?=$check_line;?>"><?=$row["BARCODE"];?></label></td>
		<td><div align="center"><?=$row["TYPE"];?></div></td>
		<td><div align="center"><?=$row["BRAND"];?></div></td>
		<td><div align="center"><?=$row["DESCP"];?></div></td>
		<td align="center"><?=$row["PRICE"];?></td>
        <td><div align="center"><input name="unit_set<?=$check_line;?>" type="text" size="2" value="1"/></div></td>
        <td align="center" ><a href="../del_cart.php?del_barcode=<?=$row["BARCODE"];?>">Delete</a></td>
            
	  </tr>
      <?
	}
	oci_close($connect); 
	?>
    </table>
    
    <input type="submit" name="check_cart" id="check_cart" value="UPDATE" />
    <input type="hidden" name="hdnLine" value="<?=$check_line;?>">
</form>
    <?
	}
	?>
    

</body>
</html>