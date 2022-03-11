<?php 

session_start();

    $pageTitle = "إضافة رصيد" ;

    if(isset($_SESSION['username'])){
    
    include "init.php"; 
        
    $world = $_GET['userid'];

    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

    $sql = $con->prepare("SELECT * FROM users WHERE UserID LIKE '%$world%' ");
        
    $sql->execute();

    $get = $sql->fetch();

    $count = $sql->rowCount();

    if($count > 0){
        
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
                                                  
            $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
        
            $stmt->execute(array($_SESSION['username']));

            $addBal = $stmt->fetch();

            if($addBal['wallet'] >  $_POST['balance']){
                
                $balance = $get['balance'] + $_POST['balance'];    
            
                if(empty($balance)){

                    $formErros[] = 'الرجاء وضع الرصيد المطلوب';
                }


                $stmt = $con->prepare("UPDATE users SET balance = ? WHERE UserID = ?");

                $stmt->execute(array($balance, $userid));
                
                
                $balance = $addBal['balance'] + $_POST['balance'] * 0.05 ;

                $wallet = $addBal['wallet'] - $_POST['balance'] ;
                
                $stmt = $con->prepare("UPDATE users SET balance = ? , wallet = ? WHERE Username = ?");
            
                $stmt->execute(array($balance, $wallet , $_SESSION['username']));
                
                
                
                $notiUser = $_SESSION['username'];
                $notiName = $get['Username'];
                $notiType = "balance";
                $notiDetails = "إضافة " . $_POST['balance'];
                $notiStatus = "unread";

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
                
                
                echo '<div class="home-stats text-center pull-left">';
                $theMsg = '<div class="alert alert-success">تم إضافة الرصيد</div>';
                redirectHome($theMsg, 'back');
                echo '</div>';
                
                
            }else {
                
                echo '<div class="home-stats text-center pull-left">';
                echo '<div class="alert alert-danger">رصيد محفظتك غير كافي 
                <br/>
                <br/>
                تواصل معنا على الرقم 0597676047 لإضافة رصيد لمحفظتك
                </div>';
                echo '</div>';
            }
            
        
            
                    
            } 
    
?>

<div class="home-stats text-center pull-left">

    <h1 class="text-center"><?php echo $pageTitle ; ?></h1>
    
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>إضافة رصيد</td>
            <td>الرصيد</td>
            <td>اسم المستخدم </td>
            <td>نقطة الدفع</td>
        </tr>
            
            
          <?php 
                echo "<tr>";
                echo '<td>
                <form action="balance.php?userid=' . $world . ' " method="POST">
                
                    <input type="hidden" name="userid" value='. $userid .' />
                    
                    <div class="col-sm-8">
                    <input type="text" name="balance" autocomplete="off" placeholder="الرصيد" required class="form-control"/>
                    </div>
                    
                    <div class="col-sm-2">
                    <input type="submit" value="إضافة" class="btn btn-primary"/>
                    </div>
                    
                </form> 
                
                </td>';
                echo "<td>₪ " . $get['balance'] . "</td>";
                echo "<td>" . $get['Username'] . " ( " . $get['FullName'] . ") </td>";
                echo "<td>" . $_SESSION['username'] . "</td>";
                echo "</tr>";
                
            
            ?>  
             
            
        </table>
        <br>
            <a class="btn btn-primary print" title='print' onclick='window.print()' target='_blank' >طباعة</a>
                <br>
        </div>
<?php 
    }else {
        
    echo '<div class="home-stats text-center pull-left">';
    echo '<div class="alert alert-danger">هذا المشترك غير مسجل بالموقع</div>';
    echo '</div>';
        
    }    
?>
</div>
<?php  
include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>