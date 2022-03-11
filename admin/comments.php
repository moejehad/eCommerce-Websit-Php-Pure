<?php 

session_start();

    $pageTitle = 'التعليقات';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
                
     $stmt = $con->prepare("SELECT 
                                    comments.*, items.Name AS Item_Name, users.Username AS Member 
                            FROM 
                                    comments
                            INNER JOIN 
                                    items
                            ON
                                    items.item_ID = comments.item_id
                            INNER JOIN 
                                    users
                            ON
                                    users.UserID = comments.user_id
                            ORDER BY c_id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"> إدارة التعليقات</h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            
        <tr>
            <td>التحكم</td>
            <td>تاريخ التعليق</td>
            <td>إسم المستخدم</td>
            <td>إسم المنتج</td>
            <td>التعليق </td>
             <td>الرقم</td>
             
             
             
             
             
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>
                
                     <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit' style='position:  relative;right:  5px;'></i>Edit</a>
                     
                    <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger'><i class='fa fa-close' style='position:  relative;right:  5px;'></i>Delete</a>";
                
                if($row['status'] == 0){
                    
                    echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info approve' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>Approve</a>";
                }
                
                echo "</td>" ;
                echo "<td>" . $row['comment_date'] . "</td>";
                echo "<td>" . $row['Member'] . "</td>";
                echo "<td>" . $row['Item_Name'] . "</td>";
                echo "<td>" . $row['comment'] . "</td>";
                echo "<td>" . $row['c_id'] . "</td>";
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>        
</div>
        




    <?php }elseif($do == 'Edit'){ 
        
    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
        
    $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
        
    $stmt->execute(array($comid));
        
    $row = $stmt->fetch();
        
    $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ ?>


     <h1 class="text-center">تعديل التعليق</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
    <div class="form-group">
        <label class="col-sm-2 control-label">التعليق</label>
        <div class="col-sm-10">
        <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
        </div>
        </div>
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="حفظ" class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>
        
    <?php 
                                 
    }else {
            
            echo "<div class='container'>";
            
            
            $theMsg = '<div class="alert alert-danger">هذا التعليق غير موجو</div>';
            
            redirectHome($theMsg);
            
            
            echo "</div>";
        }
    
        
        
    }elseif($do == 'Delete'){
        
         echo '<h1 class="text-center">حذف التعليق</h1>';
        
        echo "<div class='container'>";
                
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
        $check = checkItem('c_id', 'comments', $comid);
        
            if($check > 0){ 
            
            $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");
        
            $stmt->bindParam(":zid", $comid);
        
            $stmt->execute();
            
           $theMsg = '<div class="alert alert-success"> تم حذف التعليق</div>';
            
             redirectHome($theMsg, 'back');


        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا التعليق غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
        
    }elseif($do == 'Approve'){
        
        
        echo '<h1 class="text-center">تقعيل التعليق</h1>';
        
        echo "<div class='container'>";
                
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']):0;
        
        $check = checkItem('c_id', 'comments', $comid);
        
        if($check > 0){ 
            
            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

            $stmt->execute(array($comid));
            
           $theMsg = '<div class="alert alert-success"> تم تفعيل التعليق</div>';
            
             redirectHome($theMsg, 'back');

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا التعليق غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
        
    } elseif($do = 'Update'){ 
        
        
       echo '<h1 class="text-center">تحديث التعليق</h1>';
        
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $comid   = $_POST['comid'];
            $comment = $_POST['comment'];     
            
                            
           $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
            
           $stmt->execute(array($comment, $comid));
            
           $theMsg = '<div class="alert alert-success">  تم تحديث التعليق</div>';
                
                redirectHome($theMsg, 'back');
                
            
        }else{
            
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
            redirectHome($theMsg);
        }
            
            echo "</div>";
        
    }
    
    include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>