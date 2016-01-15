<?php

include ('../include/include.php');

$sql = "SELECT `gender_id`,
               `gender_name`
        FROM `gender`
        ORDER BY `gender_id` ASC";
$gender_sql = $mysqli->query($sql);

$gender_array = $gender_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('gender_array', $gender_array);

$smarty->display('admin_main.html');