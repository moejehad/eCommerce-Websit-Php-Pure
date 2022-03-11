<?php 

session_start();

$pageTitle = str_replace('-',' ',$_GET['name']);

include "inti.php";

?>


<div class="container" dir="rtl">

    <div class="posts">
    <div class="row">
    <?php 
    
    if(! empty ( getItems('prnt', $_GET['pageid'] , 1)  )){
        
        foreach(getItems('prnt', $_GET['pageid'] , 1 . $_GET['name']) as $item){
                
                echo '<div class="col-md-3 itemsss">';
                    echo '<div class="thumbnail item-box">';
                                  if(! empty($item['Minus'])){
                                    
                                 echo '<span class="price-tag">' . $item['Minus'] . ' ₪ </span>';
                                 echo '<span class="price-tag-minus"> ' . $item['Price'] . ' ₪ </span>';
                                    
                                }else {
                                    
                                    echo '<span class="price-tag">' . $item['Price'] . ' ₪ </span>';
                                }
                          if(empty($row['userImg'])){
                    
                            echo " <img class='img-responsive center-block' src='admin/Upload/Images/" . $item['Image'] . "' />";
                    
                            } 
                        echo '<div class="caption">';   
                            echo '<h3><a href="items.php?itemid=' . $item['item_ID'] . '&name=' . str_replace(' ','-',$item['Name']) . ' ">' . $item['Name'] . '</a></h3>';
                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
    } } else {

        echo '<div class="alert alert-danger">لا يوجد منتجات في هذا القسم</div>';
    }
    
    ?>
     
        
    </div>
        </div>
</div>

<?php include $tpl . 'footer.php'; ?>