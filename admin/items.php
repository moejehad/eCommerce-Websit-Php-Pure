<?php 

session_start();

    $pageTitle = 'المنتجات';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    

    if($do == 'Manage'){ 
        
                
     $stmt = $con->prepare("SELECT 
                                    items.*,
                                    categories.Name AS category_name,
                                    users.Username 
                            FROM    items

                            INNER JOIN 
                                    categories 
                            ON 
                                    categories.ID = items.Cat_ID

                            INNER JOIN 
                                    users 
                            ON 
                                    users.UserID = items.Member_ID
                             ORDER BY item_ID DESC");
                        
    $stmt->execute();
                        
    $items = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"> إدارة المنتجات</h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
            
        <tr>
            <td>التحكم</td>
            <td>المستخم</td>
            <td>التصنيف</td>
            <td>تاريخ الإضافة</td>
            <td>الوصف </td>
            <td>السعر </td>
            <td>إسم المنتج </td>
             <td>الرقم</td>
             
             
             
             
             
             
             
        </tr>
            
          <?php 
            
            foreach($items as $item){
                
                echo "<tr>";
                echo "<td>
                
                     <a href='items.php?do=Edit&itemid=" . $item['item_ID'] . "' class='btn btn-success'><i class='fa fa-edit' style='position:  relative;right:  5px;'></i>Edit</a>
                     
                    <a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "' class='btn btn-danger'><i class='fa fa-close' style='position:  relative;right:  5px;'></i>Delete</a>";
                
                    
                
                if($item['Approve'] == 0){
                    
                    echo "<a href='items.php?do=Approve&itemid=" . $item['item_ID'] . "' class='btn btn-info approve' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>Approve</a>";
                }
                
                echo "</td>" ;
                echo "<td>" . $item['Username'] . "</td>";
                echo "<td>" . $item['category_name'] . "</td>";
                echo "<td>" . $item['Add_Date'] . "</td>";
                echo "<td>" . $item['Description'] . "</td>";
                echo "<td>" . $item['Price'] . "</td>";
                echo "<td>" . $item['Name'] . "</td>";
                echo "<td>" . $item['item_ID'] . "</td>";

                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
        
      <a href="items.php?do=Add" class="add-new-member btn btn-primary"><i class="fa fa-plus"></i>إضافة منتج جديد</a>
        
</div>
        




    <?php 
       
    
    }elseif($do == 'Add'){ ?>
        
        <h1 class="text-center">إضافة منتج جديد</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST">
        
    <div class="form-group">
        <label class="col-sm-2 control-label">إسم المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="name" class="form-control" required="required"/>
        </div>
        </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">الوصف الخاص بالمنتج </label>
        <div class="col-sm-10">
            <textarea rows="10" type="text" name="description" class="form-control" required="required"></textarea>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">سعر المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="price" class="form-control" required="required"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">سعر التخفيض</label>
        <div class="col-sm-10">
        <input type="text" name="price-minus" class="form-control"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">بلد صنع المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="country" class="form-control"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">حالة المنتج</label>
        <div class="col-sm-10">
        <select class="form-control" name="status" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
        <option value="0">...</option>
        <option value="1">مخفي</option>
        </select>
        </div>
        </div>    

    <div class="form-group">
        <label class="col-sm-2 control-label">العضو صاحب المنتج</label>
        <div class="col-sm-10">
        <select class="form-control" name="member" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
        <option value="0">...</option>
            <?php 
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach ($users as $user){
            
                   echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                }
        
            ?>
        </select>
        </div>
        </div>
        
        
  <div class="form-group">
        <div class="col-sm-12">
        <select class="form-control" name="category" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;" required>
        <option value="0">التصنيف الأساسي</option>
            <?php 
                $cats = getAllfrom('categories','ID');
                foreach ($cats as $cat){
            
                if($cat['parent'] == 0){
                   echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                    
                }
                }
        
            ?>
        </select>
        </div>
        </div>
         
  <div class="form-group">
        <div class="col-sm-12">
        <select class="form-control" name="prnt" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;" required>
        <option value="0">التصنيف الفرعي</option>
            <?php 
                $cats = getAllfrom('categories','ID');
                foreach ($cats as $cat){
            
                if($cat['parent'] == 0){
                    
                    $subcat = getAllfrom("categories", "ID", " WHERE parent = {$cat['ID']} ");
                    foreach($subcat as $scat){
                        
                        echo "<option class='scat' value='" . $scat['ID'] . "'>" . $scat['Name'] . "</option>";
                    }
                    
                }
                }
        
            ?>
        </select>
        </div>
        </div>
        
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="إضافة منتج " class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>

        
                          
    <?php
        
                          
    }elseif($do == 'Insert'){
          
        
         
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            echo '<h1 class="text-center">منتج جديد</h1>';
            echo "<div class='container'>";
            
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $minus = $_POST['price-minus'];
            $country = $_POST['country'];      
            $status = $_POST['status'];     
            $prnt     = filter_var($_POST['prnt'], FILTER_SANITIZE_NUMBER_INT);            
            $member = $_POST['member'];      
            $cat = $_POST['category'];      
                        
            $formErros = array();
            
            if(empty($name)){
                
                $formErros[] =  'يجب كتابة إسم المنتج';
            }
            if(empty($desc)){
                
                $formErros[] =  'يجب كتابة الوصف الخاص بالمنتج';
            }
            
            if(empty($price)){
                
                $formErros[] =  'يجب كتابة سعر المنتج';
            }
            
            if(empty($country)){
                
                $formErros[] =  'يجب كتابة بلد صنع المنتج';
            }
            
             if($status == 0){
                
                $formErros[] =  'يجب اختيار حالة المنتج';
            }
            
             if($member == 0){
                
                $formErros[] =  'يجب اختيار صاحب المنتج';
            }
            
             if($cat == 0){
                
                $formErros[] =  'يجب اختيار قسم المنتج';
            }
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            if(empty($formErros)){
                
            $stmt = $con->prepare("INSERT INTO items 
            (Name, Description, Price, Minus, prnt ,  Country_Made, Status, Cat_ID, Member_ID, Add_Date)
            VALUES(:zname, :zdesc, :zprice, :zminus , :zprnt , :zcontry, :zstatus, :zcat, :zmember, now()) ");
                
            $stmt->execute(array(
            
                'zname'   => $name,
                'zdesc'   => $desc,
                'zprice'  => $price,
                'zminus'  => $minus,
                'zprnt'   => $prnt,
                'zcontry' => $country,
                'zstatus' => $status,
                'zcat'    => $cat,
                'zmember' => $member
            
            ));
                
            
           $theMsg =  '<div class="alert alert-success">تم إضافة المنتج </div>';
                    
                    redirectHome($theMsg, 'back');
                
            }
            

            
        }else{
            
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة</div> ';
            
            redirectHome($theMsg);
            echo "</div>";
        }
            
            echo "</div>";
        
        
    }elseif($do == 'Edit'){ 
        
        
         $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;
        
            $stmt = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
        
            $stmt->execute(array($itemid));
        
            $item = $stmt->fetch();
        
            $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ ?>


 <h1 class="text-center"> تعديل بيانات المنتج</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
    <div class="form-group">
        <label class="col-sm-2 control-label">إسم المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="name" class="form-control" required="required" value="<?php echo $item['Name'] ?>"/>
        </div>
        </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">الوصف الخاص بالمنتج </label>
        <div class="col-sm-10">
        <input type="text" name="description" class="form-control" required="required" value="<?php echo $item['Description'] ?>"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">سعر المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="price" class="form-control" required="required" value="<?php echo $item['Price'] ?>"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">سعر التخفيض</label>
        <div class="col-sm-10">
        <input type="text" name="price-minus" class="form-control" value="<?php echo $item['Minus'] ?>"/>
        </div>
        </div>
        
        
    <div class="form-group">
        <label class="col-sm-2 control-label">بلد صنع المنتج</label>
        <div class="col-sm-10">
        <input type="text" name="country" class="form-control" value="<?php echo $item['Country_Made'] ?>"/>
        </div>
        </div>
        
    <div class="form-group">
        <label class="col-sm-2 control-label">حالة المنتج</label>
        <div class="col-sm-10">
        <select class="form-control" name="status" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
        <option value="0">...</option>
        <option value="1" <?php if($item['Status'] == 1){ echo 'selected'; } ?>>مخفي</option>
        </select>
        </div>
        </div>    

    <div class="form-group">
        <label class="col-sm-2 control-label">العضو صاحب المنتج</label>
        <div class="col-sm-10">
        <select class="form-control" name="member" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
        <option value="0">...</option>
            <?php 
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach ($users as $user){
            
                   echo "<option value='" . $user['UserID'] . "'"; 
                    
                    if($item['Member_ID'] == $user['UserID']){ echo 'selected'; } 
                    echo " > " . $user['Username'] . "</option>";
                }
        
            ?>
        </select>
        </div>
        </div>
        
        
  <div class="form-group">
        <label class="col-sm-2 control-label">قسم المنتج</label>
        <div class="col-sm-10">
        <select class="form-control" name="category" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
        <option value="0">...</option>
            <?php 
                $stmt2 = $con->prepare("SELECT * FROM categories");
                $stmt2->execute();
                $cats = $stmt2->fetchAll();
                foreach ($cats as $cat){
                if($cat['parent'] == 0){
                   echo "<option value='" . $cat['ID'] . "'";
                     if($item['Cat_ID'] == $cat['ID']){ echo 'selected'; } 
                    echo ">" . $cat['Name'] . "</option>";
                }
                }
        
            ?>
        </select>
        </div>
        </div>
        
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="حفظ منتج " class="btn btn-primary"/>
        </div>
        </div>
    </form>   
        
        <?php 
                                   $stmt = $con->prepare("SELECT 
                                    comments.*, users.Username AS Member 
                            FROM 
                                    comments
                            INNER JOIN 
                                    users
                            ON
                                    users.UserID = comments.user_id
                            WHERE   item_id = ?");
                        
        $stmt->execute(array($itemid));

        $rows = $stmt->fetchAll();

        if(! empty($rows)){
        
        ?>

        <h1 class="text-center"> إدارة تعليقات  <?php echo $item['Name'] ?> </h1><br/>
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">

            <tr>
                 <td>Comment </td>
                 <td>User Name </td>
                 <td>Added Date </td>
                 <td>Control</td>
            </tr>

              <?php 

                foreach($rows as $row){

                    echo "<tr>";
                    echo "<td>" . $row['comment'] . "</td>";
                    echo "<td>" . $row['Member'] . "</td>";
                    echo "<td>" . $row['comment_date'] . "</td>";
                    echo "<td>

                         <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit' style='position:  relative;right:  5px;'></i>Edit</a>

                        <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger'><i class='fa fa-close' style='position:  relative;right:  5px;'></i>Delete</a>";

                    if($row['status'] == 0){

                        echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info approve' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>Approve</a>";
                    }

                    echo "</td>" ;
                    echo "</tr>";

                }

                ?>  

            </table>
            </div>                
          <?php } ?>                        
</div>
    
        
    <?php 
                                 
    }else {
            
            echo "<div class='container'>";
            
            
            $theMsg = '<div class="alert alert-danger">هذا المنتج غير موجود</div>';
            
            redirectHome($theMsg);
            
            
            echo "</div>";
        }
        
        
     
    }elseif($do == 'Delete'){
       
        
        echo '<h1 class="text-center">حذف المنتج</h1>';
        
        echo "<div class='container'>";
                
           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;
        
            $check = checkItem('item_ID', 'items', $itemid);
        
            if($check > 0){ 
            
            $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");
        
            $stmt->bindParam(":zid", $itemid);
        
            $stmt->execute();
            
           $theMsg = '<div class="alert alert-success"> تم حذف المنتج</div>';
            
             redirectHome($theMsg, 'back');

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا المنتج غير موجود</div>';
            
            redirectHome($theMsg, 'back');
        
        }
        echo "</div>";
        
        
    }elseif($do == 'Approve'){
        
        
       echo '<h1 class="text-center">الموافقة على المنتج</h1>';
        
        echo "<div class='container'>";
                
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;
        
            $check = checkItem('item_ID', 'items', $itemid);
        
            if($check > 0){ 
            
            $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");

            $stmt->execute(array($itemid));
            
           $theMsg = '<div class="alert alert-success"> تم تقعيل المنتج</div>';
            
             redirectHome($theMsg, 'back');

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا المنتج غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
      
    } elseif($do = 'Update'){ 
        
        
         echo '<h1 class="text-center">تحديث بيانات المنتج</h1>';
        
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id       = $_POST['itemid'];
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];  
            $minus    = $_POST['price-minus'];
            $country  = $_POST['country'];      
            $status   = $_POST['status'];
            $cat      = $_POST['category'];  
            $member   = $_POST['member'];      
                
            
            
           $formErros = array();
            
            if(empty($name)){
                
                $formErros[] =  'يجب كتابة إسم المنتج';
            }
            if(empty($desc)){
                
                $formErros[] =  'يجب كتابة الوصف الخاص بالمنتج';
            }
            
            if(empty($price)){
                
                $formErros[] =  'يجب كتابة سعر المنتج';
            }
            
            if(empty($country)){
                
                $formErros[] =  'يجب كتابة بلد صنع المنتج';
            }
            
            
             if($member == 0){
                
                $formErros[] =  'يجب اختيار صاحب المنتج';
            }
            
             if($cat == 0){
                
                $formErros[] =  'يجب اختيار قسم المنتج';
            }
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            if(empty($formErros)){
                
                $stmt = $con->prepare("UPDATE 
                                    items 
                                SET 
                                    Name = ?,
                                    Description = ?,
                                    Price = ?,
                                    Minus = ?,
                                    Country_Made = ?,
                                    Status = ?,
                                    Cat_ID = ?,
                                    Member_ID = ?
                                WHERE
                                    item_ID = ?");
            
                $stmt->execute(
                    array
                    ($name, $desc, $price, $minus, $country, $status, $cat, $member, $id)
                );
            
                $theMsg = '<div class="alert alert-success"> تم تحديث البيانات</div>';
                
                redirectHome($theMsg, 'back');
                
                
            }
            

            
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