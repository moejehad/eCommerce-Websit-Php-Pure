<?php 



/* */

function getTitle(){
    
    global $pageTitle ; 
    
    if(isset($pageTitle)){
        
        echo $pageTitle;
        
    }else {
        
        echo 'Default';
    }
}


/* */

function redirectHome($theMsg, $url = null, $seconds = 3){
    
    if($url === null){
        
        $url = 'index.php';
    }else {
        
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
       
    }
    echo $theMsg;
    
    echo "<div class='alert alert-info'>سيتم تحويلك بعد $seconds ثواني</div>";
    
    header("refresh:$seconds;url=$url");
    
    exit();
}


/*  */ 


function checkItem($select, $from, $value) {
    
    global $con;
    
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
        
    return $count;
}


/* */ 


function countItems($item, $table){
    
    
        global $con; 
    
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    
    
}

/* */


function getLatest($select, $table, $order, $limit = 5){
    

    global $con; 
    
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    
    $getStmt->execute();
    
    $rows = $getStmt->fetchAll();
    
    return $rows;
    
    
}


    
    
    
    
?>

