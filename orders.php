<?php 

    session_start();

    $pageTitle = 'مشترياتي';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $user = $_GET['user'];

    $stmt = $con->prepare("SELECT * FROM cart WHERE username LIKE '%$user%' ORDER BY cartid DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
                            

?>

<div class="container notif">    
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr class="title">
            <td>إسم المنتج</td>
            <td>السعر </td>
            <td>الكمية </td>
            <td>المجموع </td>
            <td>الحالة </td>
            <td>تاريخ الشراء </td>
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['price'] * $row['quantity'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
                
</div>

    <?php }else {
        
        echo '<div class="container oredrs">';
        echo '<div class="alert alert-danger">لا يوجد لديك مشتريات</div>';
        echo '</div>';
    }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>