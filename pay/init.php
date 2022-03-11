<?php 

include 'connect.php';

$tpl = 'includes/templeats/';

$css = 'layout/css/';

$js = 'layout/js/';

$func = 'includes/functions/';

include $tpl . 'header.php'; 

include $func . 'functions.php'; 

if(!isset($noNavbar)){include $tpl . 'navbar.php'; }


?>