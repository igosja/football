<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT COUNT(`inbox_id`) AS `count`
        FROM `inbox`
        WHERE `inbox_user_id`='-1'
        AND `inbox_read`='0'";
$support_sql = $mysqli->query($sql);

$support_array = $support_sql->fetch_all(MYSQLI_ASSOC);
$count_support = $support_array[0]['count'];

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');