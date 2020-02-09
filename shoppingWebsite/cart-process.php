<?php
$pid = $_GET["pid"];
$name = "";
$price = "";
call_user_func("ierg4210_".$_GET["action"]);

$response = [$name, $price];
echo json_encode($response);
	
function ierg4210_prod_fetchbypid(){
	global $pid;
	global $name;
	global $price;
	
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("SELECT name, price FROM products WHERE pid=?");
	$q->execute(array($pid));
	$Result = $q->fetchAll(PDO::FETCH_ASSOC);
	
	$name = $Result[0]['name'];
	$price = $Result[0]['price'];
}
?>