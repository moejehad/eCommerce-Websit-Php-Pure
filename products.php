<?php 

ob_start();

session_start();

$pageTitle = 'المنتجات';

include "inti.php"; 

echo '<div class="container">'; 

echo '<div class="col-md-12 homepage">'; 

include "items-list.php"; 

echo '</div> '; 

echo '</div> '; 

include $tpl . 'footer.php'; 

ob_end_flush();

?>