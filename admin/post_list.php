<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `staffpost_id`, `staffpost_name`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$post_sql = $mysqli->query($sql);

$post_array = $post_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('post_array', $post_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');