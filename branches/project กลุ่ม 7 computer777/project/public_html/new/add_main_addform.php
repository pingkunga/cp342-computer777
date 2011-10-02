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

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

</script>

<form action="add_main_save.php" name="frmAdd" method="post">
Add : 
<select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
<?
for($i=1;$i<=50;$i++)
{
	if($_GET["Line"] == $i)
	{
		$sel = "selected";
	}
	else
	{
		$sel = "";
	}
?>
	<option value="<?=$_SERVER["PHP_SELF"];?>?Line=<?=$i;?>" <?=$sel;?>><?=$i;?></option>
<?
}
?>
</select> item.
<table width="600" border="1">
  <tr>

    <th width="160"> <div align="center">type</div></th>
    <th width="198"> <div align="center">brand</div></th>
    <th width="97"> <div align="center">descp</div></th>
    <th width="97"> <div align="center">unit</div></th>
    <th width="97"> <div align="center">cost</div></th>
    <th width="97"> <div align="center">price</div></th>

  </tr>
  <?
  $line = $_GET["Line"];
  if($line == 0)
  {$line=1;}
  for($i=1;$i<=$line;$i++)
  {
  ?>
  <tr>
   
    <td>
    <select name="txtType<?=$i;?>" >
	<option value="CPU">CPU</option>
    <option value="RAM">RAM</option>
    <option value="HDD">HDD</option>
    <option value="MB">MAINBOARD</option>
  </select>
    </td>
    <td><input type="text" name="txtBrand<?=$i;?>" size="20"></td>
    <td><input type="text" name="txtDescp<?=$i;?>" size="20"></td>
    <td><input type="text" name="txtUnit<?=$i;?>" size="6"></td>
    <td><input type="text" name="txtCost<?=$i;?>" size="20"></td>
    <td><input type="text" name="txtPrice<?=$i;?>" size="20"></td>
  </tr>
  <?
  }
  ?>
  </table>

  <input type="submit" name="submit" value="submit">
 
  <input type="hidden" name="hdnLine" value="<?=$i;?>">
  
  </form>
         
        <!-- // footer starts here // -->
<?php 
include("./include/footer.php");
?>