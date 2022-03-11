<?php 

session_start();

$pageTitle = 'تعديل بيانات المستخدم';

include "inti.php"; 

if(isset($_SESSION['user'])){  
    
     echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];      
            
            $pass= empty($_POST['newpassword']) ?  $_POST['oldpassword'] :  sha1($_POST['newpassword']);
            
            $formErros = array();
            
            if(strlen($user) < 6 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أكثر من 6 حروف';
            }
            if(strlen($user) > 20 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أقل من 20 حروف';
            }
            
            
            if(empty($user)){
                
                $formErros[] =  'الرجاء ملئ اسم المستخدم';
            }
            
             if(empty($name)){
                
               $formErros[] = 'الرجاء ملئ الاسم الكامل';
            }
            
            if(empty($email)){
                
                $formErros[] = 'الرجاء ملئ البريد الإلكتروني';
            }
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            if(empty($formErros)){
                
                $stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ? ");
                
                 $stmt->execute(array($user, $id));
                
                $count = $stmt->rowCount();
                
                if ($count == 1){
                    
                    $theMsg =  '<div class="alert alert-danger">عذرا , هذا المستخدم موجود</div>';
                    
                    redirectHome($theMsg, 'back');
                    
                }else {
                    
                      $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
            
                        $stmt->execute(array($user, $email, $name, $pass, $id));
            
                        $theMsg = '<div class="alert alert-success">تم تحديث البيانات</div>';
                
                        redirectHome($theMsg, 'back');
                    
                }
                
            }
            

            
        }else{
            
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
            redirectHome($theMsg);
        }
            
            echo "</div>";

?>

<?php } ?>

<? include $tpl . 'footer.php'; 

?>
