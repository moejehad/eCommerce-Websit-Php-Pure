<?php 

ob_start();

session_start();

$pageTitle = str_replace('-',' ',$_GET['name']) ;

include "inti.php"; 

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;
        
$stmt = $con->prepare("SELECT 
                                    items.*,
                                    categories.Name AS category_name,
                                    users.Username 
                            FROM    items

                            INNER JOIN 
                                    categories 
                            ON 
                                    categories.ID = items.Cat_ID

                            INNER JOIN 
                                    users 
                            ON 
                                    users.UserID = items.Member_ID
                            WHERE 
                                    item_ID = ?
                            AND
                                    Approve = 1");
        
$stmt->execute(array($itemid));

$count = $stmt->rowCount();

if($count > 0){
         
$item = $stmt->fetch();
    
?>

 <div class="show-items">
<div class="container profile">
    <div class="container">
    <div class="row">
        
    <div class="col-md-12 items-post">
        
    <div class="top">
        
        <div class="img-items">
<div id="slider" >
<figure>
        <?php if(empty($row['userImg'])){
                    
             echo " <img class='img-responsive' src='admin/Upload/Images/" . $item['Image'] . "' />";
                         
             echo "<img class='img-responsive' src='admin/Upload/Images/" . $item['Image1'] . "' />";
        
             echo " <img class='img-responsive' src='admin/Upload/Images/" . $item['Image2'] . "' />";
        
             echo " <img class='img-responsive' src='admin/layout/imgs/Y-Logo.png' />";
                            
            } ?>
</figure>	

</div>
            
            
        </div>
        <br>
        <div class="info" dir="rtl">   
            
        <h1 class="show-item text-center"><span><?php echo $item['Name']; ?></span></h1>

        <?php if($item['Minus'] > 0){ ?>
        <h2 class="text-center"><?php echo $item['Minus']; ?> ₪ </h2>
        <?php   }else { ?>
        <h2 class="text-center"><?php echo $item['Price']; ?> ₪ </h2>
        <?php    } ?>
            
       <?php if(isset($_SESSION['user'])){ ?>

            <?php echo '<a href="walletCart.php?itemid='. $item['item_ID'] . '&name='. str_replace(' ','-',$item['Name']) . ' " >';?>
                <span class="btn btn-primary buy_now" style="margin: 10px 0 10px 0;"><i class="fa fa-credit-card"></i> شراء باستخدام المحفظة </span>
            
            <?php echo "</a>"; echo '<a href="cart.php?itemid='. $item['item_ID'] . '&name='. str_replace(' ','-',$item['Name']) . ' " >';?>
                <span class="btn btn-primary buy_now" style="margin: 10px 0 10px 0;"><i class="fa fa-truck"></i> شراء والدفع عند الإستلام </span>
            
            <?php echo "</a>"; 
            
            echo '<a class="btn btn-info" href="message.php?from='. $_SESSION['user'] . '&to='. $item['Username'] . ' " ><i class="fa fa-envelope"></i> مراسلة البائع</a>';                              
            
            }else { ?> 
             <a target="_blank" href="login.php" >
            <span class="btn btn-primary buy_now" style="margin: 10px 0 10px 0;"><i class="fa fa-credit-card"></i> شراء  </span>
            </a>
           <?php }   
            ?>
        
        <form name="paypal" target="_self"  action="https://www.sandbox.paypal.com/cgi-bin/websor" method="post" onsubmit="return CheckForm(this);">
            <input type="hidden" name="cpp_header_image" value="http://localhost/last/layout/imgs/Y-Logo.png">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="moj@shop.com">
            <input type="hidden" name="item_name" value="<?php echo $item['Name']; ?>">
            <input type="hidden" name="quantity" value="3">
            <input type="hidden" name="amount" value="<?php echo $item['Price']; ?>">
            <input type="hidden" name="return" value="http://localhost/last/products.php">
            <input type="hidden" name="cancel_return" value="http://localhost/last/products.php">
            <input type="hidden" name="currency_code" value="ILS">
            <input type="hidden" name="button_subtype" value="products">
            <input type="hidden" name="no_note" value="0">
            <input type="submit" value="Pay now" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

        </form>
            
        <ul class="list-unstyled" style="margin: 20px -30px;">
        <li><span>تاريخ النشر : </span><?php echo $item['Add_Date']; ?>  </li>
        <li><span>التصنيف   :  </span><a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>&name=<?php echo $item['category_name'] ?>"><?php echo $item['category_name']; ?></a></li>
        <li><span>صاحب المنتج  : </span><?php echo $item['Username']; ?></li>
            
        <?php 
    
    
        $stmt1 = $con->prepare("UPDATE items SET counter = counter+1 WHERE item_id = ?");
                        
        $stmt1->execute(array($item['item_ID']));
                               
    
        $stmt2 = $con->prepare("SELECT counter FROM items WHERE item_id = ?");
                        
        $stmt2->execute(array($item['item_ID']));
                           
        $rows = $stmt2->fetchAll();
    
        
        ?>    
            
        <li class="mem_cat"><span>المشاهدات  : </span><?php  foreach($rows as $row){ echo $row["counter"]; }?> </li>
        </ul>
       
             
    </div>
      </div>  
        
<div class="desc" dir="rtl">
    <h1>المواصفات</h1>
        <p><?php echo $item['Description']; ?></p>        
</div>
        
        
        <div class="col-md-8 comments">
        <?php if(isset($_SESSION['user'])){ ?>
        <div class="row">

            <div class="col-md-12">
                <div class="add-comment">
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name'])  ?>" method="POST">
                            <textarea class="form-control"  name="comment" placeholder=" إضافة تعليق ... "></textarea>    
                            <input class="btn btn-primary" type="submit" value="إضافة تعليق" />
                        
                        </form>
                    <?php 
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        
                        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING) ;
                        $itemid  = $item['item_ID'] ;
                        $userid  = $_SESSION['Uid'] ;
                        
                        if(! empty($comment)){
                            
                          $stmt = $con->prepare("INSERT INTO 
                                                        comments(comment, status, comment_date, item_id, user_id)
                                                        VALUES(:zcomment , 1 , NOW(), :zitemid, :zuserid)
                                                        ");
    
                            $stmt->execute(array(
                            
                                'zcomment' => $comment,
                                'zitemid'  => $itemid,
                                'zuserid'  => $userid
                                
                            ));
                            
                            if($stmt){
                                
                                    $notiUser = $_SESSION['user'];
                                    $notiName = $item['Username'];
                                    $notiType = "comment";
                                    $notiDetails = "التعليق على " . $item['Name'];
                                    $notiStatus = "unread";


                                    $stmt = $con->prepare("INSERT INTO notifications 
                                    (notiUser , notiName , notiDetails , notiStatus , notiType,  notiDate , notTime)
                                    VALUES(:ZnotiUser , :ZnotiName, :ZnotiDetails , :ZnotiStatus , :ZnotiType , now() , now() ) ");

                                    $stmt->execute(array(

                                        'ZnotiUser'      => $notiUser,
                                        'ZnotiName'      => $notiName,
                                        'ZnotiDetails'   => $notiDetails,
                                        'ZnotiType'      => $notiType,
                                        'ZnotiStatus'    => $notiStatus            

                                    ));                                
                                
                                    echo '<div class="alert alert-success" style="margin-left: 10px;"><i class="fa fa-check"></i>تم إضافة التعليق بنجاح</div>';
                            }
                            
                        }
                        
                    }
                    
                    ?>
                </div>
            </div>
        </div>
        <?php }else{
        
        echo 'سجل دخول لإضافة تعليق<br>
        <div class="profile pull-right"><a target="_blank" href="login.php">
        <span class=" btn btn-primary"><i class="fa fa-sign-in fa fa-lg"></i> تسجيل دخول </span>
         </a></div><br>';
    } ?>
        <hr>
        
            <?php
                 $stmt = $con->prepare("SELECT 
                                    comments.*, users.Username AS Member , users.userImg, users.UserID
                            FROM 
                                    comments
                            INNER JOIN 
                                    users
                            ON
                                    users.UserID = comments.user_id
                            WHERE 
                                    item_id = ?
                            AND   
                                    status = 1
                            ORDER BY c_id DESC");
                        
                    $stmt->execute(array($item['item_ID']));
                           
                    $comments = $stmt->fetchAll();
                            

            ?>
                            
            
                <?php 
    
                foreach($comments as $comment){ ?>
                    
                    <div class="comment-box">
                    <div class="row">
                        
                    <div class="col-md-1">
                        <?php 

                            if(empty($comment['userImg'])){

                            echo '<img src="admin/Upload/Images/user.png" />';

                            }else{

                             echo " <img src='admin/Upload/Images/" . $comment['userImg'] . "'/>";
                            }

                        ?>

                        </div>
                            
                    <div class="col-md-11">
                        <h2><a><?php echo $comment['Member'] ?></a></h2>
                        <p><?php echo $comment['comment'] ?></p>
                        </div>
                            
                            
                        </div>
                        <hr>
                    </div>
               <?php } ?>            
       
            </div>
        
        <div class='col-md-4 postshare'>
        <h4 class='share'> مشاركة المنتج على </h4>
            <a class='share-facebook' href='http://www.facebook.com/sharer.php?u=<?php echo 'https://www.yelsto.com' . $_SERVER['PHP_SELF'] . '?itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name'])  ?>&amp;t=<?php echo $_GET['name'] ?>' target='_blank'>
              <i class="fa fa-facebook"></i>
                فيسبوك
            </a>
            
            <a class='share-twitter' href='http://twitter.com/home/?status=<?php echo $_GET['name']?> : <?php echo 'https://www.yelsto.com' . $_SERVER['PHP_SELF'] . '&itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name'])  ?>' target='_blank'>
             <i class="fa fa-twitter"></i>
                تويتر
            </a>
            
            <a class='share-gplus' href='http://plus.google.com/share?url=<?php echo 'https://www.yelsto.com' . $_SERVER['PHP_SELF'] . '&itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name'])  ?>' target='_blank'>
             <i class="fa fa-google-plus"></i>
                جوجل بلس
            </a>        
    </div>  
        
    </div>
        
        
    </div>
        <br>

</div>
</div>

<?php
    }else{
    
    echo '<div class="container">';
    echo '<div class="alert alert-danger">لا يوجد منتج بهذا الإسم أو هذا المنتج ينتظر التفعيل</div>';
    echo '</div>';
}
include $tpl . 'footer.php'; 
ob_end_flush();

?>



