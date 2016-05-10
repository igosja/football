<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `game_id`,
               `game_home_team_id`,
               `game_guest_team_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `shedule_date`='2016-05-09'
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_game; $i++)
{
    $game_id    = $game_array[$i]['game_id'];
    $home_id    = $game_array[$i]['game_home_team_id'];
    $guest_id   = $game_array[$i]['game_guest_team_id'];

    $sql = "SELECT COUNT(`lineup_id`) AS `count`
            FROM `lineup`
            WHERE `lineup_team_id`='$home_id'
            AND `lineup_game_id`='$game_id'
            AND `lineup_position_id`!='0'";
    $lineup_sql = $mysqli->query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    $count_home = $lineup_array[0]['count'];

    $sql = "SELECT COUNT(`lineup_id`) AS `count`
            FROM `lineup`
            WHERE `lineup_team_id`='$guest_id'
            AND `lineup_game_id`='$game_id'
            AND `lineup_position_id`!='0'";
    $lineup_sql = $mysqli->query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    $count_guest = $lineup_array[0]['count'];

    if (18 != $count_home || 18 != $count_guest)
    {
        print $game_id . '<br/>';
        print $count_home . '<br/>';
        print $count_guest . '<br/>';
    }
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';