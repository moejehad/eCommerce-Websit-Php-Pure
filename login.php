<?php 

ob_start();

session_start();

$pageTitle = 'تسجيل الدخول';

if(isset($_SESSION['user'])){
    header('Location: index.php');
}
?> 

<div class="sign-p login">

<?php
include "init.php"; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $hashedPass = sha1($pass);
    
    
    $stmt = $con->prepare("SELECT
    UserID, Username,Password 
    FROM 
    users 
    WHERE Username = ? 
    AND 
    Password = ? ");
    
    $stmt->execute(array($user,$hashedPass));
    
    $get = $stmt->fetch();
        
    $count = $stmt->rowCount();
    
    if($count > 0){
         
        $_SESSION['user'] = $user;
        
        $_SESSION['Uid'] = $get['UserID'];
                        
        header('Location: profile.php?user='. $_SESSION['user'] .' ');
        
        exit();
        
    }else{
        
        $error =  'الرجاء التأكد من إسم المستخدم أو كلمة المرور';
    }
    
    
}

?>

<div class="container login-page" dir="rtl">

<div class="logosign">
    
    <a href="index.php"><img class="text-center" src="layout/imgs/Y-Logo.png" /></a>
    
</div>    
<?php if(isset($error)){ ?>
    <div class="the-errors text-center">
    <?php 
              
    if(isset($error)){
        
        echo '<div class="msg">' . $error . '</div><br>';
    }
        
    ?>
    </div>
<?php } ?>
    
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder=" إسم المستخدم" required />
            <i class="fa fa-user fa-fw"></i>
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="كلمة المرور" required />
            <i class="fa fa-unlock-alt fa-fw"></i>
            <h5><a class="forget" href="resetPassword.php">نسيت <span>كلمة المرور ؟</span></a></h5>
            <input class="btn btn-primary btn-block" type="submit" value="دخول"/>
            
        <a class="login_signup" href="register.php">
             ليس لديك حساب ؟
            <span> سجل بالموقع </span>
         </a>
            
        </form>
    

    
</div>

<?php 
    
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>
</div>