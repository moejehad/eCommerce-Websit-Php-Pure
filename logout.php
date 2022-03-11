<?php 

session_start();

session_unset($_SESSION['user']);

header('Location: index.php');

exit();


?>