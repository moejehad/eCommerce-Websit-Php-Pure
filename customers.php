<?php 

    session_start();

    $pageTitle = 'طلبات الزبائن';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $user = $_GET['user'];

    $stmt = $con->prepare("SELECT * FROM cart WHERE itemuser LIKE '%$user%' ORDER BY cartid DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
                            

?>

<div class="container notif" dir="rtl">    
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr class="title">
            <td>إسم الزبون</td>
            <td>المنتج</td>
            <td>السعر </td>
            <td>الكمية </td>
            <td>الهاتف </td>
            <td>العنوان </td>
            <td>تاريخ الطلب </td>
           
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
                
</div>

    <?php }else {
        
        echo '<div class="container oredrs">';
        echo '<div class="alert alert-danger">لا يوجد لديك طلبات شراء</div>';
        echo '</div>';
    }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>