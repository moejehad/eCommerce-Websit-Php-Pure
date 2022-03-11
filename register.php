<?php 

ob_start();

session_start();

$pageTitle = 'حساب جديد ';

if(isset($_SESSION['user'])){
    header('Location: index.php');
}

?> 

<div class="sign-p">

<?php 

include "inti.php"; 


$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $userImgName = $_FILES['userImg']['name'];
        $userImgSize = $_FILES['userImg']['size'];
        $userImgTmp = $_FILES['userImg']['tmp_name'];
        $userImgType = $_FILES['userImg']['type'];
            
        $userImgAllowedExtension = array("jpeg", "jpg","png","gif");
    
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $password2  = $_POST['password2'];
        $email      = $_POST['email'];
        $fname      = $_POST['FullName'];
        $account    = $_POST['account'];
    
    
        if(isset($username)){

            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

            if(strlen($filterdUser) < 5){

                $formErrors[] = 'يجب أن يكون إسم المستخدم أكثر من 5 حروف';
            }
        }



        if(isset($password) && isset($password2)){


            if(empty($password)){

                $formErrors[] = 'يجب وضع كلمة المرور';

            }


            if(sha1($password) !== sha1($password2)){

                $formErrors[] = 'كلمة المرور غير متطابقة';

            }

        }



        if(isset($email)){

            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true ) {

                $formErrors[] = 'البريد الإلكتروني غير صحيح';
            }
        }

        if(empty($fname)){

            $formErrors[] = 'الرجاء كتابة الإسم كامل';
        }

        if(empty($account)){

            $formErrors[] = 'الرجاء اختيار نوع الحساب';
        }


        if($userImgSize > 4194304){

             $formErros[] = 'يجب أن يكون حجم الصورة أقل من 4 ميغابايت';
        }


      if(empty($formErros)){
          
               $userImg = rand(0, 1000000000) . '_' . $userImgName;
               
               move_uploaded_file($userImgTmp, './admin/Upload/Images/' . $userImg );
                
           $check = checkItem("Username", "users", $username);
          
                if($check == 1 ){
                    
                    $formErrors[] = 'هذا المستخدم موجود';
                                        
                }else {
                    
                    
            if(sha1($password) == sha1($password2)){                        
            $stmt = $con->prepare("INSERT INTO users 
            (Username, Password, Email,FullName, RegStatus, Date, userImg , account , subDate)
            VALUES(:zuser, :zpass, :zmail, :zfname , 0 , now(), :zuserImg , :zaccount , now()) ");
                
            $stmt->execute(array(
            
                'zuser'    => $username,
                'zpass'    => sha1($password),
                'zmail'    => $email,
                'zfname'   => $fname,
                'zuserImg' => $userImg,
                'zaccount'  => $account
            
            
            ));
                
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

                }
                    
                    
                }
                }   }
    
}





?>

<div class="container login-page register" dir="rtl">
    
    <a href="index.php"><img class="text-center" src="layout/imgs/Y-Logo.png" /></a>
    
<?php if(!empty($formErrors)){ ?>
    <div class="the-errors text-center">
        <?php 
        
    if(!empty($formErrors)){
        
        foreach($formErrors as $error){
            
            echo '<div class="msg">' . $error . '</div><br>';
        }
    }
              
    if(isset($successMsg)){
        
        echo '<div class="msg-success">' . $successMsg . '</div><br>';
    }
        
        ?>
    
    </div>
<?php } ?>
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <input pattern=".{6,}" title="يجب أن يكون إسم المستخدم أكثر من 6 حروف" class="form-control" type="text" name="username" autocomplete="off" placeholder="  إسم المستخدم" required/>
            <i class="fa fa-user fa-fw"></i> 
            
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="كلمة المرور" required/>
            <i class="fa fa-unlock-alt fa-fw"></i>
            
            <input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder=" إعادة كلمة المرور" required/>
            <i class="fa fa-unlock-alt fa-fw"></i>
            
            <input class="form-control" type="email" name="email" placeholder=" البريد الإلكتروني" required/>
            <i class="fa fa-at fa-fw"></i>
            
            <input class="form-control" type="text" name="FullName" placeholder=" الإسم كامل - بالعربية" required/>
            <i class="fa fa-pencil fa-fw"></i>
            
            <span class="form-control user_imgs text-center">صورة المستخدم</span>    
            <input class="form-control" type="file" name="userImg" required />
            
            <select name="account" class="form-control" style="background: #ededed;border: 0;color: #999;" required>
            <option>نوع الحساب</option>
            <option value="buyer">مشتري</option>
            <option value="seller">بائع</option>
            </select>
            
            <label>بتسجيلك بالموقع تعتبر موافق على  <a href="terms.php">شروط الإستخدام</a></label>
            
            <input class="btn btn-success btn-block" type="submit" value="تسجيل ومتابعة"/>
            <br>
            <a class="login_signup" href="login.php"> هل تملك حساب ؟</a>
        </form>
    

</div>

<?php include $tpl . 'footer.php'; ?></div>