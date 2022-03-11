<?php 

session_start();

$pageTitle = str_replace('-',' ',$_GET['name']);

include "inti.php";

?>


<div class="container">
    
        <?php 
        
        $subcat = getAllfrom("categories", "ID", " WHERE parent = {$_GET['pageid']} ");
        foreach($subcat as $scat){
        echo '<div class="scatg">';
        echo '<ul class="subcat">';    
        echo "<li>
<a href='subcat.php?pageid=" . $scat['ID'] .  "&name=" .str_replace(' ','-',$scat['Name']) .  "'  >" . $scat['Name'] . "</a></li>";
        echo '</ul>';
        echo '</div>';
        }
        
    
        if(isset($scat)){
            
            echo '<br/><br/><br/>';
        }
    ?>
    
    <div class="posts">
    <div class="row">
    <?php 
    
    if(! empty ( getItems('Cat_ID', $_GET['pageid'] , 1)  )){
        
        foreach(getItems('Cat_ID', $_GET['pageid'] , 1 . $_GET['name']) as $item){
        
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

        echo '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> لا يوجد منتجات في هذا القسم</div>';
    }
    
    ?>
    </div>
        </div>
</div>

<?php include $tpl . 'footer.php'; ?>