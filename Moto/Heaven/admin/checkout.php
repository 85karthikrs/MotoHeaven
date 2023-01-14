<head><title>Checkout</title></head>
<?php 
require('top.php');
//this was written fro a previous version where a user can click on the checkout button even though there were no products in the cart

//prx($_SESSION);

if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
	?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
}

$cart_total=0;

if(isset($_POST['submit'])){
	$phone_no=$_SESSION['USER_MOBILE_U'];
	$address=get_safe_value($con,$_POST['address']);
	$city=get_safe_value($con,$_POST['city']);
	$pincode=get_safe_value($con,$_POST['pincode']);
	$payment_type=get_safe_value($con,$_POST['payment_type']);
	$user_id=$_SESSION['USER_ID'];
	$user_name=$_SESSION['USER_NAME'];
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'','',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		$cart_total=$cart_total+($price*$qty);
		
	}
	$total_price=$cart_total;
	$payment_status='pending';
	
	/* //_causes_error(remember for future dev. of online payment version)
	if($payment_type=='COD'){
		$payment_status='success';
	} */
	
	//setting order and delivery status to 1
	$order_status='1';
	$delivery_status='1';
	$added_on=date('Y-m-d h:i:s');
	
	//transaction id
	$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		
	
	mysqli_query($con,"insert into `order`(user_id,user_name,phone_no,address,city,pincode,payment_type,payment_status,order_status,delivery_status,added_on,total_price,txnid) values('$user_id','$user_name','$phone_no','$address','$city','$pincode','$payment_type','$payment_status','$order_status','$delivery_status','$added_on','$total_price','$txnid')");
	
	//this will get id of `order` table 
	$order_id=mysqli_insert_id($con);
	
	//the below loop inserts every product that as been ordered(this can be used for stats...dashboard..graph..remember..)//
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'','',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		//insert into a database called order_detail
		mysqli_query($con,"insert into `order_detail`(order_id,product_id,qty,price,added_on,status) values('$order_id','$key','$qty','$price','$added_on','pending')");
	}
	
	unset($_SESSION['cart']);
	
	?>
		<script>
			window.location.href='thank_you.php';
		</script>
	<?php
	
	
	/*
	if($payment_type=='payu'){
		$MERCHANT_KEY = "gtKFFx"; 
		$SALT = "eCwWELxi";
		$hash_string = '';
		//$PAYU_BASE_URL = "https://secure.payu.in";
		$PAYU_BASE_URL = "https://test.payu.in";
		$action = '';
		$posted = array();
		if(!empty($_POST)) {
		  foreach($_POST as $key => $value) {    
			$posted[$key] = $value; 
		  }
		}
		
		$userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$user_id'"));
		
		$formError = 0;
		$posted['txnid']=$txnid;
		$posted['amount']=$total_price;
		$posted['firstname']=$userArr['name'];
		$posted['email']=$userArr['email'];
		$posted['phone']=$userArr['mobile'];
		$posted['productinfo']="productinfo";
		$posted['key']=$MERCHANT_KEY ;
		$hash = '';
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($posted['hash']) && sizeof($posted) > 0) {
		  if(
				  empty($posted['key'])
				  || empty($posted['txnid'])
				  || empty($posted['amount'])
				  || empty($posted['firstname'])
				  || empty($posted['email'])
				  || empty($posted['phone'])
				  || empty($posted['productinfo'])
				 
		  ) {
			$formError = 1;
		  } else {    
			$hashVarsSeq = explode('|', $hashSequence);
			foreach($hashVarsSeq as $hash_var) {
			  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			  $hash_string .= '|';
			}
			$hash_string .= $SALT;
			$hash = strtolower(hash('sha512', $hash_string));
			$action = $PAYU_BASE_URL . '/_payment';
		  }
		} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		}


		$formHtml ='<form method="post" name="payuForm" id="payuForm" action="'.$action.'"><input type="hidden" name="key" value="'.$MERCHANT_KEY.'" /><input type="hidden" name="hash" value="'.$hash.'"/><input type="hidden" name="txnid" value="'.$posted['txnid'].'" /><input name="amount" type="hidden" value="'.$posted['amount'].'" /><input type="hidden" name="firstname" id="firstname" value="'.$posted['firstname'].'" /><input type="hidden" name="email" id="email" value="'.$posted['email'].'" /><input type="hidden" name="phone" value="'.$posted['phone'].'" /><textarea name="productinfo" style="display:none;">'.$posted['productinfo'].'</textarea><input type="hidden" name="surl" value="'.SITE_PATH.'payment_complete.php" /><input type="hidden" name="furl" value="'.SITE_PATH.'payment_fail.php"/><input type="submit" style="display:none;"/></form>';
		echo $formHtml;
		echo '<script>document.getElementById("payuForm").submit();</script>';
	}else{	

		?>
		<script>
			window.location.href='thank_you.php';
		</script>
		<?php
	} */	
	
}	
	

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
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    
									<?php 
									$accordion_class='accordion__title';
									if(!isset($_SESSION['USER_LOGIN'])){
									$accordion_class='accordion__hide';
									?>
									<div class="accordion__title">
                                       <!-- Checkout Method <h2> -->Login  to proceed...
                                    </div>
									<!--
                                    <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                        <form id="login-form" method="post">
                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                                <input type="text" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
																<span class="field_error" id="login_email_error"></span>
                                                            </div>
															
                                                            <div class="single-input">
                                                                <input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
																<span class="field_error" id="login_password_error"></span>
                                                            </div>
															
                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                                <button type="button" class="fv-btn" onclick="user_login()">Login</button>
                                                            </div>
															<div class="form-output login_msg">
																<p class="form-messege field_error"></p>
															</div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                        <form action="#">
                                                            <h5 class="checkout-method__title">Register</h5>
                                                            <div class="single-input">
                                                                <input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
																<span class="field_error" id="name_error"></span>
                                                            </div>
															<div class="single-input">
                                                                <input type="text" name="email" id="email" placeholder="Your Email*" style="width:100%">
																<span class="field_error" id="email_error"></span>
                                                            </div>
															
                                                            <div class="single-input">
                                                                <input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
																<span class="field_error" id="mobile_error"></span>
                                                            </div>
															<div class="single-input">
                                                                <input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
																<span class="field_error" id="password_error"></span>
                                                            </div>
                                                            <div class="dark-btn">
                                                                <button type="button" class="fv-btn" onclick="user_register()">Register</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									-->
									
									<!-- Start Contact Area -->
									<section class="htc__contact__area ptb--100 bg__white">
           
									<div class="row">
										<div class="col-md-6">
											<div class="contact-form-wrap ">
												<div class="col-xs-12">
													<div class="contact-title">
													<h3 style="padding-bottom:30px !important; color:red !important;" ><a href="login.php" >CLick here to register</a> </h3>
														<h2 class="title__line--6">Login </h2>
													</div>
												</div>
												<div class="col-xs-12">
												<form id="login-form" method="post">
													<div class="single-contact-form">
														<div class="contact-box name">
															<input type="text" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
														</div>
														<span class="field_error" id="login_email_error"></span>
													</div>
													<div class="single-contact-form">
														<div class="contact-box name">
															<input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
														</div>
														<span class="field_error" id="login_password_error"></span>
													</div>
									
													<div class="contact-btn">
														<button type="button" class="fv-btn" onclick="user_login()">Login</button>
														<a href="forgot_password.php" class="forgot_password">Forgot Password</a>
													</div>
												</form>
													<div class="form-output login_msg">
														<p class="form-messege field_error"></p>
													</div>
												</div>
											</div> 
										</div>
						<!--
										<div class="col-md-6">
											<div class="contact-form-wrap ">
												<div class="col-xs-12">
													<div class="contact-title">
														<h2 class="title__line--6">Register</h2>
													</div>
												</div>
												<div class="col-xs-12">
													<form id="register-form" method="post">
														<div class="single-contact-form">
															<div class="contact-box name">
																<input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
															</div>
															<span class="field_error" id="name_error"></span>
														</div>
														<div class="single-contact-form">
														<div class="contact-box name">
															<input type="text" name="email" id="email" placeholder="Your Email*" style="width:45%">
											
															<button type="button" class="fv-btn email_sent_otp height_60px" onclick="email_sent_otp()">Send OTP</button>
											
															<input type="text" id="email_otp" placeholder="OTP" style="width:45%" class="email_verify_otp">
											
															<button type="button" class="fv-btn email_verify_otp height_60px" onclick="email_verify_otp()">Verify OTP</button>
											
															<span id="email_otp_result"></span>
														</div>
															<span class="field_error" id="email_error"></span>
														</div>
									
									
									
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:45%">
											
											<button type="button" class="fv-btn mobile_sent_otp height_60px" onclick="mobile_sent_otp()">Send OTP</button>
											
											<input type="text" id="mobile_otp" placeholder="OTP" style="width:45%" class="mobile_verify_otp">
											
											
											<button type="button" class="fv-btn mobile_verify_otp height_60px" onclick="mobile_verify_otp()">Verify OTP</button>
											
											<span id="mobile_otp_result"></span>
											
											
										</div>
										<span class="field_error" id="mobile_error"></span>
									</div>
									
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
										</div>
										<span class="field_error" id="password_error"></span>
									</div>
									
									<div class="contact-btn">
										<button type="button" class="fv-btn" onclick="user_register()"  id="btn_register" disabled>Register</button>
									</div>
								</form>
								<div class="form-output register_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>
						</div> 
                
				</div> -->
		
        </section>
		<input type="hidden" id="is_email_verified"/>
		<input type="hidden" id="is_mobile_verified"/>
		<script>
		function email_sent_otp(){
			jQuery('#email_error').html('');
			var email=jQuery('#email').val();
			if(email==''){
				jQuery('#email_error').html('Please enter email id');
			}else{
				jQuery('.email_sent_otp').html('Please wait..');
				jQuery('.email_sent_otp').attr('disabled',true);
				jQuery.ajax({
					url:'send_otp.php',
					type:'post',
					data:'email='+email+'&type=email',
					success:function(result){
						if(result=='done'){
							jQuery('#email').attr('disabled',true);
							jQuery('.email_verify_otp').show();
							jQuery('.email_sent_otp').hide();
							
						}else if(result=='email_present'){
							jQuery('.email_sent_otp').html('Send OTP');
							jQuery('.email_sent_otp').attr('disabled',false);
							jQuery('#email_error').html('Email id already exists');
						}else{
							jQuery('.email_sent_otp').html('Send OTP');
							jQuery('.email_sent_otp').attr('disabled',false);
							jQuery('#email_error').html('Please try after sometime');
						}
					}
				});
			}
		}
		function email_verify_otp(){
			jQuery('#email_error').html('');
			var email_otp=jQuery('#email_otp').val();
			if(email_otp==''){
				jQuery('#email_error').html('Please enter OTP');
			}else{
				jQuery.ajax({
					url:'check_otp.php',
					type:'post',
					data:'otp='+email_otp+'&type=email',
					success:function(result){
						if(result=='done'){
							jQuery('.email_verify_otp').hide();
							jQuery('#email_otp_result').html('Email id verified');
							jQuery('#is_email_verified').val('1');
							if(jQuery('#is_mobile_verified').val()==1){
								jQuery('#btn_register').attr('disabled',false);
							}
						}else{
							jQuery('#email_error').html('Please enter valid OTP');
						}
					}
					
				});
			}
		}
		
		function mobile_sent_otp(){
			jQuery('#mobile_error').html('');
			var mobile=jQuery('#mobile').val();
			if(mobile==''){
				jQuery('#mobile_error').html('Please enter mobile number');
			}else{
				jQuery('.mobile_sent_otp').html('Please wait..');
				jQuery('.mobile_sent_otp').attr('disabled',true);
				jQuery('.mobile_sent_otp');
				jQuery.ajax({
					url:'send_otp.php',
					type:'post',
					data:'mobile='+mobile+'&type=mobile',
					success:function(result){
						if(result=='done'){
							jQuery('#mobile').attr('disabled',true);
							jQuery('.mobile_verify_otp').show();
							jQuery('.mobile_sent_otp').hide();
						}else if(result=='mobile_present'){
							jQuery('.mobile_sent_otp').html('Send OTP');
							jQuery('.mobile_sent_otp').attr('disabled',false);
							jQuery('#mobile_error').html('Mobile number already exists');
						}else{
							jQuery('.mobile_sent_otp').html('Send OTP');
							jQuery('.mobile_sent_otp').attr('disabled',false);
							jQuery('#mobile_error').html('Please try after sometime');
						}
					}
				});
			}
		}
		function mobile_verify_otp(){
			jQuery('#mobile_error').html('');
			var mobile_otp=jQuery('#mobile_otp').val();
			if(mobile_otp==''){
				jQuery('#mobile_error').html('Please enter OTP');
			}else{
				jQuery.ajax({
					url:'check_otp.php',
					type:'post',
					data:'otp='+mobile_otp+'&type=mobile',
					success:function(result){
						if(result=='done'){
							jQuery('.mobile_verify_otp').hide();
							jQuery('#mobile_otp_result').html('Mobile number verified');
							jQuery('#is_mobile_verified').val('1');
							if(jQuery('#is_email_verified').val()==1){
								jQuery('#btn_register').attr('disabled',false);
							}
						}else{
							jQuery('#mobile_error').html('Please enter valid OTP');
						}
					}
					
				});
			}
		} 
		</script>
									<?php } ?>
									
									<?php 
									if(isset($_SESSION['USER_LOGIN'])){
									
									?>
                                    <div class="<?php //echo $accordion_class?>">
                                       <h3> Address Information</h3>
                                    </div>
									<form method="post">
										<div class="accordion__body">
											<div class="bilinfo">
												
													<div class="row">
														<div class="col-md-12">
															<div class="single-input">
																<input type="text" name="address" placeholder="Address" pattern="[A-Z, ,.,a-z,0-9,/,-]+" title="Special characters not allowed except ,  /  - and ." autocomplete="off"  required>
															</div>
														</div>

														<div class="col-md-12">
															<div class="single-input">
																<input type="text" name="phone_no" placeholder="Phone Number" autocomplete="off" disabled value="<?php echo $_SESSION['USER_MOBILE_U'] ?>" >
															</div>
														</div>


														<div class="col-md-6">
															<div class="single-input">
																<input type="text" name="city" placeholder="City" pattern="[A-Za-z]+" title="letters only" autocomplete="off" required>
															</div>
														</div>
														<div class="col-md-6">
															<div class="single-input">
																<input type="text" name="pincode" placeholder="Pincode" pattern="^\d{6}$" title="6 numeric characters only" required>
															</div>
														</div>
														
													</div>
												
											</div>
										</div>
										<div class="<?php //echo $accordion_class?>">
										<!--	<h3>payment information</h3> -->
										</div>
										<div class="accordion__body">
											<div class="paymentinfo">
												<div class="single-method">
													COD <input type="radio" name="payment_type" value="COD" required checked />
													<!-- &nbsp;&nbsp;PayU <input type="radio" name="payment_type" value="payu" required/> -->
												</div>
												<div class="single-method">
												  
												</div>
											</div>
										</div>
										<br>
										 <input style="color:black; width:100px; height:50px; border: 2px solid green; font-size:18px; font-weight:500; font-family:ui-rounded; border-radius:5px; " type="submit" name="submit" value="Place Order"/>
									</form>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php
								$cart_total=0;
								//prx($_SESSION['cart']);
								//seeing the output of the above function we can consider $key as pid and $val as pqty  
								foreach($_SESSION['cart'] as $key=>$val){
								$productArr=get_product($con,'','',$key);
								//prx($productArr);
								//prv($key);
								//prx($val);
								
								$pname=$productArr[0]['name'];
								$mrp=$productArr[0]['mrp'];
								$price=$productArr[0]['price'];
								$image=$productArr[0]['image'];
								$qty=$val['qty'];
								$cart_total=$cart_total+($price*$qty);
								?>
								<div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>"  />
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname?></a>
                                        <span class="price"><?php echo $price*$qty?></span>
										<?php /*$gt_total=$price*$qty;
											
											if($gt_total==0){
												echo "<h3 style='color:red; font-size:20px;'>Please remove this product from your cart</h3>";
											} */ //the above code was used in a previous version where we could proceed from the cart section even when a product was placed with 0 qty
										
										?>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price"><?php echo $cart_total?></span>
								
                            </div>
							<!--  ?php 
							 if($cart_total<=0)
							 echo "<a style='color:red; font-family:calibri; font-weight:700;'>Please Note That if you place 0 items ..Your Order cannot be placed</a>"; 
							 else
								 echo " ";
							?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        						
<?php require('footer.php'); ?>        