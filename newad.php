<?php 

session_start();

$pageTitle = 'إضافة منتج جديد';

include "inti.php"; 

if(isset($_SESSION['user'])){
            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
        $formErrors = array();
                    
        $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price    = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);            
        $prnt     = filter_var($_POST['prnt'], FILTER_SANITIZE_NUMBER_INT);            
           
        $imageName = $_FILES['Image']['name'];
        $imageSize = $_FILES['Image']['size'];
        $imageTmp  = $_FILES['Image']['tmp_name'];
        $imageType = $_FILES['Image']['type'];

        $imageAllowedExtension = array("jpeg", "jpg","png","gif");
            
            
        $image1Name = $_FILES['Image1']['name'];
        $image1Size = $_FILES['Image1']['size'];
        $image1Tmp  = $_FILES['Image1']['tmp_name'];
        $image1Type = $_FILES['Image1']['type'];

        $image1AllowedExtension = array("jpeg", "jpg","png","gif");
            
            
        $image2Name = $_FILES['Image2']['name'];
        $image2Size = $_FILES['Image2']['size'];
        $image2Tmp  = $_FILES['Image2']['tmp_name'];
        $image2Type = $_FILES['Image2']['type'];

        $image2AllowedExtension = array("jpeg", "jpg","png","gif");
            
            
        if(strlen($name) < 5){
        
        $formErrors[] = 'يجب أن يكون الإسم أكثر من 5 حروف';
            
        }
        
        if(strlen($desc) < 10){
        
        $formErrors[] = 'يجب أن يكون الوصف أكثر من 10 حروف';
            
        }
        
        
        if(empty($price)){
        
        $formErrors[] = 'يجب وضع سعر للمنتج';
            
        }
        
        if(empty($category)){
        
        $formErrors[] = 'يجب وضع تصنيف للمنتج';
            
        }
            

        if(empty($imageName)){
                
                $formErros[] = 'يجب وضع صورة ';
            }
            
        if($imageSize > 4194304){
                
                $formErros[] = 'يجب أن يكون حجم الصورة أقل من 4 ميغابايت';
            }
        
        
          if(empty($formErrors)){
              
               $image = rand(0, 1000000000) . '_' . $imageName;
               
               move_uploaded_file($imageTmp, './admin/Upload/Images/' . $image );
              
              
               $image1 = rand(0, 1000000000) . '_' . $image1Name;
               
               move_uploaded_file($image1Tmp, './admin/Upload/Images/' . $image1 );
              
              
               $image2 = rand(0, 1000000000) . '_' . $image2Name;
               
               move_uploaded_file($image2Tmp, './admin/Upload/Images/' . $image2 );
              
              
            $stmt = $con->prepare("INSERT INTO items 
            (Name, Description, Price, Cat_ID, prnt , Member_ID, Add_Date, Image, Image1, Image2)
            VALUES(:zname, :zdesc, :zprice, :zcat, :zprnt, :zmember, now(), :zimage, :zImage1, :zImage2) ");
                
            $stmt->execute(array(
            
                'zname'   => $name,
                'zdesc'   => $desc,
                'zprice'  => $price,
                'zimage'  => $image,
                'zImage1'  => $image1,
                'zImage2'  => $image2,
                'zcat'    => $category,
                'zprnt'   => $prnt,
                'zmember' => $_SESSION['Uid']
            
            ));
                
              $successMsg =  '<div class="alert alert-success">تم إضافة المنتج وهو قيد المراجعة</div>';
              
            }
        
        
    }
    
?>


 <div class="create-ads" dir="rtl">
<div class="container profile">
    
    <br/>

<?php 
                        
                          
$userStatus = checkUserStatus($sessionUser);
                        
if($userStatus == 1){
                            
   echo '<h1 class="alert alert-danger text-center">لعرض المنتجات الرجاء التواصل مع الدعم الفني . <br><br> أو التوجه لإحدى نقاط الدفع لدفع سعر الإشتراك . </h1>';
    
}else{

?>
    
    
    <div class="col-sm-12">
    <div class="panel panel-info ads">
        <div class="panel-heading"><i class="fa fa-plus-circle"></i> <?php echo $pageTitle; ?></div>
        <div class="panel-body">
            <div class="row">
            <div class="col-md-12">
    <div class="the-errors text-center">
        <?php 
        
    if(!empty($formErrors)){
        
        foreach($formErrors as $error){
            
            echo '<div class="alert alert-danger">' . $error . '</div><br>';
        }
    }
    
    if(isset($successMsg)){
        
        echo $successMsg;
    }
    
              
        
        ?>
    
    </div>
     <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        
    <div class="form-group">
        <div class="col-sm-12">
        <input type="text" name="name" class="form-control" placeholder="الإسم " required />
        </div>
        </div>

    <div class="form-group">
        <div class="col-sm-12">
            <textarea rows="10" type="text" name="description" class="form-control"  placeholder="الوصف " required></textarea>
        </div>
        </div>
        
    <div class="form-group">
        <div class="col-sm-12">
        <input type="text" name="price" class="form-control" placeholder="الرجاء وضع السعر أرقام بدون رموز" required />
        </div>
        </div> 

    <div class="form-group">
        <label class="col-sm-2 control-label">صورة المنتج الرئيسية</label>
        <div class="col-sm-10">
        <input type="file" name="Image" class="form-control" required />
        </div>
        </div>
         
    <div class="form-group">
        <label class="col-sm-2 control-label">الإرتفاع - 340</label>
        <div class="col-sm-10">
        <input type="file" name="Image1" class="form-control" required /><br>
        <input type="file" name="Image2" class="form-control" required />
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
        <select class="form-control" name="prnt" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;">
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
        <div class="col-sm-12">
        <input type="submit" value="إضافة منتج " class="btn btn-primary"/>
        <a href="profile.php?user=<?php echo $sessionUser ?>" class="btn btn-primary pull-left">الرجوع للصفحة الشخصية</a>
        </div>
        </div>
        
    </form>   
                
                
            </div>
            </div>
        </div>

    </div>
    </div>
    <?php } ?>
     </div>
</div>


<?php }else {
    
        header('Location: login.php');
        
        exit();
    
} ?>

<?php

include $tpl . 'footer.php'; 
ob_end_flush();

?>


