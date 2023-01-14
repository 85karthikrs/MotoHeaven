<?php
//database,session and media 
require('connection.inc.php');

//functions
require('functions.inc.php');

//cart
require('add_to_cart.inc.php');

$wishlist_count=0;

//to retrive categories
$cat_res=mysqli_query($con,"select * from categories where status=1 order by categories asc");

//this array will be holding the list of categories
$cat_arr=array();

while($row=mysqli_fetch_assoc($cat_res)){
	//now the array has the list of categories(this will decrease the load of retrieving the same values again and again)
	$cat_arr[]=$row;	
}

//this is the part where we get the number of items in the cart
$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	//the below code is to delete the selected item in the wishlist
	if(isset($_GET['wishlist_id'])){
		$wid=get_safe_value($con,$_GET['wishlist_id']);
		mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
	}

	$wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

//meat fields
$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];

$meta_title="MotoHeaven";
$meta_desc="MotoHeaven";
$meta_keyword="MotoHeaven";
if($mypage=='product.php'){
	$product_id=get_safe_value($con,$_GET['id']);
	$product_meta=mysqli_fetch_assoc(mysqli_query($con,"select * from product where id='$product_id'"));
	$meta_title=$product_meta['meta_title'];
	$meta_desc=$product_meta['meta_desc'];
	$meta_keyword=$product_meta['meta_keyword'];
}if($mypage=='contact.php'){
	$meta_title='Contact Us';
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title?></title>
    <meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon/hell.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" href="font-awesome.css">
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
	<style>
	.checked {
		color: orange;
	}
	
	@media (min-width: 350px) and (max-width: 640px){
		.single-service {
		width: 50% !important;
	}
	
	.service-icon {
		width: 40% !important;
	}	
	
	
	}
	.single-service {
		border-right: 1px solid #dddddd;
		float: left;
		padding: 50px 0 60px 25px;
		width: 25%;
		
	}
	
	
	.client-area {
		padding-bottom: 20px;
	}
	
	
	
	.section-title h2 {
		color: black;
		font-family: "Futura Futuris";
		font-size: 48px;
		font-weight: bold;
		margin-bottom: 5px;
		margin-top: 59px;
		text-align: center;
		text-transform: uppercase;
	}

	.popular-area .section-title h2 {
		margin-bottom: 16px;	
	}
	
	.client-owl{
		display: inline !important;
	}

	.client-owl .col-md-2{
		width: 20% !important;
	}
	
	.service-icon {
    border-radius: 50%;
    display: table;
    float: left;
    height: 40px;
    
    text-align: center;
    vertical-align: middle;
    
	
	}
	single-service-icon{
		width:30%;
	}
	
	
	.htc__shopping__cart a span.htc__wishlist {
		background: #032cfc;
		border-radius: 100%;
		color: #fff;
		font-size: 9px;
		height: 17px;
		line-height: 19px;
		position: absolute;
		right: 18px;
		text-align: center;
		top: -4px;
		width: 17px;
		margin-right:15px;
	}
	</style>
</head>
<body>

    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
	
    <div class="wrapper">
        <header id="htc__header" class="htc__header__area header--one">
            <div id="sticky-header-with-topbar" style="display:flex !important;" class="mainmenu__wrap sticky__header">
                <div class="container" >
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php"><img style="height:60px;" src="images/logo/2logoMOTO.png" alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
                                
								
                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
											<?php if(isset($_SESSION['USER_LOGIN'])){?>
											
											<li class="drop"><a href="">Hi <?php echo $_SESSION['USER_NAME'];?></a>
											 <ul class="dropdown">
												<li><a href="my_order.php">My Orders</a></li>
												<li><a href="profile.php">Profile</a></li>
												<li><a href="contact.php"> Send Feedback</a></li>
												<li><a href="logout.php">logout</a></li>
											 </ul>
											</li>
                                            
											
											<?php }else{ echo "<li><a href='login.php'>login/register</a></li>"; } ?>
											<?php
											foreach($cat_arr as $list){
												?>
												<li class="drop"><a href="categories.php?id=<?php echo $list['id']?>"><?php echo $list['categories']?></a>
											<?php
											$cat_id=$list['id'];
											$sub_cat_res=mysqli_query($con,"select * from sub_categories where status='1' and categories_id='$cat_id'");
											if(mysqli_num_rows($sub_cat_res)>0){
											?>
											
											   <ul class="dropdown">
													<?php
													while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
														echo '<li><a href="categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'">'.$sub_cat_rows['sub_categories'].'</a></li>
													';
													}
													?>
												</ul>
												<?php } ?>
											</li>
												<?php
											}
											?>
                                            <li><a href="contact.php">contact</a></li>
                                        </ul>
                                    </nav>
                                 
								</div> 
                            </div>
                            <div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
                                <div class="header__right">
									<?php 
									$class="mr15";
									if(isset($_SESSION['USER_LOGIN'])){
										$class="";
									}
									?>
									<div class="header__search search search__open <?php echo $class?>">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
									
                                    <div class="header__account">
										<?php if(isset($_SESSION['USER_LOGIN'])){
											?>
											<nav class="navbar navbar-expand-lg navbar-light bg-light">
											   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											  </button>

											  <div class="collapse navbar-collapse" id="navbarSupportedContent">
												<ul class="navbar-nav mr-auto">
												  <li class="nav-item dropdown">
													<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													  Hi <?php echo $_SESSION['USER_NAME']?>
													</a>
													<div class="dropdown-menu" aria-labelledby="navbarDropdown">
													  <a class="dropdown-item" href="my_order.php">Order</a>
													  <a class="dropdown-item" href="profile.php">Profile</a>
													  <a class="dropdown-item" href="contact.php">Feedback</a>
													  <div class="dropdown-divider"></div>
													  <a class="dropdown-item" href="logout.php">Logout</a>
													</div>
												  </li>
												  
												</ul>
											  </div>
											</nav>
											<?php
										}else{
											echo '<a href="login.php" class="mr15">Login/Register</a>';
										}
										?>
									
                                        
										
                                    </div>
                                    <div class="htc__shopping__cart">
										<?php
										if(isset($_SESSION['USER_ID'])){
										?>
										<a href="wishlist.php" class="mr15"><i class="icon-heart icons"></i></a>
                                        <a href="wishlist.php"><span class="htc__wishlist"><?php echo $wishlist_count?></span></a>
										<?php } ?>
                                        <a href="cart.php"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php"><span class="htc__qua"><?php echo $totalProduct?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
        </header>
		<div class="container">
			<div class="row">
				<nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <!-- <li class="drop"><a href="index.php">Home</a></li> -->
                                        <?php
										//this will create a list of categories
										foreach($cat_arr as $list){
											?>
											<li  class="drop"><a href="categories.php?id=<?php echo $list['id']?>"><?php echo "|&nbsp;".$list['categories']."&nbsp;|";?></a>
											<?php
											///retrieving subcats
											$cat_id=$list['id'];
											$sub_cat_res=mysqli_query($con,"select * from sub_categories where status='1' and categories_id='$cat_id'");
											if(mysqli_num_rows($sub_cat_res)>0){
											?>
											
											   <ul class="dropdown">
													<?php
													while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
														echo '<li><a href="categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'">'.$sub_cat_rows['sub_categories'].'</a></li>
													';
													}
													?>
												</ul>
												<?php } ?>
											</li>
											<?php
										}
										?>
                                         <li><a href="contact.php">|&nbsp contact &nbsp|</a></li> 
                                    </ul>
                                </nav>
			</div>
		</div>
		
		<div class="body__overlay"></div>
		<div class="offset__wrapper">
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form action="search.php" method="get">
                                    <input placeholder="Search here... " type="text" name="str">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		