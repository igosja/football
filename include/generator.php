<?php

$start_time = microtime(true);

ini_set('memory_limit', '2048M');
set_time_limit(0);
date_default_timezone_set('Europe/Moscow');

include (__DIR__ . '/constants.php');
include (__DIR__ . '/database.php');

$file_list = scandir(__DIR__ . '/../generator/function');
$file_list = array_slice($file_list, 2);

foreach ($file_list as $item)
{
    include(__DIR__ . '/../generator/function/' . $item);
}
$count_sql  = 0;

//$sql = "TRUNCATE `debug`";
//$mysqli->query($sql);

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$igosja_season_id = $season_array[0]['season_id'];