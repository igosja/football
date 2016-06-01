<?php

include (__DIR__ . '/../include/include.php');

$limit  = 100;
$page   = 0;

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}

$offset = $page * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `debug_sql`,
               `debug_time`
        FROM `debug`
        ORDER BY `debug_id`
        LIMIT $offset, $limit";
$debug_sql = $mysqli->query($sql);

$debug_array = $debug_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_debug`";
$count_debug = $mysqli->query($sql);
$count_debug = $count_debug->fetch_all(1);
$count_debug = $count_debug[0]['count_debug'];

$sql = "SELECT SUM(`debug_time`) AS `time`
        FROM `debug`";
$time_sql = $mysqli->query($sql);

$time_array = $time_sql->fetch_all(1);

$count_pagination   = ceil($count_debug/$limit);
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