<?php 
    
try {

    // Find out how many items are in the table
    $total = $con->query('
        SELECT
            COUNT(*)
        FROM
            items
    ')->fetchColumn();

    // How many items to list per page
    $limit = 20 ;

    // How many pages will there be
    $pages = ceil($total / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link


    // Prepare the paged query
    
    
    $stmt = $con->prepare("
        SELECT
            *
        FROM
            items
        ORDER BY
            item_ID DESC
        LIMIT
            :limit
        OFFSET
            :offset
    ");

    
    // Bind the query params
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?

} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}
    
    ?>
<div class="prod col-md-12">
<h1 class="title-index pull-right col-md-6"><i class="fa fa-cart-arrow-down"></i> آخر المنتجات</h1>

<select onchange="location = this.value;" class="form-control nav-header" name="category" style="float:  right;font: normal normal 15px sky-bold, Fontawesome;" required>
        <option value="categories.php?pageid='<?php echo $cat['ID'] ?>'&name='<?php echo str_replace(' ','-',$cat['Name']) ?>">الأقسام</option>
            <?php 
                $cats = getAllfrom('categories','ID');
                foreach ($cats as $cat){
            
                if($cat['parent'] < 1){
                   echo "<option value='categories.php?pageid=" . $cat['ID'] .  "&name=" .str_replace(' ','-',$cat['Name']) .  " '>" . $cat['Name'] . "</option>";
                }
                }
        
            ?>
</select>
    
<div class="search-form col-md-6">
    <form class="pull-left " action="search.php" method="GET">
        <input type="text" name="search" placeholder=" هل تبحث عن منتج ؟" autocomplete="off" />
        <i class="fa fa-search"></i>
    </form>
</div>
    
    
<?php 
$subcat = getAllfrom("categories", "ID", " WHERE parent = 0 ");
    foreach($subcat as $scat){
        echo '<div class="scatg">';
            echo '<ul class="subcat">';    
            echo "<li><a href='categories.php?pageid=" . $scat['ID'] .  "&name=" .str_replace(' ','-',$scat['Name']) .  "'  >" . $scat['Name'] . "</a></li>";
            echo '</ul>';
        echo '</div>';
    }
?>
    
</div>

   <div class="row items-list " dir="rtl">
        <div class="row">
            <?php 
            
            
                if ($stmt->rowCount() > 0) {

                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        
                    $iterator = new IteratorIterator($stmt);


                    foreach ($iterator as $row) {
                                                    
                            if($row['Approve'] > 0){
                                
                    
                        echo '<div class="col-md-3 item">';
                            echo '<div class="thumbnail item-box">';              

                                if(! empty($row['Minus'])){
                                    
                                 echo '<span class="price-tag">' . $row['Minus'] . ' ₪ </span>';
                                 echo '<span class="price-tag-minus"> ' . $row['Price'] . ' ₪ </span>';
                                    
                                }else {
                                    
                                    echo '<span class="price-tag">' . $row['Price'] . ' ₪ </span>';
                                }
                                    
                                if(empty($row['userImg'])){

                                echo " <img class='img-responsive center-block' src='admin/Upload/Images/" . $row['Image'] . "' />";

                                } 
                                    
                                echo '<div class="caption">';   
                                    
                                    echo '<h3><a href="items.php?itemid=' . $row['item_ID'] . '&name=' . str_replace(' ','-',$row['Name']) . ' ">' . $row['Name'] . '</a></h3>';

                                echo '<div class="date">' . $row['Add_Date'] . '</div>';
                                
                                echo '</div>';
                            echo '</div>';  
                                
                                }


                        echo '</div>';
                
                        
            }    } else {
        echo '<div class="alert alert-danger">لا يوجد أي منتج</div>';
    }

            ?>
            </div>
    <?php 
                    
    $prevlink = ($page > 1) ? 
        '<a class="btn btn-primary" href="?page=' . ($page - 1) . '" title="prev"><i class="fa fa-angle-double-right"></i> السابق </a>' 
        : 
            
        '<span class="disabled btn btn-primary"><i class="fa fa-angle-double-right"></i>  السابق  </span>';

    $nextlink = ($page < $pages) ? 
        '<a class="btn btn-primary" href="?page=' . ($page + 1) . '" title="next">  التالي  <i class="fa fa-angle-double-left"></i></a>'
        : 
        '<span class="disabled btn btn-primary"> التالي  <i class="fa fa-angle-double-left"></i></span> ';

    echo '<div id="paging"><p>', $prevlink, '  ', $nextlink, ' </p></div>';
       
       
    ?>
    </div> 
