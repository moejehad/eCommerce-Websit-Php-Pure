<?php 

ob_start();

session_start();

$pageTitle = 'إستعادة كلمة المرور';

include "inti.php"; 

?>

<?php
        
        if(isset($_POST['Email'])){
            
        $email = $_POST['Email'];
        
        $selectquery = $con->prepare("SELECT UserID FROM users WHERE Email='{$email}' ");

        $selectquery->execute();
    
        $get = $selectquery->fetch();
        
        $count = $selectquery->rowCount();
    
        if($count > 0){ 
            
            $newPassword = genratnewstring();
            $newPasswordEncrypted = sha1($newPassword);

            $con->query("UPDATE users SET resetpass = '' , Password='$newPasswordEncrypted' WHERE Email='$email'");
            
            $Msg =  " 
            كلمة مرورك الجديدة هي 
            
            $newPassword
            
            يمكنك تغيرها من إعدادت حسابك 
            
            الرجاء عدم الرد على هذه الرسالة وفي حالة الرد لن يتم رؤية الرد
            مع تحياتنا Yellow Store 
            
            " ;
            

            $to = $_POST['Email'] ;
            $subject = "إستعادة كلمة المرور";
            $from = "no-replay@yelsto.com @YellowStore";
            $headers = 'FROM :' . $from . '\r\n';
            
            
            if(isset($_POST['submit'])){
                
                mail($to , $subject ,  $Msg , $headers);
                
                $successMsg = '<div class="alert alert-success">&#1578;&#1605; &#1575;&#1604;&#1573;&#1585;&#1587;&#1575;&#1604; &#1578;&#1601;&#1602;&#1583; &#1576;&#1585;&#1610;&#1583;&#1603; &#1575;&#1604;&#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;</div>';
                
            }else {
                
                $error = '<div class="alert alert-danger">&#1578;&#1571;&#1603;&#1583; &#1605;&#1606; &#1576;&#1585;&#1610;&#1583;&#1603; &#1575;&#1604;&#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;</div>';
            }
            
        }else {
            
        $error = '<div class="alert alert-danger">&#1593;&#1584;&#1585;&#1575;&#1611; , &#1607;&#1584;&#1575; &#1575;&#1604;&#1576;&#1585;&#1610;&#1583; &#1594;&#1610;&#1585; &#1605;&#1608;&#1580;&#1608;&#1583;</div>';
        }
        }

?>

<div class="container restPass">
    <div class="row">
        <div class="col-md-12" align="center" >
            <h1 class="text-center"><i class="fa fa-unlock-alt"></i><span> إستعادة كلمة المرور</span></h1>
            <div class="the-errors text-center">
            <?php 

           if(isset($successMsg)){  echo  $successMsg . '<br>';}
                
           if(isset($error)){  echo  $error . '<br>';}

            ?>
    
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <input required type="email" name="Email" class="form-control" placeholder="&#1576;&#1585;&#1610;&#1583;&#1603; &#1575;&#1604;&#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;"/>
                <i class="fa fa-at fa-fw"></i>
                <input type="submit" name="submit" class="btn btn-primary" value="&#1573;&#1587;&#1578;&#1593;&#1575;&#1583;&#1577; &#1603;&#1604;&#1605;&#1577; &#1575;&#1604;&#1605;&#1585;&#1608;&#1585;"/>
            </form>
        </div>
    </div>
</div>


<?php 
    
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>