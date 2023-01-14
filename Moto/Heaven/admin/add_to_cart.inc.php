<?php
//the cart items are stored in the session and the wishlist items are stored in the database
class add_to_cart{
	//to add a product
	function addProduct($pid,$qty){
		$_SESSION['cart'][$pid]['qty']=$qty;
	}
	
	//to update a product
	function updateProduct($pid,$qty){
		if(isset($_SESSION['cart'][$pid])){
			$_SESSION['cart'][$pid]['qty']=$qty;
		}
	}
	
	//to remove a product
	function removeProduct($pid){
		if(isset($_SESSION['cart'][$pid])){
			unset($_SESSION['cart'][$pid]);
		}
	}
	
	//a function to calculate
	function totalProduct(){
		if(isset($_SESSION['cart'])){
			return count($_SESSION['cart']);
		}else{
			return 0;
		}
		
		if(count($_SESSION['cart']==0)){
			unset($_SESSION['cart']);
		}
		
	}
	
	//this is to empty the cart 
	function emptyProduct(){
		unset($_SESSION['cart']);
	}

}
?>