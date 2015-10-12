<?php

include ('../include/include.php');

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('horizontalmenuchapter_array', $horizontalmenuchapter_array);

$smarty->display('admin_main.html');