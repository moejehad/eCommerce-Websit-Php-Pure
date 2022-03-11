<?php 

    session_start();

    $pageTitle = 'Yellow Store';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $from = $_GET['from'];
        
    $received = $_SESSION['user'];
        
    $stmt = $con->prepare("SELECT * FROM msg WHERE sender LIKE '%$from%' AND received LIKE '%$received%' 
    or sender LIKE '%$received%' AND received LIKE '%$from%'");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
        
        
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $sender     = $_SESSION['user'];
    $received   = $_GET['from'];
    $title      = "رد على رسالتك ";
    $msg        = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
    $status     = "لم تقرأ بعد " ;
    
    if(empty($msg)){
        
        $formErrors[] = 'هناك خطاً ما , قم بملئ رسالتك';
    }
    
      if(empty($formErros)){
                                    
            $stmt = $con->prepare("INSERT INTO msg 
            (sender, received, title , msg , status , time , date)
            VALUES(:zsender , :zreceived , :ztitle , :zmsg , :zstatus , now() , now() ) ");
                
            $stmt->execute(array(
            
                'zsender'   => $sender,
                'zreceived' => $received,
                'ztitle'    => $title,
                'zmsg'      => $msg,
                'zstatus'   => $status
            
            ));
          
          
            $notiUser       = $sender;
            $notiName       = $received;
            $notiType       = "msg";
            $notiDetails    = "رد على رسالتك ";
            $notiStatus     = "unread";
          
          
            $stmt = $con->prepare("INSERT INTO notifications 
            (notiUser , notiName , notiDetails , notiStatus , notiType,  notiDate , notTime)
            VALUES(:ZnotiUser , :ZnotiName, :ZnotiDetails , :ZnotiStatus , :ZnotiType , now() , now() ) ");

            $stmt->execute(array(

                    'ZnotiUser'      => $notiUser,
                    'ZnotiName'      => $notiName,
                    'ZnotiDetails'   => $notiDetails,
                    'ZnotiType'      => $notiType,
                    'ZnotiStatus'    => $notiStatus            

            ));
          
          
                
            }

}
            $stmt = $con->prepare("UPDATE msg SET status = ? WHERE msgID = ?");
            
            foreach($rows as $row){
            $stmt->execute(array("قرأت", $row['msgID']));
            }
                            

?>

<div class="container msg">    
        
    <div class="col-md-8">
    <?php 
        
    foreach($rows as $row){ 
    
        if($row['sender'] == $from){
            
        $stm = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$from%' ");

        $stm->execute(array($user));

        $img1 = $stm->fetch();
            
    ?>
        <div class="message-content-receive">
            <?php 
            
            echo " <img src='admin/Upload/Images/" . $img1['userImg'] . "' />";
            
            ?>
            <p class="sender"><i class="fa fa-user"></i> <?php echo $row['sender']; ?></p>
            <p class="msg"> <?php echo $row['msg']; ?></p>
            <p class="pull-left time-date"><?php echo $row['date'] . " | " . $row['time']; ?></p>
        </div>
    <?php }else { 
        
        $stm = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$received%' ");

        $stm->execute(array($user));

        $img2 = $stm->fetch();
        
        ?>
         <div class="message-content-send">
                <?php 

                echo " <img src='admin/Upload/Images/" . $img2['userImg'] . "' />";

                ?>
                <p class="sender"><i class="fa fa-user"></i> <?php echo $row['sender']; ?></p>
                <p class="msg"><?php echo $row['msg']; ?></p>
                <p class="status"><i class="fa fa-eye"></i> <?php echo $row['status']; ?></p>
                <p class="pull-left time-date"><?php echo $row['date'] . " | " . $row['time']; ?></p>
            </div>   
            
      <?php  } } ?>
    
        <form class="replyToMsg" action="<?php echo $_SERVER['PHP_SELF'] . "?m=" . $row['msgID'] . "&from=" . $from ?>" method="POST">            
            <textarea rows="5" class="form-control" placeholder="أضف رد ... " required name="msg"></textarea>
            <input class="btn btn-success btn-block" name="submit" type="submit" value="إرسال" />
            
        </form>
        
                
    </div>
    
    <div class="col-md-4">
        <div class="col-md-12 alert alert-info">
        <h2>قوانين عامة : </h2>
        <ul>
        <li>حتى تحافظ على حقوقك، لا تتواصل مع أي شخص خارج الموقع</li>    
        <li>طلب التواصل والدفع خارج منصة مستقل يؤدي لحظر حسابك مباشرة</li>
        <li>لاتقم ببيع أو شراء أي منتج من خلال الرسائل ، البيع و الشراء في صفحة عرض المنتج</li>
        <li>
        احذر من تعرضك للاحتيال ولا تحول أي مبالغ للمستخدم خارج المنصة وقم بإبلاغنا مباشرة عن أي طلبات مريبة    
        </li>
        </ul>
        </div>
    </div>
</div>

    <?php }else {
        
        echo '<div class="container oredrs">';
        echo '<div class="alert alert-danger">لا يوجد لديك رسائل</div>';
        echo '</div>';
    }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>