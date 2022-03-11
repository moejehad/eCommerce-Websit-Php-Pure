<?php 

session_start();

    $pageTitle = 'حسابات البائعين';

if(isset($_SESSION['Admin'])){
    
    include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    
    


    if($do == 'Manage'){ 
             
    $stmt = $con->prepare("SELECT * FROM users WHERE account = 'seller' ORDER BY UserID DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
                            

?>

    <h1 class="text-center"><?php echo $pageTitle ?></h1><br/>
    <div class="container">
        
    <div class="table-responsive">
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr>
            <td>تاريخ العضوية </td>
            <td>الإسم </td>
            <td>البريد الإلكتروني</td>
            <td>إسم المستخدم </td>
            <td>رقم الحساب</td>
             
             
             
             
             
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . $row['FullName'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['UserID'] . "</td>";
                
                
                
                

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