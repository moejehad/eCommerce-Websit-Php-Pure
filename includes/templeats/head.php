<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css" type="text/css" />
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' rel='stylesheet'/>
    <link rel="stylesheet" href="<?php echo $css;?>front.css" type="text/css" />
    <link rel="icon" type="image/png" href="./layout/imgs/YS.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
    <!-- Google fonts start here -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,500,600' rel='stylesheet' type='text/css'/>
	<!-- Google fonts end here -->

</head>
    
    <body>
    
<header class="yelstore">
     <div class="top-menu">
           <div class="container">
                
               <div class="logo pull-right"><a href="index.php"><img src="./layout/imgs/Y-Logo.png" /></a></div>
                      
                <?php 
                              
                    if(isset($_SESSION['user'])){ 
                        
                      
                     echo '<div class="prfo pull-left"><a href="profile.php?user='. $sessionUser .'"><span class=" btn btn-primary"><i class="fa fa-user"></i> ' . $sessionUser . '</span></a></div>';
                        
                     echo "<div class='prfo notifi pull-left'><a href='notifications.php?user=" . $sessionUser . " '>
                     <i class='fa fa-bell-o'></i><span class='counter pull-left'> " . countNotify('notID', 'notifications' , 'notiName', $sessionUser) . "</span></a></div>";
                        
                    echo "<div class='prfo notifi pull-left' ><a href='inbox.php?user=" . $sessionUser . " '>
                     <i class='fa fa-envelope'></i><span class='counter pull-left'> " . countMsgRd('msgID', 'msg' , 'received' , $sessionUser ) . "</span></a></div>";
                        
                       
                    }else{
               
                        echo '<div class="login pull-left " style="padding: 12px 0;"><a href="login.php">
                        <span class="btn btn-primary"><i class="fa fa-user"></i>  تسجيل دخول </span>
                        </a></div>'; }?>
               
                <ul class="navbar-nav pull-left" style="padding: 15px 0;">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">الرئيسية</a>
                  </li>
                    
                <li class="nav-item">
                    <a class="nav-link" href="about.php">عن المنصة</a>
                  </li>
                    
                <li class="nav-item">
                    <a class="nav-link" href="products.php">المنتجات</a>
                  </li>
                    
                <li class="nav-item">
                    <a class="nav-link" href="address.php">نقاط الدفع</a>
                  </li>
                                    
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">تواصل معنا</a>
                  </li>
                    
                </ul>
                                   
                 <select onchange="location = this.value;" class="form-control" name="type" required>
                    <option value="index.php"><a href="index.php">الرئيسية</a></option>
                    <option value="about.php"><a href="about.php">عن المنصة</a></option>
                    <option value="products.php"><a class="nav-link" href="products.php">المنتجات</a></option>
                    <option value="address.php"><a class="nav-link" href="address.php">نقاط الدفع</a></option>
                    <option value="contact.php"><a class="nav-link" href="contact.php">تواصل معنا</a></option>
                </select>  

         </div>
    </div>
    
</header> 