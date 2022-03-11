<?php 

/* */ 

  function genratnewstring($len = 10){
        
        global $con; 


        $resetpass = "salfkjlkasjflknalskfnlsafsdfsdfsdf566265652";
        $resetpass = str_shuffle($resetpass);
        $resetpass = substr($resetpass , 0 , 10); 

        return $resetpass;
    
    
}

/* all */ 

  function getAllfrom($tableName, $orderBy, $where = NULL){
    

    global $con; 
    
    $sql = $where == NULL ? '' : $where;
      
    $getAll = $con->prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC");
    
    $getAll->execute();
    
    $all = $getAll->fetchAll();
    
    return $all;
    
    
}

/* */ 

  function getCat(){
    

    global $con; 
    
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");
    
    $getCat->execute();
    
    $cats = $getCat->fetchAll();
    
    return $cats;
    
    
}


/* */

  function checkUserStatus($user){
    
    global $con; 
    
    $stmtx = $con->prepare("SELECT
        Username,RegStatus 
        FROM 
        users 
        WHERE Username = ? 
        AND 
        RegStatus = 0 ");
    
    $stmtx->execute(array($user));
        
    $status = $stmtx->rowCount();
    
    return $status;
}

/* */

function getItems($where, $value, $approve = NULL){
    
    global $con; 
    
    $sql = $approve == NULL ? 'AND Approve = 1' : ' ';
    
    $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY item_ID DESC");
    
    $getItems->execute(array($value));
    
    $items = $getItems->fetchAll();
    
    return $items;
    
    
}

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

function countMsg($item, $table , $name , $user ){
    
    
        global $con; 
    
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE $name Like '%$user%' ");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    
    
}


/* */


/* */

function countMsgRd($item, $table , $name , $user ){
    
    
        global $con; 
    
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE $name Like '%$user%' AND status = 'لم تقرأ بعد' ");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    
    
}


/* */

/* */

function countNotify($item, $table , $name , $user ){
    
    
        global $con; 
    
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE $name Like '%$user%' AND notiStatus = 'unread' ");
        $stmt2->execute();

        return $stmt2->fetchColumn();
    
    
}


/* */

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

