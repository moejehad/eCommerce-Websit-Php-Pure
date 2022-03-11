<?php 

ob_start();

session_start();

if(isset($_SESSION['username'])){
    
    $pageTitle = 'الرئيسية';
    
    include "init.php"; 

    $stmt = $con->prepare("SELECT * FROM users ORDER BY UserID DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>
    
<div class="home-stats text-center pull-left">
    <br><br><br><br><br>
    <div class="container">
        
        <h1 class="text-center">البحث عن مستخدم</h1>
                <div class="search-form">
                <form action="search.php" method="GET">

                <input type="text" name="search" placeholder="إسم المستخدم" autocomplete="off" />
                <i class="fa fa-search"></i>
                    
                </form>

            </div>
    
        </div>

</div>

    <?php
    
    include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

ob_end_flush();

?>