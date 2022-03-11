<?php 

    session_start();

    $pageTitle = 'الإشعارات';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $user = $_GET['user'];

    $stmt = $con->prepare("SELECT * FROM notifications WHERE notiName LIKE '%$user%' ORDER BY notID DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
                            

    
    $stmt = $con->prepare("UPDATE notifications SET notiStatus = ? WHERE notiName = ?");
    
    foreach($rows as $row){ 
            
    $stmt->execute(array("read", $user));
        
    }
        
?>

<div class="container notif" dir="rtl">    
    
    <?php  
        
        foreach($rows as $row){ 
        
        if($row['notiType'] == "balance"){
            
                echo "<div class='alert alert-success noti'> <i class='fa fa-bell-o'></i> تم " . $row['notiDetails'] . " شيكل لمحفظتك <a class='pull-left btn btn-success' href='statements.php?user=" . $_SESSION['user'] ." '>المحفظة</a></div>
                <h6 class='dateTime'> " . $row['notiDate'] . " | " . $row['notTime'] . "</h6>";
        }
            
        if($row['notiType'] == "buy"){
            
                echo "<div class='alert alert-info noti'> <i class='fa fa-bell-o'></i> قام " . $row['notiUser'] . " بـ" . $row['notiDetails'] . "<a class='pull-left btn btn-info' href='customers.php?user=" . $_SESSION['user'] ." '>المبيعات</a></div>
                <h6 class='dateTime'> " . $row['notiDate'] . " | " . $row['notTime'] . "</h6>";
        }
          
        if($row['notiType'] == "msg"){
            
                echo "<div class='alert alert-danger noti'> <i class='fa fa-bell-o'></i> رسالة من  " . $row['notiUser'] . " بـ" . $row['notiDetails'] . "<a class='pull-left btn btn-danger' href='inbox.php?user=" . $_SESSION['user'] ." '>الرسائل</a></div>
                <h6 class='dateTime'> " . $row['notiDate'] . " | " . $row['notTime'] . "</h6>";
        }
            
            
        if($row['notiType'] == "comment"){
            
                echo "<div class='alert alert-warning noti'> <i class='fa fa-bell-o'></i> قام " . $row['notiUser'] . " بـ" . $row['notiDetails'] . "</div>
                <h6 class='dateTime'> " . $row['notiDate'] . " | " . $row['notTime'] . "</h6>";
        }
            
            
        }
    ?>
    
</div>

    <?php }else {
        
        echo '<div class="container oredrs">';
        echo '<div class="alert alert-danger">ليس لديك إشعارات</div>';
        echo '</div>';
    }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>