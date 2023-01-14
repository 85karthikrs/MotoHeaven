<?php
require('connection.inc.php');
require('functions.inc.php');

//importing the program which has the class add_to_cart
require('add_to_cart.inc.php');

$pid=get_safe_value($con,$_POST['pid']);
$qty=get_safe_value($con,$_POST['qty']);
$type=get_safe_value($con,$_POST['type']);

$productSoldQtyByProductId=productSoldQtyByProductId($con,$pid);
$productQty=productQty($con,$pid);

$pending_qty=$productQty-$productSoldQtyByProductId;

if($qty>$pending_qty){
	echo "not_avaliable";
	die();
}

//$obj is a new instance of the class add_to_cart
$obj=new add_to_cart();

if($type=='add'){
	//calling the functions of the class add_to_cart
	$obj->addProduct($pid,$qty);
}

if($type=='remove'){
	$obj->removeProduct($pid);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty);
}

if($type=='empty'){
	$obj->emptyProduct();
	//the below code redirects the current page i.e,catr.php to index.php after clearing the cart
	?> 
 <!--	<script>
	window.location.href='index.php';
	</script> -->
	
	<?php
}


echo $obj->totalProduct();
?>