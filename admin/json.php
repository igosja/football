<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$json_data = array();

if (isset($_GET['count_support']))
{
    $sql = "SELECT COUNT(`inbox_id`) AS `count`
            FROM `inbox`
            WHERE `inbox_support`='1'
            AND `inbox_user_id`='0'
            AND `inbox_read`='0'";
    $support_sql = $mysqli->query($sql);

    $support_array = $support_sql->fetch_all(1);
    $count_support = $support_array[0]['count'];

    $json_data['count_support'] = $count_support;
}

print json_encode($json_data);