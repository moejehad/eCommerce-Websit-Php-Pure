
<?php 

session_start();

    $pageTitle = 'نقاط الدفع';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
             
    $stmt = $con->prepare("SELECT * FROM users WHERE Trust = 1 ORDER BY UserID DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"> <?php echo $pageTitle; ?> </h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
             <td>إضافة رصيد للمحفظة</td>
            <td>المحفظة</td>
            <td>الرصيد</td>
            <td>الإسم كامل </td>
            <td>البريد الإلكتروني </td>
            <td>إسم المستخدم </td>
           
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo '<td>
                <form action="payCenter.php?do=Update&UserID=' . $row['UserID'] . ' " method="POST">
                                    
                    <div class="col-sm-8">
                    <input type="text" style="margin-left : 5px ;" name="wallet" autocomplete="off" placeholder="الرصيد" required class="form-control"/>
                    </div>
                    
                    <div class="col-sm-2">
                    <input type="submit" value="إضافة" class="btn btn-primary"/>
                    </div>
                    
                </form> 
                
                </td>';
                echo "<td>₪ " . $row['wallet'] . "</td>";
                echo "<td>₪ " . $row['balance'] . "</td>";
                echo "<td>" . $row['FullName'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                              
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
                
</div>

    <?php }elseif($do = 'Update'){ 
        
        
       echo '<h1 class="text-center">إضافة رصيد للمحفظة</h1>';
        
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']):0;
            
            $stmt = $con->prepare("SELECT * FROM users WHERE Trust = 1 AND UserID = ?");
                        
            $stmt->execute(array($userid));

            $rows = $stmt->fetch();
            
            
            $wallet = $rows['wallet'] + $_POST['wallet'];     
             
            $stmt = $con->prepare("UPDATE users SET wallet = ? WHERE UserID = ?");
            
            $stmt->execute(array($wallet, $userid));
            
            $theMsg = '<div class="alert alert-success">تم إضافة الرصيد</div>';
                
            redirectHome($theMsg, 'back');
            
            

            
        }else{
            
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
            redirectHome($theMsg);
        }
            
            echo "</div>";
        
    }
        
    }else {
    
    header('Location: index.php');
    
    exit();
    
    include $tpl . 'footer.php';

}

?>
