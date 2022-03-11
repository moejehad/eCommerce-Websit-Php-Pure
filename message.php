<?php 

ob_start();

session_start();

$to = $_GET['to'];

$pageTitle = 'مراسلة ' . $to ;

if(isset($_SESSION['user'])){

include "inti.php"; 
    
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $sender     = $_GET['from'];
    $received   = $_GET['to'];
    $title      = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $msg        = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
    $status     = "لم تقرأ بعد " ;
    
    
    if(empty($title)){
        
        $formErrors[] = 'يرجى وضع عنوان للرسالة';
    }
    
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
          
          
            $notiUser       = $_GET['from'];
            $notiName       = $_GET['to'];
            $notiType       = "msg";
            $notiDetails    = "عنوان " . $title;
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
          
        
            
            $successMsg = 'تم الإرسال بنجاح';
                    
                
                }

}
    


    
?>


 <div class="cart" dir="rtl">
<div class="container">
 
    <div class="container contact-with-seller">
        
    <h1 class="text-center"><i class="fa fa-envelope"></i><span> <?php echo $pageTitle;  ?> </span></h1>

    <div class="the-errors cart text-center">
        <?php 

            if(!empty($formErrors)){

                foreach($formErrors as $error){

                    echo '<div class="msg">' . $error . '</div>';
                }
            }

            if(isset($successMsg)){

                echo '<div class="msg-success">' . $successMsg . '</div>';
            }


        ?>
    
    </div>
        
        <form class="contact" action="<?php echo $_SERVER['PHP_SELF'] . "?from=" . $_GET['from'] . "&to=" . $_GET['to'] ?>" method="POST">
            <input class="form-control" type="text" name="title" required placeholder="عنوان الرسالة" style="border-radius: 0;padding-right: 15px;" />
            
            <textarea rows="10" class="form-control" placeholder="الرسالة" required name="msg" style="border-radius: 0;padding: 15px 15px;"></textarea>
            <input class="btn btn-success btn-block" name="submit" type="submit" value="إرسال" />
        </form>

        
</div>
    
    
</div>
</div>
<?php
    
    include $tpl . 'footer.php'; 
        
    }else {
    
    header('Location: index.php');
    
    exit();
    
    }
    ob_end_flush();

?>
