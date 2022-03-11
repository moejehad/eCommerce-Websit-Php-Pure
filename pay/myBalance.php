<?php 

session_start();

    $pageTitle = "رصيدي" ;

    if(isset($_SESSION['username'])){
    
    include "init.php"; 
        
    $world = $_SESSION['username'];

    $sql = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$world%' ");
        
    $sql->execute();

    $get = $sql->fetch();


            
?>

<div class="home-stats" dir="rtl">

    <h1 class="text-center"> <?php echo $pageTitle ; ?></h1>
    
        <div class="alert alert-success myBalance">
            <h2 class="text-center">رصيدك الحالي </h2>
                <h1 class="text-center"><?php echo $get['balance'] ?> شيكل </h1>
            
        </div>
        
        </div>

<?php  
include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>