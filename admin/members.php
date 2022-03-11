<?php 

session_start();

    $pageTitle = 'المستخدمين';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
        
    $query = '';
        
    if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
        
        $query = 'AND RegStatus = 0';
    }
                
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query  ORDER BY UserID DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"> إدارة المستخدمين</h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>التحكم</td>
            <td>تاريخ التسجيل</td>
            <td>الرصيد</td>
            <td>الإسم كامل </td>
            <td>نوع الحساب </td>
            <td>البريد الإلكتروني </td>
            <td>إسم المستخدم </td>
            <td>صورة المستخدم</td>
             <td>الرقم</td>
             
             
             
             
             
             
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>
                <a href='members.php?do=Edit&ID=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit' style='position:  relative;right:  5px;'></i>Edit</a>
                <a href='members.php?do=Delete&ID=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close' style='position:  relative;right:  5px;'></i>Delete</a>";
                
                if($row['RegStatus'] == 0){
                    
                    echo "<a href='members.php?do=Activate&ID=" . $row['UserID'] . "' class='btn btn-info activate' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>Activate</a>";
                }
                
                echo "</td>" ;
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>₪ " . $row['balance'] . "</td>";
                echo "<td>" . $row['FullName'] . "</td>";
                echo "<td>" ;
                if($row['account'] == "seller"){
                    echo "بائع";
                }else {
                    echo "مشتري";
                } 
                "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>";
                if(empty($row['userImg'])){
                    
                    echo '<img src="Upload/Images/user.png" alt="" />';
                    
                }else{
                    
                    echo " <img src='Upload/Images/" . $row['userImg'] . "' alt='' />";
                    
                }
               
                echo "</td>";
                echo "<td>" . $row['UserID'] . "</td>";

                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
        
      <a href="members.php?do=Add" class="add-new-member btn btn-primary"><i class="fa fa-plus"></i>إضافة مستخدم جديد</a>
        
