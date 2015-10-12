<?php

include ('../include/include.php');

$sql = "SELECT `staffpost_id`, `staffpost_name`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$post_sql = $mysqli->query($sql);

$post_array = $post_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('post_array', $post_array);

$smarty->display('admin_main.html');