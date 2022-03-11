<?php 

ob_start();

session_start();

$pageTitle = 'الصفحة المطلوبة غير موجودة' ;

include "inti.php"; 
    
    
?>

<div class="container error">
    <div class="col-md-12 alert alert-danger">
        <i class="fa fa-exclamation-circle"></i>
    <p style="margin: 20px 0;"> الصفحة المطلوبة غير موجودة أو الرابط الذي اتبعته غير صحيح</p>
    <a href="index.php"><span class="btn btn-danger">الرجوع للرئيسية</span></a>
    </div>
</div>


<?php

include $tpl . 'footer.php'; 
ob_end_flush();

?>