</div>
        




    <?php }elseif($do == 'Add'){ ?>

        
<h1 class="text-center">إضافة مستخدم جديد</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-sm-2 control-label">اسم المستخدم</label>
        <div class="col-sm-10">
        <input type="text" name="username" autocomplete="off" class="form-control" required="required" placeholder="اسم المستخدم لدخول المتجر"/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">كلمة المرور</label>
        <div class="col-sm-10">
        <input type="password" name="password" autocomplete="new-password" class=" form-control" required="required" placeholder="كلمة المرور يجب أن تكون صعبة ومتنوعة"/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">البريد الإلكتروني</label>
        <div class="col-sm-10">
        <input type="email" name="email" class="form-control" required="required" placeholder="البريد الإلكتروني يجب أن يكون صحيح" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label">الاسم كامل</label>
        <div class="col-sm-10">
        <input type="text" name="full" class="form-control" required="required" placeholder="الاسم الكامل سوف يظهر بصفحتك الشخصية" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label">صورة المستخدم</label>
        <div class="col-sm-10">
        <input type="file" name="userImg" class="form-control" required="required"/>
        </div>
        </div>
        
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="إضافة مستخدم " class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>

    <?php 
                          
    }elseif($do == 'Insert'){
        
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                echo '<h1 class="text-center">مستخدم جديد</h1>';
                echo "<div class='container'>";
            
                        
            $userImgName = $_FILES['userImg']['name'];
            $userImgSize = $_FILES['userImg']['size'];
            $userImgTmp = $_FILES['userImg']['tmp_name'];
            $userImgType = $_FILES['userImg']['type'];
            
            $userImgAllowedExtension = array("jpeg", "jpg","png","gif");
            
            $userImgExtension = strtolower(end(explode('.',$userImgName)));
            
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['full'];      
            
            $hashPass = sha1($_POST['password']);
            
            $formErros = array();
            
            if(strlen($user) < 6 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أكثر من 6 حروف';
            }
            if(strlen($user) > 20 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أقل من 20 حروف';
            }
            
            
            if(empty($user)){
                
                $formErros[] =  'الرجاء ملئ اسم المستخدم';
            }
            
            if(empty($pass)){
                
                $formErros[] =  'الرجاء ملئ كلمة المرور';
            }
            
             if(empty($name)){
                
               $formErros[] = 'الرجاء ملئ الاسم الكامل';
            }
            
            if(empty($email)){
                
                $formErros[] = 'الرجاء ملئ البريد الإلكتروني';
            }
            
            if(!empty($userImgName) && ! in_array($userImgExtension, $userImgAllowedExtension)){
                
                $formErros[] = 'امتداد الصورة غير مسموح به';
            }

            if(empty($userImgName)){
                
                $formErros[] = 'يجب وضع صورة شخصية';
            }
            
            if($userImgSize > 4194304){
                
                $formErros[] = 'يجب أن يكون حجم الصورة أقل من 4 ميغابايت';
            }
            
            
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
           if(empty($formErros)){
                
               $userImg = rand(0, 1000000000) . '_' . $userImgName;
               
               move_uploaded_file($userImgTmp, 'Upload\Images\\' . $userImg );
                       
        
                $check = checkItem("Username", "users", $user);
                if($check == 1 ){
                    
                    $theMsg = '<div class="alert alert-danger">هذا المستخدم موجود</div>';
                    
                     redirectHome($theMsg, 'back');
                    
                }else {
                    
                                    
            $stmt = $con->prepare("INSERT INTO users 
            (Username, Password, Email, FullName, RegStatus, Date, userImg)
            VALUES(:zuser, :zpass, :zmail, :zname, 1 , now(), :zuserImg) ");
                
            $stmt->execute(array(
            
                'zuser'    => $user,
                'zpass'    => $hashPass,
                'zmail'    => $email,
                'zname'    => $name,
                'zuserImg' => $userImg
            
            
            ));
                
            
           $theMsg =  '<div class="alert alert-success">تم إضافة البيانات بنجاح</div>';
                    
                    redirectHome($theMsg, 'back');
                }
            }
            

            
        }else{
            
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة</div> ';
            
            redirectHome($theMsg);
            echo "</div>";
        }
            
            echo "</div>";
        
        
        
        
    }elseif($do == 'Edit'){ 
        
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ ?>


     <h1 class="text-center">تعديل صفحة المستخدم</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
    <div class="form-group">
        <label class="col-sm-2 control-label">اسم المستخدم</label>
        <div class="col-sm-10">
        <input type="text" name="username" autocomplete="off" value="<?php echo $row['Username'] ?>" class="form-control" required="required" />
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">كلمة المرور</label>
        <div class="col-sm-10">
        <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
        <input type="password" name="newpassword" autocomplete="new-password" class="form-control" placeholder="اترك هذا الحقل ان كنت لا تريد تغييره "/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">البريد الإلكتروني</label>
        <div class="col-sm-10">
        <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required"/>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label">الاسم كامل</label>
        <div class="col-sm-10">
        <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required"/>
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
            
            
            $theMsg = '<div class="alert alert-danger">لا يوجد مستخدم بهذا الإسم</div>';
            
            redirectHome($theMsg);
            
            
            echo "</div>";
        }
    
        
        
    }elseif($do == 'Delete'){
        
         echo '<h1 class="text-center">حذف المستخدم</h1>';
        
        echo "<div class='container'>";
                
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
            $stmt->bindParam(":zuser", $userid);
            $stmt->execute();
            
           $theMsg = '<div class="alert alert-success">تم حذف المستخدم</div>';
            
             redirectHome($theMsg, 'back');

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
        
    }elseif($do == 'Activate'){
        
        
              echo '<h1 class="text-center">تفعيل المستخدم</h1>';
        
        echo "<div class='container'>";
                
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

            $stmt->execute(array($userid));
            
           $theMsg = '<div class="alert alert-success">تم تفعيل المستخدم</div>';
            
             redirectHome($theMsg);

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
            
            redirectHome($theMsg);
        
        }
        echo "</div>";
        
        
        
    } elseif($do = 'Update'){ 
        
        
       echo '<h1 class="text-center">تحديث بيانات المستخدم</h1>';
        
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];      
            
            $pass= empty($_POST['newpassword']) ?  $_POST['oldpassword'] :  sha1($_POST['newpassword']);
            
                        $formErros = array();
            
            if(strlen($user) < 6 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أكثر من 6 حروف';
            }
            if(strlen($user) > 20 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أقل من 20 حروف';
            }
            
            
            if(empty($user)){
                
                $formErros[] =  'الرجاء ملئ اسم المستخدم';
            }
            
             if(empty($name)){
                
               $formErros[] = 'الرجاء ملئ الاسم الكامل';
            }
            
            if(empty($email)){
                
                $formErros[] = 'الرجاء ملئ البريد الإلكتروني';
            }
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            if(empty($formErros)){
                
                $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ? ");
                
                 $stmt2->execute(array($user, $id));
                
                $count = $stmt2->rowCount();
                
                if ($count == 1){
                    
                    $theMsg =  '<div class="alert alert-danger">عذرا , هذا المستخدم موجود</div>';
                    
                    redirectHome($theMsg, 'back');
                    
                }else {
                    
                      $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
            
                        $stmt->execute(array($user, $email, $name, $pass, $id));
            
                        $theMsg = '<div class="alert alert-success">تم تحديث البيانات</div>';
                
                        redirectHome($theMsg, 'back');
                    
                }
                
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