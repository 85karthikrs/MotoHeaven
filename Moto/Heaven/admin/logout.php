<?php
require('connection.inc.php');
require('functions.inc.php');

/*
$added_on=date('Y-m-d h:i:s');



mysqli_query($con,"insert into log_out(id,admin_name,time) values('1','admin','$added_on')"); */
unset($_SESSION['work_group']);
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
header('location:index.php');
die();
?>