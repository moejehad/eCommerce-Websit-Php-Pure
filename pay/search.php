<?php 

session_start();

    $pageTitle = $_GET['search'] ;

    if(isset($_SESSION['username'])){
    
    include "init.php"; 
        
    $world = $_GET['search'];

    $sql = $con->prepare("SELECT * FROM users WHERE Username LIKE '%$world%' ");
        
    $sql->execute();

    $get = $sql->fetch();

    $count = $sql->rowCount();

    if($count > 0){
        
    if($world != $_SESSION['username']){
    
?>

<div class="home-stats text-center pull-left">

    <h1 class="text-center">بيانات المستخدم</h1>
    
        <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>إضافة رصيد</td>
            <?php if ($get['account'] == "seller"){ ?>
            <td>تفعيل</td>
            <td>دفع الاشتراك</td>
            <?php }
            if($get['RegStatus'] == 1){
            ?>
            <td> انتهاء الاشتراك  </td>
            <?php } ?>
            <td>الرصيد</td>
            <td>نوع الحساب</td>
            <td>الإسم </td>
            <td>رقم المستخدم</td>
        </tr>
            
          <?php 
                echo "<tr>";
                echo "<td><a class='btn btn-success' href='balance.php?userid=" . $get['UserID'] . " '>اضافة</a></td>";
                if ($get['account'] == "seller"){
                echo "<td>";
                
                    if($get['RegStatus'] == 0){

                        echo "<a href='activate.php?ID=" . $get['UserID'] . "' class='btn btn-info activate' style='margin-left: 5px;'><i class='fa fa-check' style='position:  relative;right:  5px;'></i>تفعيل</a>";
                    }else {
                        
                        echo "الحساب مفعل";
                    }
                
                echo "</td>" ;
                echo "<td><a class='btn btn-success' href='payment.php?userid=" . $get['UserID'] . " '>دفع</a></td>";
                }
                if($get['RegStatus'] == 1){
                $exDate =  date('Y-m-d' , strtotime($get['subDate'].'+30 days'));
                    
                echo "<td>" . $exDate . "</td>";
                }
                echo "<td>₪ " . $get['balance'] . "</td>";
                echo "<td>" ;
                if($get['account'] == "seller"){
                    echo "بائع";
                }else {
                    echo "مشتري";
                }  "</td>";
                echo "<td>" . $get['FullName'] . "</td>";
                echo "<td>" . $get['UserID'] . "</td>";
                echo "</tr>";
                
            
            ?>  
                        
        </table>
        </div>
<?php 
    }else {
        echo '<div class="home-stats text-center pull-left">';
        echo '<div class="alert alert-danger">عذرا لا تستطيع اضافة رصيد لحسابك أو تفعيله </div>';
        echo '</div>';
    }
    }else {
        
    echo '<div class="home-stats text-center pull-left">';
    echo '<div class="alert alert-danger">هذا المشترك غير مسجل بالموقع</div>';
    echo '</div>';
        
    }    
?>
</div>
<?php  
include $tpl . 'footer.php';
    
} else {
    
    header('Location: index.php');
    
    exit();
}

?>