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
elseif (isset($_GET['count_vote']))
{
    $sql = "SELECT COUNT(`vote_id`) AS `count`
            FROM `vote`
            WHERE `vote_view`='0'";
    $vote_sql = $mysqli->query($sql);

    $vote_array = $vote_sql->fetch_all(1);
    $count_vote = $vote_array[0]['count'];

    $json_data['count_vote'] = $count_vote;
}

print json_encode($json_data);