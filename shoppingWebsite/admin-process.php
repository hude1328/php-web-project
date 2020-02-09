<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
	$cat_name = $_REQUEST["name"];
	$cat_catid = $_REQUEST["catid"];
	$cat_price = $_REQUEST["price"];
	$cat_description = $_REQUEST["description"];
	$cat_newname = $_REQUEST["newName"];
	
	$file = $_FILES["file"];
	$fileName = $file["name"];
	$filePath = $file["tmp_name"];
	move_uploaded_file($filePath, "./img/".$fileName);	

	call_user_func("ierg4210_".$_REQUEST["action"]);

}

function ierg4210_test(){
	print_r($_REQUEST);
}
function ierg4210_cat_insert(){
	global $cat_name;	
	$db = new PDO('sqlite:../cart.db');
	$db->query("PRAGMA foreign_keys = ON;");
	$q = $db->prepare("INSERT INTO categories(name) VALUES('$cat_name')");
	echo $q->execute()." category insert success";
}

function ierg4210_prod_insert(){
	global $cat_name;
	global $cat_catid;
	global $cat_price;
	global $cat_description;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("INSERT INTO products(catid, name, price, description) VALUES($cat_catid, '$cat_name', '$cat_price', '$cat_description')");
	echo $q->execute()." product insert success";
}

function ierg4210_prod_del(){
	global $cat_name;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("DELETE FROM products WHERE name = '$cat_name'");
	echo $q->execute()."product delete success";
}
function ierg4210_prod_update(){
	global $cat_name;
	global $cat_catid;
	global $cat_price;
	global $cat_description;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("UPDATE products SET catid = $cat_catid, price = '$cat_price', description = '$cat_description' WHERE name = '$cat_name';");
	echo $q->execute()." product update success";
}
function ierg4210_cat_del(){
	global $cat_name;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("DELETE FROM categories WHERE name = '$cat_name'");
	echo $q->execute()."category delete success";
}
function ierg4210_cat_update(){
	global $cat_name;
	global $cat_newname;
	$db = new PDO('sqlite:../cart.db');
	$q = $db->prepare("UPDATE categories SET name='$cat_newname' WHERE name='$cat_name'");
	echo $q->execute()."category update success";
}



?>
