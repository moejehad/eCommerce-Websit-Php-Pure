 <?php 

session_start();

$pageTitle = 'تعديل بيانات المستخدم';

include "inti.php"; 

if(isset($_SESSION['user'])){ 
    
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();  
    
    if($stmt->rowCount() > 0){ 
    
$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];      
            
            $pass= empty($_POST['newpassword']) ?  $_POST['oldpassword'] :  sha1($_POST['newpassword']);
    
    
            if(strlen($user) < 6 ){
                
                $formErros[] =  '&#1610;&#1580;&#1576; &#1571;&#1606; &#1610;&#1603;&#1608;&#1606; &#1573;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605; &#1571;&#1603;&#1579;&#1585; &#1605;&#1606; 6 &#1581;&#1585;&#1608;&#1601;';
            }
            if(strlen($user) > 20 ){
                
                $formErros[] =  '&#1610;&#1580;&#1576; &#1571;&#1606; &#1610;&#1603;&#1608;&#1606; &#1573;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605; &#1571;&#1602;&#1604; &#1605;&#1606; 20 &#1581;&#1585;&#1608;&#1601;';
            }
            
            
            if(empty($user)){
                
                $formErros[] =  '&#1575;&#1604;&#1585;&#1580;&#1575;&#1569; &#1605;&#1604;&#1574; &#1575;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605;';
            }
            
             if(empty($name)){
                
               $formErros[] = '&#1575;&#1604;&#1585;&#1580;&#1575;&#1569; &#1605;&#1604;&#1574; &#1575;&#1604;&#1575;&#1587;&#1605; &#1575;&#1604;&#1603;&#1575;&#1605;&#1604;';
            }
            
            if(empty($email)){
                
                $formErros[] = '&#1575;&#1604;&#1585;&#1580;&#1575;&#1569; &#1605;&#1604;&#1574; &#1575;&#1604;&#1576;&#1585;&#1610;&#1583; &#1575;&#1604;&#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;';
            }
            


            if(empty($formErros)){                       
                $stmt = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ? ");
                
                 $stmt->execute(array($user, $id));
                
                $count = $stmt->rowCount();
                
                if ($count == 1){
                    
                    $theMsg =  '<div class="alert alert-danger">&#1593;&#1584;&#1585;&#1575; , &#1607;&#1584;&#1575; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605; &#1605;&#1608;&#1580;&#1608;&#1583;</div>';
                                        
                }else {
                    
                      $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
            
                        $stmt->execute(array($user, $email, $name, $pass, $id));
                            
                        $successMsg = ' &#1578;&#1605; &#1578;&#1581;&#1583;&#1610;&#1579; &#1575;&#1604;&#1576;&#1610;&#1575;&#1606;&#1575;&#1578; &#1610;&#1585;&#1580;&#1609; &#1578;&#1581;&#1583;&#1610;&#1579; &#1575;&#1604;&#1589;&#1601;&#1581;&#1577;'; 
                        

                    
                }
            
            
            }else {

                $theMsg = '<div class="alert alert-danger">&#1607;&#1584;&#1575; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605; &#1594;&#1610;&#1585; &#1605;&#1608;&#1580;&#1608;&#1583;</div>';


            }
          
             
                    
                    
            }   

}
?>


    <div class="container profile" dir="rtl">
        
    <br/>
        
    <div class="col-sm-12">
    <div class="panel panel-info edit">
        <div class="panel-heading"><i class="fa fa-cog"></i> <?php echo $pageTitle; ?></div>
      <div class="the-errors text-center pull-right">
            <?php 

                if(isset($successMsg)){

                    echo '<div class="msg-success">' . $successMsg . '</div><br>';
                }

            ?>
    
    </div>
        <div class="panel-body">
            <div class="row">
            <div class="col-md-12">
                
    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
    <div class="form-group">
        <label class="col-sm-2 control-label">&#1575;&#1587;&#1605; &#1575;&#1604;&#1605;&#1587;&#1578;&#1582;&#1583;&#1605;</label>
        <div class="col-sm-10">
        <input type="text" name="username" autocomplete="off" readonly value="<?php echo $row['Username'] ?>" class="form-control"/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">&#1603;&#1604;&#1605;&#1577; &#1575;&#1604;&#1605;&#1585;&#1608;&#1585;</label>
        <div class="col-sm-10">
        <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
        <input type="password" name="newpassword" autocomplete="new-password" class="form-control" placeholder="&#1575;&#1578;&#1585;&#1603; &#1607;&#1584;&#1575; &#1575;&#1604;&#1581;&#1602;&#1604; &#1575;&#1606; &#1603;&#1606;&#1578; &#1604;&#1575; &#1578;&#1585;&#1610;&#1583; &#1578;&#1594;&#1610;&#1610;&#1585;&#1607; "/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">&#1575;&#1604;&#1576;&#1585;&#1610;&#1583; &#1575;&#1604;&#1573;&#1604;&#1603;&#1578;&#1585;&#1608;&#1606;&#1610;</label>
        <div class="col-sm-10">
        <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required"/>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label">&#1575;&#1604;&#1575;&#1587;&#1605; &#1603;&#1575;&#1605;&#1604;</label>
        <div class="col-sm-10">
        <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
        </div>
        </div>
    
        
         <div class="form-group">
        <div class="col-sm-12">
        <input type="submit" value="حفظ التعديلات" class="btn btn-primary"/>
        <a href="profile.php?user=<?php echo $sessionUser ?>" class="btn btn-primary pull-left">الرجوع للصفحة الشخصية</a>
        </div>
        </div>
        
    </form>   
                
                </div>
            </div>
        </div>
             </div>
        </div>
</div>
        
    <?php 
                                 
    }else {
            
            echo "<div class='container'>";
            
            
            $theMsg = '<div class="alert alert-danger">&#1604;&#1575; &#1610;&#1608;&#1580;&#1583; &#1605;&#1587;&#1578;&#1582;&#1583;&#1605; &#1576;&#1607;&#1584;&#1575; &#1575;&#1604;&#1573;&#1587;&#1605;</div>';
            
            redirectHome($theMsg);
            
            
            echo "</div>";
        }
    
    ?>

<?php

include $tpl . 'footer.php'; 

?>