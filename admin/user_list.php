<?php

include ('../include/include.php');

$sql = "SELECT `user_id`, `user_last_visit`, `user_login`
        FROM `user`
        ORDER BY `user_last_visit` DESC";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('user_array', $user_array);

$smarty->display('admin_main.html');