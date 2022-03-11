<?php 

    session_start();

    $pageTitle = 'التاريخ';

    
    include "inti.php"; 
                 
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = 51");
                        
    $stmt->execute(array($user));
                        
    $row = $stmt->fetch();

?>

            
          <?php 
            
                
                echo "<tr>";
                echo "<td>" . $row['Username'] . "<br/></td>";
                echo "<td>" . $row['Email'] . "<br/></td>";
                echo "<td>" . $row['Date'] . "<br/></td>";
                echo "</tr>";

        echo "<br/>";

        echo $today  = date('d-m-y');
        echo "<br/>";
        echo $addDay = date('d-m-y' , strtotime($row['Date'].'+85 days'));
        
        if($today >= $addDay){
            
            
            $stmt = $con->prepare("UPDATE users SET RegStatus = ? WHERE UserID = ?");
            
            $stmt->execute(array(0, $row['UserID']));
            
            echo $theMsg = '<div class="alert alert-success">تم تحديث البيانات</div>';
            
        }


    include $tpl . 'footer.php';
    

?>



