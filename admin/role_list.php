<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `role_id`,
               `role_name`,
               `role_short`
        FROM `role`
        ORDER BY `role_id` ASC";
$role_sql = $mysqli->query($sql);

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');