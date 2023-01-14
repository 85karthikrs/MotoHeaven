<?php 
require('top.php');
if(isset($_GET['id'])){
	//product id is retrived from the url
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
	if($product_id>0){
		//the below array will hold the detials of the product....get_product() returns the array
		//this is a 2d array
		$get_product=get_product($con,'','',$product_id);
		//prx($get_product);
		//!note:here we are using getproduct[0][] to access array values...since no looping(foreach) is used or required
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
	
	$resMultipleImages=mysqli_query($con,"select * from product_images where product_id ='$product_id'");
	$multipleImages=[];
	if(mysqli_num_rows($resMultipleImages)>0){
		while($rowMultipleImages=mysqli_fetch_assoc($resMultipleImages)){
			$multipleImages[]=$rowMultipleImages['product_images'];
		}
	}
	//pr($multipleImages);
	
	
	//reviews submit section
	if(isset($_POST['submit_review'])){
		//product_id already present
		$user_id=$_SESSION['USER_ID'];
		$user_name=$_SESSION['USER_NAME'];
		$rating=get_safe_value($con,$_POST['rating']);
		$comment=get_safe_value($con,$_POST['comment']);
		$status=1;
		//$added_on=date('Y-m-d h:i:s');
		$added_on='Posted on '.date('Y-m-d').' at '.date('h:i:s');
		$ins="insert into product_review(product_id,user_id,user_name,rating,review,status,added_on) values('$product_id','$user_id','$user_name','$rating','$comment','$status','$added_on')";
		mysqli_query($con,$ins);
		$ins='';
		unset($_POST['submit_review']);
		//echo "<script>window.location.href=product.php?id=$product_id</script>";
		?>
		<script>
		window.location.href=window.location.href;
		</script>
		<?php
		
	}
	
	//review retrival section
	$review_sql="select * from product_review where product_id='$product_id'  and status=1";
	$review_res=mysqli_query($con,$review_sql);
	
	
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>

 <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style=" background: rgba(0, 0, 0, 0) url(images/bg/7.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner" >
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <a class="breadcrumb-item" href="categories.php?id=<?php echo $get_product['0']['categories_id']?>"><?php echo $get_product['0']['categories']?></a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active"><?php echo $get_product['0']['name']?></span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Product Details Area -->
        <section class="htc__product__details bg__white ptb--100">
            <!-- Start Product Details Top -->
            <div class="htc__product__details__top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                            <div class="htc__product__details__tab__content">
                                <!-- Start Product Big Images -->
                                <div class="product__big__images">
                                    <div class="portfolio-full-image tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="img-tab-1">
                                            <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>">
                                        </div>
										<!-- multiple Images  Section-->
										<?php if(isset($multipleImages[0])){
										?>  
										<div role="tab-panel" class="tab=pane fadein active " id="img-tab-1">
											<?php 
												foreach($multipleImages as $list){
													echo "<img style='margin-top:10px; margin-left:10px;' width='20%' src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."' onclick=showMultipleImage('".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."') >";
												}
											?>
										</div>
										<?php } ?>
                                    </div>
                                </div>
                                <!-- End Product Big Images -->
                                
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40">
                            <div class="ht__product__dtl">
                                <h2><?php echo $get_product['0']['name']?></h2>
                                <ul  class="pro__prize">
                                    <li class="old__prize"><strike><?php echo "₹".$get_product['0']['mrp']?></strike></li>
                                    <li><?php echo "₹".$get_product['0']['price']?></li>
                                </ul>
                                <p class="pro__info"><?php echo $get_product['0']['short_desc']?></p>
                                <div class="ht__pro__desc">
                                    <div class="sin__desc">
										<?php
										$productSoldQtyByProductId=productSoldQtyByProductId($con,$get_product['0']['id']);
										
										$pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;
										
										$cart_show='yes';
										if($get_product['0']['qty']>$productSoldQtyByProductId){
											$stock='In Stock';			
										}else{
											$stock='Not in Stock';
											$cart_show='';
										}
										?>
                                        <p><span>Availability:</span> <?php echo $stock?></p>
                                    </div>
									
									<div class="sin__desc">
									<p><span>Available Quantiy:<?php echo $pending_qty ?></span></p> 
									</div>
									
									<div class="sin__desc">
										<?php
										if($cart_show!=''){
										?>
										<p><span>Select Quantity:</span> 
										<select id="qty">
											<?php
											for($i=1;$i<=$pending_qty;$i++){
												echo "<option>$i</option>";
											}
											?>
										</select>
										</p>
										<?php } ?>
                                    </div>
                                    <div class="sin__desc align--left">
                                        <p><span>Categories:</span></p>
                                        <ul class="pro__cat__list">
                                            <li><a href="#"><?php echo $get_product['0']['categories']?></a></li>
                                        </ul>
                                    </div>
                                    
                                    </div>
									
                                </div>
								<?php
								if($cart_show!=''){
								?>
								<a class="fr__btn" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add')">Add to cart</a>
								
								<a class="fr__btn" style="background:#06ba5a !important;" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id']?>','add','yes')">Buy Now</a>
								
								<?php } ?>
								
								<a class="fr__btn" style="background: #4505a6 !important;" href="javascript:void(0)" onclick="wishlist_manage('<?php echo $get_product['0']['id']?>','add')">WISHLIST</a>
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Details Top -->
        </section>
        <!-- End Product Details Area -->
		<!-- Start Product Description -->
        <section class="htc__produc__decription bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">description</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>

               <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <div class="pro__tab__content__inner">
                                    <?php echo $get_product['0']['description']?>
                                </div>
                            </div>
                            <!-- End Single Content -->

                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Description -->
		<!-- Review rating Section  -->
		<div class="container">
		<div class="row">
                    <div class="col-xs-12">
                        <!-- Start List And Grid View -->
                        <ul class="pro__details__tab" role="tablist">
                            <li role="presentation" class="description active"><a href="#description" role="tab" data-toggle="tab">Reviews</a></li>
                        </ul>
                        <!-- End List And Grid View -->
                    </div>
                </div>

               <div class="row">
                    <div class="col-xs-12">
                        <div class="ht__pro__details__content">
                            <!-- Start Single Content -->
                            <div  role="tabpanel" id="description" class="pro__single__content tab-pane fade in active">
                                <?php if(mysqli_num_rows($review_res)>0){
										while($review_rows=mysqli_fetch_assoc($review_res)){
								?>
									<div style="color:black !important;border-bottom:1px solid black !important; padding 10px !important; margin-top: 20px !important;" class=" description active" >
								<?php 
										echo "<br/><h2>".$review_rows['user_name']."</h2>";
										//echo "<p>".$review_rows['rating']."<br/> ";
										if($review_rows['rating']=='5-Star'){
											echo '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
										}else if($review_rows['rating']=='4-Star'){
											echo '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span>';
										}else if($review_rows['rating']=='3-Star'){
											echo '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
										}else if($review_rows['rating']=='2-Star'){
											echo '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star "></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
										}else if($review_rows['rating']=='1-Star'){
											echo '<span class="fa fa-star checked"></span><span class="fa fa-star "></span><span class="fa fa-star "></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
										}
										
										echo "<p style='color:black !important; font-weight:500 !important;'>".$review_rows['review']."<br/>".$review_rows['added_on']."</p>";
								
								?>
									</div>
								<?php    }
									   }else{ echo "<h2> No reviews Yet</h2>";} ?>
                            </div>
                            <!-- End Single Content -->

                            
                        </div>
                    </div>
                </div>
				
				<?php if(isset($_SESSION['USER_LOGIN'])){ ?>
				<div style="margin-bottom:100px !important;">				
				<h3 class="">Enter your review</h3><br/>
					<div class="row" id="post-review-box">
						<div class="col-md-12">
							<form  method="POST">
								<select class="form-control"  name="rating" required>
									<option value="5-Star">5-Star</option>
									<option value="4-Star">4-Star</option>
									<option value="3-Star">3-Star</option>
									<option value="2-Star">2-Star</option>
									<option value="1-Star">1-Star</option>
								</select><br/>
								<textarea class="form-control" cols="50" id="new-review" name="comment" placeholder="Enter your review here.." rows="5"></textarea>
								<div style="margin-top:10px !important;" class="text-right">
									<input type='submit' class="btn btn-success btn-lg" name="submit_review" value="Submit Response"><br/>
								</div>
							</form>
						</div>
				    </div>
				</div>
				<?php }else echo "<h2 style='margin-bottom:100px;'>Login first to post a review</h2>"; ?>
		</div>	
										
<?php require('footer.php')?>        