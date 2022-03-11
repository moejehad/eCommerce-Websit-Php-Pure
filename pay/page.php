<?php 

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;


if($do == 'Manage'){
    
    echo 'Welcome to Manage categoy page';
    echo '<a href="page.php?do=Add">Add new categoy + </a>';
    
} elseif ($do == 'Add'){
    
    echo 'Welcome to Add categoy page';
    
} elseif($do == 'Insert'){
    
     echo 'Welcome to Insert categoy page';
}

else {
    
    echo 'error';
}

?>