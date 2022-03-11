<?php 

    session_start();

    $pageTitle = 'محفظتك';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $user = $_GET['user'];

    $stmt = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$user%' ORDER BY UserID DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
                            

?>

<div class="container" dir="rtl">    
    <div class="col-md-12 balance">
        <?php   
            foreach($rows as $row){
                
                echo "<span class='col-md-6'> رصيدك الحالي </span>";
                echo "<h1 class='col-md-6'> " . $row['balance'] . " ₪ </h1>";
                
            }
            
            ?>          
   
        </div>
                
</div>
        <div class="container balance">
            <div class="alert alert-success"><i class="fa fa-shopping-cart"></i> يمكنك الإستفادة من رصيدك بالشراء من الموقع 
            <a class="btn btn-success pull-left" href="products.php">تصفح المنتجات </a>
            </div>        
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle "></i> يمكنك إضافة رصيد بالتوجه لأقرب نقطة دفع إليك 
            <a class="btn btn-danger pull-left" href="address.php">نقاط الدفع </a>
            </div> 
            <div class="alert alert-primary"><i class="fa fa-credit-card"></i> لمعرفة مشترياتك 
            <a class="btn btn-primary pull-left" href="orders.php?user=<?php echo $_SESSION['user'] ?>">المشتريات </a>   
            </div>    
            
        </div>
    <?php }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>