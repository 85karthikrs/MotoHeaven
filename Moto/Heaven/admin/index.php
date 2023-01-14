<?php require('top.php')?>
<div class="body__overlay"></div>
       <!-- 
         Start Slider Area --> 
		
        <div class="slider__container slider--one bg__cat--3">
            <div class="slide__container slider__activation__wrap owl-carousel">
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Best Selling</h2>
                                        <h1>MT Thunder</h1>
                                        <div class="cr__btn">
                                            <a href="search.php?str=mt">Shop Now</a>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="slides/a2.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide 
                <!-- Start Single Slide -->
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-md-7 col-sm-7 col-xs-12 col-lg-6">
                                <div class="slide">
                                    <div class="slider__inner">
                                        <h2>Introducing</h2>
                                        <h1>Tornado Pro 4</h1>
                                        <div class="cr__btn">
                                            <a href="product.php?id=62">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12 col-md-5">
                                <div class="slide__thumb">
                                    <img src="slides/b1.jpg" alt="slider images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
            </div>
        </div>
		
        <!-- service start -->
        <div class="container">
            <div class="single-service">
                    <h2>Free Shipping</h2>
                    <p>Free for all product</p>
			</div>
            <div class="single-service">
                    <h2>Best Quality Products</h2>
                    <p>ISI Certified</p>
            </div>
            <div class="single-service ">
                    <h2>Safe Shopping</h2>
                    <p>Enjoy safe shopping</p>
            </div>
            <div class="single-service ">
                    <h2>Online Support</h2>
                    <p>24/7 we provide online support</p>
            </div>
        </div>
        <!-- service end -->
		
		
		
		
		
		
        <!-- Start Slider Area -->
        <!-- Start Category Area -->
        <section class="htc__category__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">New Arrivals</h2>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix  mt--30">
							<?php
							//this will hold the list of products
							$get_product=get_product($con,4);
							//prx($get_product);
							//to display the products which are held by the above array
							foreach($get_product as $list){
							?>
                            <!-- Start Single Product-->
                            <div class="col-md-3 col-lg-3 col-sm-4 col-xs-6">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']?>">
                                            <img height="260" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
										<ul class="product__action">
											<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons">WISHLIST</i></a></li>
											<li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons">CART</i></a></li>
										</ul>
									</div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><strike><?php echo $list['mrp']?></strike></li>
                                            <li><?php echo "₹".$list['price']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Product -->
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->
		<div class="container">
		<p style="margin-top:50px !important;"></p>
		<p></p>
		</div>
		<!-- service start -->
        <div class="container" width="100%">
		<h2 style="text-align:center;">Popular Brands</h2>
            <div class="single-service-icon">
                <div class="service-icon">
                    <img src="images/brand/1.jpg" alt="">
                </div>
                
            </div>
            <div class="single-service-icon">
                <div class="service-icon">
                    <img src="images/brand/2.jpg" alt="">
                </div>
                
            </div>
            <div class="single-service-icon">
                <div class="service-icon">
                    <img src="images/brand/3.jpg" alt="">
                </div>
                
            </div>
            <div class="single-service-icon">
                <div class="service-icon">
                    <img src="images/brand/4.jpg" alt="">
                </div>
                
            </div>
			
			<div class="single-service-icon">
                <div class="service-icon">
                    <img src="images/brand/5.jpg" alt="">
                </div>
                
            </div>
			
			
        </div>
		
        <!-- service end -->
		<div class="container">
		<p style="margin-top:50px !important;"></p>
		<p></p>
		</div>
		
		
        <!-- Start Product Area -->
        <section class="ftr__product__area ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Best Seller</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="product__list clearfix mt--30">
							<?php
							$get_product=get_product($con,4,'','','','','yes');
							foreach($get_product as $list){
							?>
                            <!-- Start Single Category -->
                            <div class="col-md-3 col-lg-3 col-sm-4 col-xs-6">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="product.php?id=<?php echo $list['id']?>">
                                            <img height="260" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                        </a>
                                    </div>
                                    <div class="fr__hover__info">
										<ul class="product__action">
											<li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons">WISHLIST</i></a></li>
											<li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons">CART</i></a></li>
										</ul>
									</div>
                                    <div class="fr__product__inner">
                                        <h4><a href="product.php?id=<?php echo $list['id']?>"><?php echo $list['name']?></a></h4>
                                        <ul class="fr__pro__prize">
                                            <li class="old__prize"><strike><?php echo $list['mrp']?></strike></li>
                                            <li><?php echo "₹".$list['price']?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Category -->
							<?php } ?>
                        </div>
                </div>
            </div>
        </section>
        <!-- End Product Area -->
		
        
         <!-- this is the reason why 1 is the quantity of the product added to the cart-->
		<input type="hidden" id="qty" value="1"/>
<?php require('footer.php')?>        