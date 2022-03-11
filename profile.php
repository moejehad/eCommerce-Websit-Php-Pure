<?php 

ob_start();

session_start();

$pageTitle = 'Yellow store - ' . $_SESSION['user'];

include "inti.php"; 


if(isset($_SESSION['user'])){
    
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    
    $getUser->execute(array($sessionUser));
    
    $info = $getUser->fetch();
?>

<div class="information">
<div class="container my profile">
    <?php 
    
         $today  = date('d-m-y');
         $addDay = date('d-m-y' , strtotime($info['subDate'].'+30 days'));
    
        if($today >= $addDay){
            
            $stmt = $con->prepare("UPDATE users SET RegStatus = ? WHERE Username = ?");
            
            $stmt->execute(array(0, $_GET['user']));
                        
        }
    
    
    if ($info['account'] == "seller" && $info['RegStatus'] == 0 ){ 
        
        echo '<div class="alert alert-danger" style="margin: 0;">';
        echo '<i class="fa fa-exclamation-circle "></i>';
           echo '  لتفعيل نشر المنتجات في حسابك يرجى دفع سعر الإشتراك في <a href="address.php">نقاط الدفع</a>';
           echo '  | سعر الإشتراك الشهر 100 شيكل .';
        echo '</div>';
        
    }  
    ?> 
    <br/>
    <div class="col-md-12 profil" style="margin-bottom: 35px;">  
    <div class="prof">
        <div class="cover">
<?php if(isset($_SESSION['user'])){ ?>
    <div class="links">
        <ol class="breadcrumb pull-right">
              <li><a href="profile.php?user=<?php echo $_SESSION['user'] ?>"><i class="fa fa-user"></i> ملفي الشخصي </a></li>
              <li><a href="edit.php?ID=<?php echo $info['UserID'] ?>"><i class="fa fa-cog"></i> تعديل بياناتي </a></li>
              <li><a href="newad.php"><i class="fa fa-plus-circle"></i> منتج جديد </a></li>
              <li><a href="statements.php?user=<?php echo $_SESSION['user'] ?>"><i class="fa fa-usd"></i> محفظتك </a></li>
              <li><a href="customers.php?user=<?php echo $_SESSION['user'] ?>"> <i class="fa fa-credit-card"></i> طلبات الزبائن </a></li>  
              <li><a href="orders.php?user=<?php echo $_SESSION['user'] ?>"><i class="fa fa-shopping-cart"></i> مشترياتي </a></li>  
              <li><a href="contact.php"><i class="fa fa-question-circle"></i> الدعم الفني </a></li>
              <li><a href="logout.php"><i class="fa fa-sign-out"></i> تسجيل خروج</a></li>
        </ol>
    </div>
            
    <select onchange="location = this.value;" class="form-control prof fot" style="float:  right;font: normal normal 17px sky-bold, Fontawesome;">
        <option value="profile.php">حسابي</option>
        <option value="profile.php?user=<?php echo $_SESSION['user'] ?>"><a href="profile.php?user=<?php echo $_SESSION['user'] ?>">ملفي الشخصي</a></option>
        <option value="edit.php?ID=<?php echo $info['UserID'] ?>"><a href="edit.php?ID=<?php echo $info['UserID'] ?>">تعديل بياناتي</a></option>
        <option value="newad.php"><a href="newad.php">منتج جديد</a></option>
        <option value="statements.php?user=<?php echo $_SESSION['user'] ?>"><a href="statements.php?user=<?php echo $_SESSION['user'] ?>">محفظتك</a></option>        
        <option value="orders.php?user=<?php echo $_SESSION['user'] ?>"><a href="orders.php?user=<?php echo $_SESSION['user'] ?>">مشترياتي</a></option>
        <option value="customers.php?user=<?php echo $_SESSION['user'] ?>"><a href="customers.php?user=<?php echo $_SESSION['user'] ?>">طلبات الزبائن</a></option>
        <option value="contact.php"><a href="contact.php">الدعم الفني</a></option>
        <option value="logout.php"><a href="logout.php">تسجيل خروج</a></option>
    </select>
            
    <?php } ?>
        </div>
        
     <div class="profile_photo text-center">
    <?php 
    
    if(! empty($info['userImg'])){
        
         echo " <img src='admin/Upload/Images/" . $info['userImg'] . "' />";
    }else {
        
        echo '<img src="layout/imgs/user.png" />';
    }
    
    ?>
        
        </div>
        <h2 class="name-of-user"><?php echo $info['FullName'] ?></h2>
    </div>
        
        <div class="col-sm-3">
            
           <div class="col-sm-12">
    <div class="panel panel-info info">
        <div class="panel-body">
            <ul class="list-unstyled">
            <li class="Fullnamea"><i class="fa fa-user fa-fw"></i><?php echo $info['FullName'];?></li> 
            <li><i class="fa fa-unlock fa-fw"></i> <?php echo $info['Username'] ?></li>
            <li><i class="fa fa-envelope fa-fw"></i> <?php echo $info['Email'] ?></li>
            <li><i class="fa fa-calendar fa-fw"></i> إنضم في <?php echo $info['Date'] ?>  </li>
            </ul>
        </div>
    </div>
    </div> 
            
    <div class="col-sm-12">
    <div class="panel panel-info info">
        <div class="panel-body">
            <ul class="list-unstyled"> 
            <li><i class="fa fa-info-circle fa-fw"></i> <br> عند الرغبة في عمل خصم أو تخفيض على منتج الرجاء التواصل مع الإدارة وتحديد المنتج وسعر الخصم و مدة الخصم </li>
            </ul>
        </div>
    </div>
    </div>
            
            
        </div>
        
        
    
    <div class="col-sm-9">
    <div class="panel panel-info ads">
        <div class="panel-body">
    <div class="row">
    <?php 
    
     if(! empty(getItems('Member_ID', $info['UserID']))){
    foreach(getItems('Member_ID', $info['UserID'], 1) as $item){
        
        echo '<div class="col-md-6 itemsss">';
            echo '<div class="thumbnail item-box">';
        
                if($item['Approve'] == 0){ 
                    
                    echo '<span class="approve-status">غير مفعل</span>'; 
                    
                }
        
                            if(! empty($item['Minus'])){
                                    
                                 echo '<span class="price-tag">' . $item['Minus'] . ' ₪ </span>';
                                 echo '<span class="price-tag-minus"> ' . $item['Price'] . ' ₪ </span>';
                                    
                                }else {
                                    
                                    echo '<span class="price-tag">' . $item['Price'] . ' ₪ </span>';
                                }

                          if(empty($row['userImg'])){
                    
                            echo " <img class='img-responsive center-block' src='admin/Upload/Images/" . $item['Image'] . "' />";
                    
                            } 
                echo '<div class="caption">';   
                            echo '<h3><a href="items.php?itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name']) . ' ">' . $item['Name'] . '</a></h3>';
                    echo '<div class="date">' . $item['Add_Date'] . '</div>';
                echo '</div>';                 
            echo '</div>';
        echo '</div>';
    }
     }else{
         
         echo 'لم تقم بنشر أي منتج <a href="newad.php">إضافة منتج جديد</a>';
     }
    
    ?>
    </div>
        </div>
    </div>
    

    
    </div>
        

    
        
        <br>
        
        </div>
    <br>
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



