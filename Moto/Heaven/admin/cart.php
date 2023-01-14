<head><title>Cart</title></head>
<?php 
require('top.php');
//prx($_SESSION['cart']);
$errorflag=0;
?>

 <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/7.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">shopping cart</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
		
		<?php if(isset($_SESSION['cart']) && $totalProduct!=0){?>
		
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="#"> 
							
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">products</th>
                                            <th class="product-name">name of products</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										//all the products added to the cart are stored in an array .. below we are retrieving all the products of the cart
										//below $key has the product_id
										//if you want to oknow where the id came from .. go back to the 1st page...from there to ...jqery function manage_cart to ..manage_cart.php(which calls functions defined in a class in add_to_cart.php)...which adds the product id to the session_cart
										if(isset($_SESSION['cart'])){
											foreach($_SESSION['cart'] as $key=>$val){
											$productArr=get_product($con,'','',$key);
											//prx($productArr);
											$pname=$productArr[0]['name'];
											$mrp=$productArr[0]['mrp'];
											$price=$productArr[0]['price'];
											$image=$productArr[0]['image'];
											$qty=$val['qty'];
										?>
											<tr>
												<td class="product-thumbnail"><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>"  /></a></td>
												<td class="product-name"><a href="#"><?php echo $pname?></a>
													<ul  class="pro__prize">
														<li class="old__prize"><?php echo "<strike>₹$mrp</strike>"?></li>
														<li><?php echo "₹$price"?></li>
													</ul>
												</td>
												<td class="product-price"><span class="amount"><?php echo "₹$price"?></span></td>
												
												<td class="product-quantity"><input style="color:black; font-size:20px !important; text-align:center;" type="number" id="<?php echo $key?>qty" value="<?php echo $qty;?>" />
												<br/><br/><a style="color:green; padding:3px; border: 1px solid green; margin:8px; " href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','update')">UPDATE </a>
												<?php
												//this condition is used to warn the user if he/she places 0 quantity items ... if this condition returns true then the user can't proceed i.e,the checkout button is not displayed :D
												if($qty<=0){
												
												echo "<h3 style='color:red; font-size:20px;'>Please change the quantity or else you can't proceed</h3>";
												 $errorflag=1;
											    } ?>
												</td>
												<td class="product-subtotal"><?php echo "₹".$qty*$price?></td>
												<td class="product-remove"><a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a></td>
											</tr>
											<?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="buttons-cart--inner">
									
									<!--place the condition here -->
                                        <div class="buttons-cart">
                                            <a href="<?php echo SITE_PATH?>">Continue Shopping</a>
                                        </div>
										
										<!-- here if you notice we are typing <?php //echo $key;?> as the first parameter of the manage cart function to avoid the blinking error which displays array..offset...null...at the footer -->
										<div class="buttons-cart">
										<a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','empty')"><i class="icon-trash icons"></i>Empty Cart</a>
										</DIV>
										
										
										<?php
										   if($errorflag==0 ){
										?>	   
                                        <div class="buttons-cart checkout--btn">
                                            <a href="<?php echo SITE_PATH?>checkout.php">checkout</a>
                                        </div>
										<?php 
										   }else{
										?>
									   <!-- <a style='color:red; font-family:calibri; font-weight:700;'>Please Note That if you place 0 items ..Your Order cannot be placed</a> -->
										<?php } ?>
									
									
									
									</div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <?php }else{echo " <div class='container'><h2 style='padding-left:40px;margin-top:100px;margin-bottom:20px;'>Your Cart is empty......</h2></div>";?>
		<div class="container"><div style="padding-left:40px;margin-top:20px;margin-bottom:200px;" class="buttons-cart"><a href="<?php echo SITE_PATH?>">Continue Shopping</a></div></div>
		<?php	} ?>
										
<?php require('footer.php')?>        