<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];

    setcookie('referal', $num_get, time() + 60*60*24*7);

    redirect('index.php');
}

$sql = "SELECT `shedule_date`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `shedule`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        WHERE `shedule_date`<CURDATE()
        ORDER BY `shedule_id` DESC
        LIMIT 3";
$shedule_sql = $mysqli->query($sql);

$shedule_array_last = $shedule_sql->fetch_all(1);

$sql = "SELECT `shedule_date`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `shedule`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        WHERE `shedule_date`>=CURDATE()
        ORDER BY `shedule_id` ASC
        LIMIT 7";
$shedule_sql = $mysqli->query($sql);

$shedule_array_nearest = $shedule_sql->fetch_all(1);

$shedule_array = array_merge($shedule_array_last, $shedule_array_nearest);

usort($shedule_array, 'f_igosja_nearest_game_sort');

$social_array = f_igosja_social_array();

include (__DIR__ . '/view/main.php');