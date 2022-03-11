<?php 

session_start();

    $pageTitle = 'الأقسام';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;


    if($do == 'Manage'){ 
    
    $sort = 'ASC';
        
    $sort_array = array('ASC','DESC');
        
    if(isset($_GET['sort']) && in_array( $_GET['sort'], $sort_array)){
        
        $sort = $_GET['sort'];
    }
        
    $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
        
    $stmt2->execute();
        
    $cats = $stmt2->fetchAll(); ?>
        
        
    <h1 class="text-center">إدارة الأقسام</h1>
    <div class="container categories">
        <div class="panel panel-default">
        <div class="panel-heading">
           <i class="fa fa-edit"></i> إدارة التصنيفات
            <div class="ordering pull-left">
                [
            <a class="<?php if($sort == 'ASC'){ echo 'active'; } ?>" href="?sort=ASC">Asc</a> -
            <a class="<?php if($sort == 'DESC'){ echo 'active'; } ?>" href="?sort=DESC">Desc</a>
                ]
            </div>
            </div>
            <div class="panel-body">
            <?php 
                
        foreach ($cats as $cat){
            
            echo '<div class="cat">';
                echo "<div class='hidden-buttons'>";
                echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "'  class='btn btn-xs btn-primary pull-left'><i class='fa fa-edit'></i>تعديل</a>";
                echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-xs btn-danger pull-left'><i class='fa fa-close'></i>حذف</a>";
                echo "</div>";
                echo "<h3>" . $cat['Name'] . '</h3>';
                echo "<p>"; if($cat['Description'] == ''){ echo 'هذا القسم ليس لديه وصف';}else {echo $cat['Description']; } echo  "</p>";
                if($cat['Visiblilty'] == 1) { echo '<span class="visiblilty">مخفي</span>';} 
                if($cat['Allow_Comment'] == 1) { echo '<span class="commenting">التعليقات معلقة</span>';} 
                if($cat['Allow_Ads'] == 1) { echo '<span class="advertises">الإعلانات معلقة</span>';}
                
                $subcat = getAllfrom("categories", "ID", " WHERE parent = {$cat['ID']} ");
                if(! empty($subcat)){
                echo "<h4>الأقسام الفرعية</h4>";
                foreach($subcat as $scat){

                    echo  "<a href='categories.php?do=Edit&catid=" . $scat['ID'] . "'>" . $scat['Name'] . "</a><br/>";
                    echo "<a href='categories.php?do=Delete&catid=" . $scat['ID'] . "' class='btn btn-xs btn-danger'> حذف</a><br/>";
                }
                }
                
            echo '</div>';
            echo '<hr>';
        }
                
                ?>
            </div>
        </div>
        <a class="add-categories btn btn-primary pull-right" href="categories.php?do=Add"><i class="fa fa-plus"></i>إضافة قسم جديد</a>
    </div>

        
        
    <?php  }elseif($do == 'Add'){ ?>
        
        <h1 class="text-center">إضافة قسم جديد</h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST">
    <div class="form-group">
        <label class="col-sm-2 control-label">الإسم </label>
        <div class="col-sm-10">
        <input type="text" name="name" autocomplete="off" class="form-control" required="required" placeholder="اسم القسم"/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">الوصف</label>
        <div class="col-sm-10">
        <input type="text" name="description" class=" form-control" placeholder=" وصف القسم "/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> الترتيب </label>
        <div class="col-sm-10">
        <input type="text" name="ordering" class="form-control" placeholder="رقم ترتيب القسم" />
        </div>
        </div>

         <div class="form-group">
        <label class="col-sm-2 control-label"> القسم الرئيسي </label>
        <div class="col-sm-10">
        <select class="form-control" name="parent">
            <option value="0">لا شئ</option>
            <?php
            
            $allCats = getAllfrom("categories", "ID", "WHERE parent = 0"); 
                                 
            foreach($allCats as $cat){
                
                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] ."</option>";
                
            }
                
            ?>
        </select>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"> الرؤية</label>
        <div class="col-sm-10">
                <div>
                    <input id="vis_yes" type="radio" name="visiblilty" value="0" checked />
                    <label class="vis_yes" for="vis_yes">نعم</label>
                </div>
                <div>
                    <input id="vis_no" type="radio" name="visiblilty" value="1" />
                    <label for="vis_no">لا</label>
                </div>
            </div>
        </div>
        
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> السماح بالتعليقات</label>
        <div class="col-sm-10">
                <div>
                    <input id="com_yes" type="radio" name="commenting" value="0" checked />
                    <label class="com_yes" for="com_yes">نعم</label>
                </div>
                <div>
                    <input id="com_no" type="radio" name="commenting" value="1" />
                    <label for="com_no">لا</label>
                </div>
            </div>
        </div>
        
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> السماح بالإعلانات</label>
        <div class="col-sm-10">
                <div>
                    <input id="ads_yes" type="radio" name="ads" value="0" checked />
                    <label class="ads_yes" for="ads_yes">نعم</label>
                </div>
                <div>
                    <input id="ads_no" type="radio" name="ads" value="1" />
                    <label for="ads_no">لا</label>
                </div>
            </div>
        </div>
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="إضافة قسم " class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>

        
                          
    <?php }elseif($do == 'Insert'){
          
        
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
                echo '<h1 class="text-center">قسم جديد</h1>';
                echo "<div class='container'>";
            
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $parent = $_POST['parent'];    
            $order = $_POST['ordering'];
            $visible = $_POST['visiblilty'];      
            $comment = $_POST['commenting'];      
            $ads = $_POST['ads'];      
            
                    
                $check = checkItem("Name", "categories", $name);
                if($check == 1 ){
                    
                    $theMsg = '<div class="alert alert-danger">هذا القسم موجود</div>';
                    
                     redirectHome($theMsg, 'back');
                    
                }else {
                    
                                    
            $stmt = $con->prepare("INSERT INTO categories 
            (Name, Description, Ordering, parent , Visiblilty, Allow_Comment, Allow_Ads)
            VALUES(:zname, :zdesc, :zorder,  :zparent , :zvisible, :zcomment, :zads ) ");
                
            $stmt->execute(array(
            
                'zname' => $name,
                'zdesc' => $desc,
                'zparent' => $parent,
                'zorder' => $order,
                'zvisible' => $visible,
                'zcomment' => $comment,
                'zads' => $ads
            
            
            ));
                
            
           $theMsg =  '<div class="alert alert-success"> تم إضافة البيانات </div>';
                    
                    redirectHome($theMsg, 'back');
                }
    

            
        }else{
            
            echo "<div class='container'>";
            $theMsg = '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة</div> ';
            
            redirectHome($theMsg, 'back');
            echo "</div>";
        }
            
            echo "</div>";
        
        
        
        
    }elseif($do == 'Edit'){ 
        
        
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']):0;
        
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        
            $stmt->execute(array($catid));
        
                $cat = $stmt->fetch();
        
                $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ ?>

                    <h1 class="text-center">تعديل القسم </h1>

    <div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid ?>"/>
    <div class="form-group">
        <label class="col-sm-2 control-label">الإسم </label>
        <div class="col-sm-10">
        <input type="text" name="name" class="form-control" required="required" placeholder="اسم القسم" value="<?php echo $cat['Name'] ?>"/>
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label">الوصف</label>
        <div class="col-sm-10">
        <input type="text" name="description" class=" form-control" placeholder=" وصف القسم " value="<?php echo $cat['Description'] ?>" />
        </div>
        </div>
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> الترتيب </label>
        <div class="col-sm-10">
        <input type="text" name="ordering" class="form-control" placeholder="رقم ترتيب القسم" value="<?php echo $cat['Ordering'] ?>" />
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-2 control-label"> الرؤية</label>
        <div class="col-sm-10">
                <div>
                    <input id="vis_yes" type="radio" name="visiblilty" value="0" <?php if ($cat['Visiblilty'] == 0){ echo 'checked'; } ?>/>
                    <label class="vis_yes" for="vis_yes">نعم</label>
                </div>
                <div>
                    <input id="vis_no" type="radio" name="visiblilty" value="1" <?php if ($cat['Visiblilty'] == 1){ echo 'checked'; } ?> />
                    <label for="vis_no">لا</label>
                </div>
            </div>
        </div>
        
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> السماح بالتعليقات</label>
        <div class="col-sm-10">
                <div>
                    <input id="com_yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0){ echo 'checked'; } ?> />
                    <label class="com_yes" for="com_yes">نعم</label>
                </div>
                <div>
                    <input id="com_no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1){ echo 'checked'; } ?> />
                    <label for="com_no">لا</label>
                </div>
            </div>
        </div>
        
        
         <div class="form-group">
        <label class="col-sm-2 control-label"> السماح بالإعلانات</label>
        <div class="col-sm-10">
                <div>
                    <input id="ads_yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0){ echo 'checked'; } ?> />
                    <label class="ads_yes" for="ads_yes">نعم</label>
                </div>
                <div>
                    <input id="ads_no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1){ echo 'checked'; } ?> />
                    <label for="ads_no">لا</label>
                </div>
            </div>
        </div>
        
         <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="حفظ التعديل" class="btn btn-primary"/>
        </div>
        </div>
        
    </form>   
</div>

        
            <?php 
                                 
    }else {
            
            echo "<div class='container'>";
            
            
            $theMsg = '<div class="alert alert-danger">هذا القسم غير موجود</div>';
            
            redirectHome($theMsg);
            
            
            echo "</div>";
        }
        
        
     
    }elseif($do == 'Delete'){
       
        
        
         echo '<h1 class="text-center">حذف القسم</h1>';
        
        echo "<div class='container'>";
                
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']):0;
        
    $check = checkItem('ID', 'categories', $catid);
        
    if($check > 0){ 
            
            $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
        
            $stmt->bindParam(":zid", $catid);
        
            $stmt->execute();
            
           $theMsg = '<div class="alert alert-success"> تم حذف القسم</div>';
            
             redirectHome($theMsg);

        }else {
            
            $theMsg = '<div class="alert alert-danger">هذا القسم غير موجود</div>';
            
            redirectHome($theMsg, 'back');
        
        }
        echo "</div>";
        
        
        
    } elseif($do = 'Update'){ 
        
        
         echo '<h1 class="text-center">تحديث بيانات القسم</h1>';
        
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id      = $_POST['catid'];
            $name    = $_POST['name'];
            $desc    = $_POST['description'];
            $order   = $_POST['ordering'];      
            $visible = $_POST['visiblilty'];      
            $comment = $_POST['commenting'];      
            $ads     = $_POST['ads'];      
            
             
          $stmt = $con->prepare("UPDATE 
                                    categories 
                                SET 
                                    Name = ?,
                                    Description = ?,
                                    Ordering = ?,
                                    Visiblilty = ?,
                                    Allow_Comment = ?,
                                    Allow_Ads = ?
                                WHERE 
                                    ID = ?");
            
           $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));
            
           $theMsg = '<div class="alert alert-success"> تم تحديث البيانات</div>';
                
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