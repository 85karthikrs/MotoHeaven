<?php
session_start();

date_default_timezone_set("Asia/kolkata");
$con=mysqli_connect("localhost","root","root","ecom13");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/Moto/Heaven/');
define('SITE_PATH','http://127.0.0.1/Moto/Heaven/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');

define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH',SERVER_PATH.'media/product_images/');
define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH',SITE_PATH.'media/product_images/');
?>