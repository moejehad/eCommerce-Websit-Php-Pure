<?php 

session_start();

    $pageTitle = 'تفعيل المستخدم';

if(isset($_SESSION['username'])){
    
    include "init.php"; 
    
    
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage'){ 
        
?>
        
       <?php
        
        echo "<div class='home-stats'>";
                
            $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 , subDate = now() WHERE UserID = ?");

            $stmt->execute(array($userid));
            
           $theMsg = '<div class="alert alert-success">تم تفعيل المستخدم</div>';
            
             redirectHome($theMsg);

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
        
    } 
    
    include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>