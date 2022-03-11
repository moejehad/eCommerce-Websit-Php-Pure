<?php 

ob_start();

session_start();

$pageTitle = 'شراء ' . str_replace('-',' ',$_GET['name']); ;

include "inti.php"; 

if(isset($_SESSION['user'])){
    
            $user = $sessionUser;

            $stmt = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$user%'");

            $stmt->execute(array($user));

            $rows = $stmt->fetch();
    
    
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;

            $stmt = $con->prepare("SELECT 
                                                items.*,
                                                categories.Name AS category_name,
                                                users.*
                                        FROM    items

                                        INNER JOIN 
                                                categories 
                                        ON 
                                                categories.ID = items.Cat_ID

                                        INNER JOIN 
                                                users 
                                        ON 
                                                users.UserID = items.Member_ID
                                        WHERE 
                                                item_ID = ?
                                        AND
                                                Approve = 1");

            $stmt->execute(array($itemid));

            $count = $stmt->rowCount();

            if($count > 0){

            $item = $stmt->fetch();
    
    
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $username   = $_POST['username'];
        $name       = $_POST['name'];
        $price      = $_POST['price'];
        $itemuser   = $_POST['itemuser'];
        $status     = $_POST['status'];
        $phone      = $_POST['phone'];
        $address    = $_POST['address'];
        $number     = $_POST['quantity'];
    

    

    if(empty($number)){
                
            $formErros[] = 'يجب وضع الكمية المطلوبة  ';
     }

    if(empty($phone)){
                
            $formErros[] = 'الرجاء وضع رقم الهاتف';
     }

    if(empty($address)){
                
            $formErros[] = 'الرجاء وضع العنوان التفصيلي';
     }
    
      if(empty($formErros)){
                                    
            $stmt = $con->prepare("INSERT INTO cart 
            (username, name, price, itemuser , status , phone, address, quantity, Date)
            VALUES(:zuser, :zname, :zprice , :zitemuser, :zstatus , :zphone , :zadd,  :znumber , now()) ");
                
            $stmt->execute(array(
            
                'zuser'   => $username,
                'zname'   => $name,
                'zprice'  => $price,
                'zitemuser'  => $itemuser,
                'zstatus'  => $status,
                'zphone'  => $phone,
                'zadd'    => $address,
                'znumber' => $number
            
            
            ));
                
            $notiUser = $_POST['username'];
            $notiName = $_POST['itemuser'];
            $notiType = "buy";
            $notiDetails = "شراء " . $_POST['name'];
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
          
            $successMsg = 'تم إرسال طلبك وسيتم التواصل معك في أقرب وقت';

                
            }
    
        
    
            }
    


    
?>



 <div class="cart" dir="rtl">
<div class="container">
 
    <div class="container contact-with-seller">
        <h1 class="text-center cat">شراء <?php echo $item['Name'] ?></h1>  
        
            <div class="the-errors cart text-center">
        <?php 
        
    if(isset($error)){
                    
            echo '<div class="msg">' . $error . '</div><br>';
    }
              
    if(isset($successMsg)){
        
        echo '<div class="msg-success">' . $successMsg . '</div><br>';
    }
        
        ?>
    
    </div>
        
        <form class="cart" action="cart.php?itemid=<?php echo $item['item_ID'] ?>&name=<?php echo $item['Name'] ?>" method="POST">

            <input class="form-control" type="text" readonly name="username" autocomplete="off" value="<?php echo $sessionUser ?>" required/>
            <i class="fa fa-user fa-fw"></i>
            
            <input class="form-control" type="text" readonly name="name" value="<?php echo $item['Name'] ?>" required/>
            <i class="fa fa-align-justify fa-fw"></i>

            <input class="form-control" type="text" readonly name="price" value="<?php if($item['Minus'] > 0){echo  $item['Minus'];}else {echo $item['Price'];} ?>" required/>
            <i class="fa fa-fw">₪</i>
            
            <input type="hidden" name="itemuser" value="<?php echo $item['Username'] ?>" readonly required />
                                    
            <input type="hidden" name="status" value="غير مدفوع" readonly required />

            
            <input class="form-control num" type="number" name="quantity" min="1" max="10" placeholder=" الكمية المطلوبة " required/>
            <i class="fa fa-list-ol fa-fw"></i>
            
            <input class="form-control" type="text" name="phone" placeholder=" رقم الهاتف " required/>
            <i class="fa fa-phone fa-fw"></i>
            
            <input class="form-control" type="text" name="address" placeholder="العنوان التفصيلي" required/>
            <i class="fa fa-map-pin fa-fw"></i>
            
            <input class="btn btn-success" type="submit" value="شراء"/>
        </form>

        
</div>
    
    
</div>
</div>
<?php }else{
    
    echo '<div class="container">';
    echo '<div class="alert alert-danger">لا يوجد منتج بهذا الإسم أو هذا المنتج ينتظر التفعيل</div>';
    echo '</div>';
}
}else {
    
        header('Location: login.php');
        
        exit();
}
?>
<?php
include $tpl . 'footer.php'; 
ob_end_flush();

?>



