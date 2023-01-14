<?php

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}


//prints the array (development time only)
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

//prints the array and stops execution of the program(development time only)
function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}



//function to get the products
function get_product($con,$limit='',$cat_id='',$product_id='',$search_str='',$sort_order='',$is_best_seller='',$sub_categories=''){
	$sql="select product.*,categories.categories from product,categories where product.status=1 ";
	
	//in the below statetements we are concatenating to the above sql ..(specified conditions)//
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id ";
	}
	
	if($sub_categories!=''){
		$sql.=" and product.sub_categories_id=$sub_categories ";
	}
	
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	
	if($is_best_seller!=''){
		$sql.=" and product.best_seller=1 ";
	}
	$sql.=" and product.categories_id=categories.id ";
	
	if($search_str!=''){
		$sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%') ";
	}
	
	if($sort_order!=''){
		$sql.=$sort_order;
	}else{
		$sql.=" order by product.id desc ";
	}
	
	if($limit!=''){
		$sql.=" limit $limit";
	}
	//echo $sql;
	
	
	$res=mysqli_query($con,$sql);
	//this will be holding the list of products retrived based on the specified conditions
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function wishlist_add($con,$uid,$pid){
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into wishlist(user_id,product_id,added_on) values('$uid','$pid','$added_on')");
}

function productSoldQtyByProductId($con,$pid){
	$sql="select sum(order_detail.qty) as qty from order_detail,`order` where `order`.id=order_detail.order_id and order_detail.product_id=$pid and `order`.order_status!=4 and ((`order`.payment_type='payu' and `order`.payment_status='Success') or (`order`.payment_type='COD' and `order`.payment_status!=''))";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}

function productQty($con,$pid){
	$sql="select qty from product where id='$pid'";
	$res=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($res);
	return $row['qty'];
}
?>