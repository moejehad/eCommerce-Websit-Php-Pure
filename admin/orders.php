<?php 

session_start();

    $pageTitle = ' طلبات الزبائن';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
             
    $stmt = $con->prepare("SELECT * FROM cart ORDER BY cartid DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"> طلبات الزبائن </h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>تاريخ الطلب </td>
            <td>العنوان </td>
            <td>الهاتف </td>
            <td>الحالة </td>
            <td>المجموع </td>
            <td>الكمية </td>
            <td>السعر </td>
            <td>إسم المنتج</td>
            <td>صاحب المنتج</td>
            <td>إسم المستخدم </td>
             <td>الرقم</td>
           
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['price'] * $row['quantity'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['itemuser'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['cartid'] . "</td>";
                              
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
                
</div>

    <?php }
        
    }else {
    
    header('Location: index.php');
    
    exit();
    
    include $tpl . 'footer.php';

}

?>