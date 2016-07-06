<?php

include (__DIR__ . '/../include/include.php');

$limit  = 25;
$page   = 0;

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}

$offset = $page * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `user_id`,
               `user_last_visit`,
               `user_login`
        FROM `user`
        WHERE `user_id`!='0'
        AND `user_activation`='1'
        ORDER BY `user_last_visit` DESC
        LIMIT $offset, $limit";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count`";
$count = $mysqli->query($sql);
$count = $count->fetch_all(1);
$count = $count[0]['count'];

$count_pagination   = ceil($count/$limit);
$start_pagination   = $page - 4;
$end_pagination     = $page + 5;

if (0 > $start_pagination)
{
    $start_pagination = 0;
}
elseif ($count_pagination < $start_pagination)
{
    $start_pagination = $count_pagination - 4;
}

if ($count_pagination < $end_pagination)
{
    $end_pagination = $count_pagination;
}

include (__DIR__ . '/../view/admin_main.php');