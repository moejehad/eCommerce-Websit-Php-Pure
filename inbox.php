<?php 

    session_start();

    $pageTitle = ' الرسائل الواردة';

    if(isset($_SESSION['user'])){
    
    include "inti.php"; 
                 
    $user = $_GET['user'];

    $stmt = $con->prepare("SELECT * FROM msg WHERE received LIKE '%$user%' ORDER BY msgID DESC");
                        
    $stmt->execute(array($user));
                        
    $rows = $stmt->fetchAll();
        
    $count = $stmt->rowCount();  
    
    if($count > 0){
        

?>

<div class="container msgPage" dir="rtl">    
    <div class="table-responsive">
        <h3 style="margin-bottom : 40px ;"><i class="fa fa-envelope"></i> <?php echo $pageTitle; ?> </h3>
        
        <div class="countMsg col-md-6"><h5> الرسائل الغير مقروءة </h5> <span class="pull-left"><?php echo countMsgRd('msgID', 'msg' , 'received' , $user )?></span></div>
        <div class="countMsg col-md-6"><h5> مجموع الرسائل </h5><span class="pull-left"><?php echo countMsg('msgID', 'msg' , 'received' , $user )?></span></div>
        
        <table class="main-table manage-members text-center table table-bordered">
            
        <tr class="title">
            <td>أرسلت بواسطة </td>
            <td>العنوان  </td>
            <td>التاريخ والوقت </td>
        </tr>
            
          <?php 
            
            
            foreach($rows as $row){
                
                echo "<tr>";
                echo "<td>" . $row['sender'] . "</td>";
                
                echo "<td><a href='msg.php?m=" . $row['msgID'] . "&from=" . $row['sender'] . " '>" . $row['title'] . "</a> ";
                "</td>";
                echo "<td>" . $row['date'] . " | " . $row['time'] . "</td>";
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>
        </div>
                
</div>

    <?php }else {
        
        echo '<div class="container oredrs">';
        echo '<div class="alert alert-danger">لا يوجد لديك رسائل</div>';
        echo '</div>';
    }
    include $tpl . 'footer.php';
    
    }else {
    
    header('Location: index.php');
    
    exit();
    

}

?>