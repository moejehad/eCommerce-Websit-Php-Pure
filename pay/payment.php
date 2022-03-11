<?php 

session_start();

    $pageTitle = 'الفواتير';

if(isset($_SESSION['username'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    

    if($do == 'Manage'){ 
        
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;
        
$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
        
$stmt->execute(array($userid));

$count = $stmt->rowCount();

if($count > 0){
         
$item = $stmt->fetch();
    
?>
<div class="home-stats">
      <h1 class="text-center">دفع فاتورة جديدة</h1>

    <div class="container plan">
    <form class="form-horizontal" action="?do=Insert" method="POST">
        
    <div class="form-group">
        <label class="col-sm-2 control-label">نقطة الدفع</label>
        <div class="col-sm-10">
        <input type="text" name="name" class="form-control" value="<?php echo  $_SESSION['username'] ?>" required="required" readonly />
        </div>
        </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">المستخدم</label>
        <div class="col-sm-10">
        <input required class="form-control" name="member" value="<?php echo $item['Username'] ?>" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;" readonly>
        </div>
        </div>
        
        
    <div class="form-group">
        <label class="col-sm-2 control-label">المبلغ </label>
        <div class="col-sm-10">
        <input type="text" name="price" class="form-control" required="required"/>
        </div>
        </div>
          
        
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="إرسال" class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>
  </div>      

        
                          
    <?php
}
                          
    }elseif($do == 'Insert'){
          
        
         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            echo "<div class='home-stats'>";
            
            $name   = $_POST['name'];
            $member = $_POST['member'];
            $price  = $_POST['price'];
                        
            $formErros = array();
            
            
            if(empty($price)){
                
                $formErros[] =  'يجب كتابة سعر الفاتورة';
            }
            
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            

            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
        
            $stmt->execute(array($_SESSION['username']));

            $addBal = $stmt->fetch();
    
            if(empty($formErros)){
                
                if($addBal['wallet'] >  $_POST['price']){ 
                                
                    $stmt = $con->prepare("INSERT INTO payment 
                    (name, 	member, price, date)
                    VALUES(:zname, :zmember, :zprice , now()) ");

                    $stmt->execute(array(

                        'zname'     => $name,
                        'zmember'   => $member,
                        'zprice'    => $price            
                    ));


                    $theMsg =  '<div class="alert alert-success">تم إضافة الفاتورة </div>';
                    
                    $balance = $addBal['balance'] + $_POST['price'] * 0.05 ; 
            
                    $wallet = $addBal['wallet'] - $_POST['price'] ;

                    $stmt = $con->prepare("UPDATE users SET balance = ? , wallet = ? WHERE Username = ?");

                    $stmt->execute(array($balance, $wallet , $_SESSION['username']));
                    
                    
            

            
                
                
            ?>

    <div class="image text-center">
    <img width="200px" src="layout/imgs/Y-Logo.png" />
    </div>
     <table class="main-table paid manage-members text-center table table-bordered">
            
        
        <tr>
            <td>انتهاء الاشتراك </td>
            <td>المبلغ </td>
            <td>المستخدم</td>
            <td>نقطة الدفع</td>
        </tr>
            
          <?php 
                
                echo "<tr>";
                echo "<td>" . 
                $today  = date('Y-m-d');
                $addDay = date('Y-m-d' , strtotime($today.'+30 days'))   
                . "</td>";
                echo "<td>" . $price . "</td>";
                echo "<td>" . $member . "</td>";
                echo "<td>" . $name . "</td>";
                echo "</tr>";
            
            ?>  
                        
        </table>    
            <br>
            <a class="btn btn-primary print" title='print' onclick='window.print()' target='_blank' >طباعة</a>
                <br>
          <?php 
              }else {
                
                echo '<div class="alert alert-danger">رصيد محفظتك غير كافي 
                <br/>
                <br/>
                تواصل معنا على الرقم 0597676047 لإضافة رصيد لمحفظتك
                </div>';
            }
            }  

            
        }else{
            
            echo "<div class='home-stats'>";
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة</div> ';
            
            redirectHome($theMsg);
            echo "</div>";
        }
            
            echo "</div>";
        
        
    }
    
    include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>