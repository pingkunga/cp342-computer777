<?php
session_start();
$sid = session_id();

$pro_id = "";
if(isset($_POST['id'])) {
	$pro_id = $_POST['id'];
}
else {
	exit;
}

include("dbconn.inc.php");

//�����ŷ�����������§��� id �ͧ�Թ���
//������ҧ cart ��ҵ�ͧ�纪�������Ҥ��Թ��ҹ�鹴���
//�ѧ��鹨֧��ͧ���ҹ�����Ź��ҡ���ҧ product ������͹
$sql = "SELECT pro_name, price FROM product
			WHERE pro_id = $pro_id;";
			
$result = mysql_query($sql);
$pro_name = mysql_result($result, 0, 0);
$price = mysql_result($result, 0, 1);

//����������ŧ㹵��ҧ cart �������� REPLACE
//������Ҷ���ա����Ժ��Ө������١����ŧ��ա
$sql = "REPLACE INTO cart VALUES
			('$sid', $pro_id, '$pro_name', $price, 1, NOW());";
		
mysql_query($sql);

//�觼��Ѿ���Ѻ�Ẻ����ʤ�Ի�� ����ѧ�駴��� alert()
//�����¡�ѧ��ѹ readCart() ���������ҹ��¡���ö�����ʴ�����
//��觿ѧ��ѹ��� ����¹��������Ƿ��ྨ index.php ��� product_detail.php
header("content-type: text/javascript; charset=tis-620");
echo "alert('�����Թ���ŧ�ö������'); 
		 readCart();";
?>