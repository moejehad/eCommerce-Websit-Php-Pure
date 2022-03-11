<?php 

session_start();

    $pageTitle = 'رسائل الدعم الفني';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
             
    $stmt = $con->prepare("SELECT * FROM contact ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"><?php echo $pageTitle ?></h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>التاريخ </td>
            <td>الرسالة </td>
            <td>الهاتف </td>
            <td>البريد الإلكتروني </td>
            <td>الإسم </td>
            <td>رقم الرسالة</td>
             
             
             
             
             
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['message'] . "</td>";
                echo "<td>" . $row['mobile'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['id'] . "</td>";
                
                
                
                

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