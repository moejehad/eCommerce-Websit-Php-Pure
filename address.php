<?php 

ob_start();

session_start();

$pageTitle = 'نقاط الدفع';

include "inti.php"; 

?>

<div class="terms">
    <div class="container notif">
            
        <div class="title text-center"><h2><i class="fa fa-credit-card"></i> <?php echo $pageTitle ?>  </h2></div>

        <div class="info col-md-6">
        
            <div class="table-responsive">
                <table class="main-table manage-members text-center table table-bordered">

                <tr class="title">
                    <td>الإسم</td>
                    <td>العنوان </td>
                </tr>
                <tr>
                    <td>حجازي</td>
                    <td> غزة - النصر - محطة بهلول </td>
                </tr>
                <tr>
                    <td>حجازي</td>
                    <td> غزة - النصر - محطة بهلول </td>
                </tr> 
                <tr>
                    <td>حجازي</td>
                    <td> غزة - النصر - محطة بهلول </td>
                </tr> 

                </table>
            </div>
                
        </div>
            
            
        

        <div class="img col-md-6 pull-left">
            <img src="layout/imgs/Untitled-8.png" />
        </div>
    </div>
</div>

<?php 
    
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>