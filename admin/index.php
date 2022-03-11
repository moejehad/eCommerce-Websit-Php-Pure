<?php 

session_start();

$noNavbar = '';

$pageTitle = 'تسجيل الدخول - التحكم';

if(isset($_SESSION['Admin'])){
    header('Location: dashboard.php');
}

include "init.php"; 


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
    

    $stmt = $con->prepare("SELECT
    UserID,Username,Password 
    FROM 
    users 
    WHERE Username = ? 
    AND 
    Password = ? 
    AND 
    GroupID = 1
    LIMIT 1");
    $stmt->execute(array($username,$hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    
    if($count > 0){
         
        $_SESSION['Admin'] = $username;
        
        $_SESSION['ID'] = $row['UserID'];
        
        header('Location: dashboard.php');
        exit();
        
    }
    
}

?>


<div class="login-page">
<div class="log-pg">
    
    <img class="text-center"src="layout/imgs/Y-Logo.png"/>
    
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4 class="text-center">تسجيل الدخول</h4>
        <input class="form-control" type="text" name="user" placeholder="اسم المستخدم" autocomplete="off"/>
        <input class="form-control" type="password" name="pass" placeholder="كلمة المرور" autocomplete="new-password"/>
        <input class="btn btn-primary btn-block" type="submit" value="تسجيل دخول"/>
    </form>
        
</div>
    
</div>

<script src="<?php echo $js;?>back.js"></script>
<script src="<?php echo $js;?>bootstrap.min.js"></script>
<script src="<?php echo $js;?>bootstrap.js"></script>

</body>
</html>