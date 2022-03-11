<?php 

ob_start();

session_start();

$pageTitle = $_GET['search'];

include "inti.php"; 

$world = $_GET['search'];

$sql = $con->prepare("SELECT * FROM items WHERE Name LIKE '%$world%' ORDER BY item_ID DESC");

$sql->execute(array($world));
    
$gets = $sql->fetchAll();
        
$count = $sql->rowCount();
    
if($count > 0){ ?>         
    <div class="container search">
        <h2 class='alert alert-info'><i class='fa fa-exclamation-circle'></i> نتائج البحث عن ( <?php echo $world ?> ) </h2>
    <div class="posts">
    <div class="row">
    <?php 
            
        foreach($gets  as $get){
        
                echo '<div class="col-md-3 itemsss">';
                    echo '<div class="thumbnail item-box">';
                                  if(! empty($get['Minus'])){
                                    
                                 echo '<span class="price-tag">' . $get['Minus'] . ' ₪ </span>';
                                 echo '<span class="price-tag-minus"> ' . $get['Price'] . ' ₪ </span>';
                                    
                                }else {
                                    
                                    echo '<span class="price-tag">' . $get['Price'] . ' ₪ </span>';
                                }
                          if(empty($get['userImg'])){
                    
                            echo " <img class='img-responsive center-block' src='admin/Upload/Images/" . $get['Image'] . "' />";
                    
                            } 
                        echo '<div class="caption">';   
                            echo '<h3><a href="items.php?itemid=' . $get['item_ID'] . '&name=' . str_replace(' ','-',$get['Name']) . ' ">' . $get['Name'] . '</a></h3>';
                            echo '<div class="date">' . $get['Add_Date'] . '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
    }
    
    ?>
    </div>
        </div>
</div>
         
<?php }else{ 
    
    echo '<div class="result-search">';
    echo '<div class="container">';
    echo '<div class="alert alert-danger">لا يوجد منتجات بهذا الإسم</div>';
    echo '<a href="products.php"><div class="btn btn-primary">العودة لصفحة المنتجات </div></a>';
    echo '</div>';
    echo '</div>';
    
 }

ob_end_flush();

?>