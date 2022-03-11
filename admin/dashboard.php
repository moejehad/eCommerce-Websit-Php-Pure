<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){
    
    $pageTitle = 'لوحة التحكم';
    
    include "init.php"; 

    
   ?> 
    
            <div class="container home-stats text-center">

            

                <div class="row">
                <div class="col-md-4">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                       <div class="info">
                         عدد المستخدمين
                    <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-4">
                    <div class="stat st-pending">
                      <i class="fa fa-user-plus"></i>
                        <div class="info">
                          مستخدمين غير مفعلين
                        <span><a href="members.php?Manage&page=Pending">
                            <?php echo checkItem("RegStatus", "users", 0) ?>
                            </a></span>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="stat st-items">
                   <i class="fa fa-tag"></i>
                        <div class="info">
                          عدد المنتجات
                    <span><a href="items.php"><?php echo countItems('item_ID', 'items') ?></a></span>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                    <div class="stat st-comments">
                    <i class="fa fa-comments"></i>
                        <div class="info">
                                عدد التعليقات
                   <span><a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a></span>
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                    <div class="stat st-orders">
                    <i class="fa fa-cart-plus"></i>
                        <div class="info">
                                طلبات الزبائن 
                   <span><a href="orders.php"><?php echo countItems('cartid', 'cart') ?></a></span>
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                    <div class="stat st-contact">
                    <i class="fa fa-envelope"></i>
                        <div class="info">
                               الرسائل
                   <span><a href="messages.php"><?php echo countItems('id', 'contact') ?></a></span>
                        </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-4">
                    <div class="stat st-pending">
                    <i class="fa fa-map"></i>
                        <div class="info">
                                حسابات البائعين
                   <span><a href="plans.php"><?php echo countSeller('UserID', 'users') ?></a></span>
                        </div>
                        </div>
                    </div>
                    
                <div class="col-md-4">
                    <div class="stat st-items">
                        <i class="fa fa-dollar"></i>
                       <div class="info">
                        نقاط الدفع
                    <span><a href="payCenter.php"><?php echo countCenter('UserID', 'users') ?></a></span>
                        </div>
                    </div>
                    </div>
                    
                    
                <div class="col-md-4">
                    <div class="stat st-members">
                        <i class="fa fa-credit-card"></i>
                       <div class="info">
                        الفواتير
                    <span><a href="payment.php"><?php echo countItems('id', 'payment') ?></a></span>
                        </div>
                    </div>
                    </div>
                    
                    
                </div>
        </div>


    
        <div class="container latest">
            
            <div class="row">
                
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestUsers = 6;?>
                <div class="panel-heading">
                   <i class="fa fa-users"></i> آخر <?php echo $latestUsers ?> أعضاء مسجلين
                    </div>
                <div class="panel-body">
                    <ul class="list-unstyled latest-users">
       <?php 
       
       $theLatest = getLatest("*","users","UserID",$latestUsers);
            
        if(! empty($theLatest)){
        foreach ($theLatest as $user){
       
       echo '<li>';
            echo  $user['Username'] ; 
           echo '<a href="members.php?do=Edit&ID=' . $user['UserID'] . '">';
          echo '<span class="btn btn-success pull-right">';
           echo '<i class="fa fa-edit"></i>تعديل';
             if($user['RegStatus'] == 0){
                    
                    echo "<a href='members.php?do=Activate&ID=" . $user['UserID'] . "' class='btn btn-info activate pull-right' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>تفعيل</a>";
                }
          echo '</a>';
         echo '</span>';
           echo '</li>';
   }
        }else {
                        
                        echo 'لا يوجد مستخدمين لعرضهم ';
                    }
?>
                        </ul>
                </div>
                </div>
                </div>
                
                
                <div class="col-sm-6">
                <div class="panel panel-default">
                <?php $numItems = 6;?>
                <div class="panel-heading">
                <i class="fa fa-tag"></i> آخر <?php echo $numItems ?> المنتجات 
                </div>
                <div class="panel-body">
                <ul class="list-unstyled latest-users">
                <?php 
       
                $latestItems = getLatest("*","items","item_ID",$numItems);
                 
                if(! empty($latestItems)){
                foreach ($latestItems as $item){
       
                  echo '<li>';
                                    
                  echo  $item['Name'] ; 
                  echo '<a href="items.php?do=Edit&itemid=' . $item['item_ID'] . '">';
                  echo '<span class="btn btn-success pull-right">';
                  echo '<i class="fa fa-edit"></i>تعديل';
                  if($item['Approve'] == 0){
                      
                  echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info activate pull-right' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>تفعيل</a>";
                
                  }
                    
          echo '</a>';
         echo '</span>';
           echo '</li>';
   }
                }else {
                        
                        echo 'لا يوجد منتجات لعرضها';
                    }
                    
?>
                        </ul>
                </div>
                </div>
                </div>
                
                
                
                <div class="row"> 
                     <div class="col-sm-12">
                         <div class="panel panel-default">
                             <?php $numComments = 6;?>
                                <div class="panel-heading">
                        <i class="fa fa-comments-o"></i> آخر <?php echo $numComments ?> التعليقات
                    </div>
                    <div class="panel-body">
                    <?php
    
                    $stmt = $con->prepare("SELECT 
                            comments.*, users.Username AS Member 
                     FROM 
                            comments
                     INNER JOIN 
                            users
                     ON
                            users.UserID = comments.user_id
                     ORDER BY c_id DESC
                     LIMIT  $numComments");
                        
                    $stmt->execute();

                    $comments = $stmt->fetchAll();
                    
                    if(! empty($comments)){
                    foreach ($comments as $comment){
                        
                        echo '<div class="comment-box">';
                            
                        echo '<span class="member-n"><a href="members.php?do=Edit&ID=' . $comment['user_id'] . '">'
                            . $comment['Member'] . '</a></span>'; 
                        
                        echo '<p class="comment-c">' . $comment['comment'] . '</p>';  
                        
                        echo '</div>';
                    }
                    }else {
                        
                        echo 'لا توجد تعليقات لعرضها';
                    }
                    ?>
                    </div>
                    </div>
                    </div>
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