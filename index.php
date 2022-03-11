<?php 

ob_start();

session_start();

$pageTitle = 'Yellow Store  - المتجر الأصفر ';

include "init.php";

include "account.php";

include "YellowStore.php";

include "whyYel.php";

include "start.php";

include $tpl . 'footer.php';

ob_end_flush();

?>