<?php 

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionUser = '';

if(isset($_SESSION['user'])){
    
    $sessionUser = $_SESSION['user'];
}

$tpl = 'includes/templeats/';

$css = 'layout/css/';

$js = 'layout/js/';

$func = 'includes/functions/';

include $func . 'functions.php'; 

include $tpl . 'header.php'; 


?>