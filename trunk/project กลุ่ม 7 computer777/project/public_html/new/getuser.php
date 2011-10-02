
<script src="framework.js"> </script>
<script>	
function addCart() {
	document.write("1111");
	var data = "id=" + id;
	var URL = "add_cart.php";

	ajaxLoad('post', URL, data, "cart");
}

function readCart() {
	ajaxLoad('post', "read_cart.php", null, "cart");
}
	</script>	
   </head> 
   <body>
<?php
$q=$_GET["myName"];
echo $q;

include("./include/config.inc.php");
$connect = OCILogon($dbuser,$dbpass,$db);
$strSQL = "SELECT * FROM ITEM WHERE BARCODE='".$q."'";
$objParse = oci_parse ($connect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);

?>
<table border='1' id="tbExp">
<tr>
<th>BARCODE</th>
<th>TYPE</th>
<th>BRAND</th>
<th>DESCP</th>
<th>COST</th>
<th>PRICE</th>
<th>EDIT</th>
</tr>
<?
while($row = oci_fetch_array($objParse,OCI_BOTH))
{
	?>
	
   <tr>
    <td><?=$row["BARCODE"];?></td>
    <td><?=$row["TYPE"];?></td>
    <td><?=$row["BRAND"];?></td>
    <td><?=$row["DESCP"];?></td>
    <td><?=$row["COST"];?></td>
    <td><?=$row["PRICE"];?></td>
    <td><input name="test" id="btnButton" type="button" value="Click" onClick="JavaScript:addCart();"></td>
   
  </tr>
  <?
  }
  ?>
</table>


</body>

