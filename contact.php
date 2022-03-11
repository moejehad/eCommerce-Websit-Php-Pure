<?php 

ob_start();

session_start();

$pageTitle = 'تواصل معنا' ;

include "inti.php"; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $username   = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile     = filter_var($_POST['mobile'], FILTER_SANITIZE_NUMBER_INT);
    $type       = filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);
    $msg        = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    

    if(strlen($username) <= 3){
        
        $formErrors[] = 'يجب أن يكون إسم المستخدم أكثر من 3 حروف';
    }
    
    if(strlen($msg) < 10){
        
        $formErrors[] = 'يجب أن تكون الرسالة أكثر من 10 حروف';
    }
    
    if(empty($email)){
        
        $formErrors[] = 'يجب وضع البريد الإلكتروني';
    }
    
    if(empty($mobile)){
        
        $formErrors[] = 'يجب وضع رقم الهاتف';
    }
    
      if(empty($formErros)){
                                    
            $stmt = $con->prepare("INSERT INTO contact 
            (name, email, mobile, type , message, date)
            VALUES(:zname, :zmail , :zmobile , :ztype , :zmessage,  now()) ");
                
            $stmt->execute(array(
            
                'zname'    => $username,
                'zmail'    => $email,
                'zmobile'  => $mobile,
                'ztype'    => $type,
                'zmessage' => $msg
            
            
            ));
                
            
            $successMsg = 'تم الإرسال بنجاح';
                    
                
                }

}
    


    
?>

    
<section class="contact">
    
    <div class="informations col-md-12">
        <div class="container">
        <div class="image col-md-6">
            <img src="layout/imgs/Untitled-10.png" />
        </div>
        
        <div class="det col-md-6">
            <h3 class="text-right"><span> تواصل معنا </span></h3>
            <p class="text-right">
            Yellow Store  نقدم لك الجديد والدعم لكل ما تحتاج تابعنا على مواقع التواصل الإجتماعي على الصفحات الخاصة بنا أو راسلنا عن طريق البريد أو الهاتف ونحن سعداء بتواصلكم
            </p>
            <h5><i class="fa fa-envelope"></i> البريد الإلكتروني :  yelsto@gmail.com</h5>
            <h5><i class="fa fa-phone"></i> رقم الموبايل جوال : 0597676047</h5>
            <h5><i class="fa fa-phone"></i> رقم الموبايل وطنية : 0567676047</h5>
            <?php 

                    if(!empty($formErrors)){

                        foreach($formErrors as $error){

                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                    }

                    if(isset($successMsg)){

                        echo '<div class="alert alert-success">' . $successMsg . '</div>';
                    }


                ?>
        </div>
            
    </div>
    </div>
    

    
    <div class="container">
       <form class="cont col-md-12" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            
           <div class="sec-one col-md-6">
            <label>الإسم كامل</label>
            <input class="form-control" type="text" name="name" required  value="<?php if(isset($username)) { echo $username; } ?>"  />
           
            <label>البريد الإلكتروني</label>
            <input class="form-control" type="email" name="email" required value="<?php if(isset($email)) { echo $email; } ?>"  />
           </div>
           
           <div class="sec-two col-md-6">
            <label>رقم الهاتف</label>
            <input class="form-control" type="text" name="mobile" required value="<?php if(isset($mobile)) { echo $mobile; } ?>"  />
               
            <label>نوع المراسلة</label>
            <select class="form-control" name="type" required>
                <option value="1">استفسار عام</option>
                <option value="2">تبليغ عن مشكلة</option>
                <option value="3">اقتراح</option>
            </select>
           </div>
           
            <div class="sec-three col-md-12">
            <label>رسالتك</label>
            <textarea rows="10" class="form-control" required name="message" value="<?php if(isset($msg)) { echo $msg; } ?>"></textarea>
            <input class="btn btn-success" name="submit" type="submit" value="إرسال" />
            </div>
           
            
        </form>

        
</div>
    
    
</section>
<?php
include $tpl . 'footer.php'; 
ob_end_flush();

?>
