<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `site_status`
        FROM `site`
        WHERE `site_id`='1'
        LIMIT 1";
$site_sql = $mysqli->query($sql);

$site_array = $site_sql->fetch_all(1);

print '<pre>';
print_r($site_array);
exit;

$sql = "SELECT `game_id`,
               `game_guest_team_id`,
               `game_home_team_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `shedule_date`=CURDATE()
        AND `game_played`='0'
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(1);

for ($i=0; $i<$count_game; $i++)
{
    $game_id        = $game_array[$i]['game_id'];
    $home_team_id   = $game_array[$i]['game_home_team_id'];
    $guest_team_id  = $game_array[$i]['game_guest_team_id'];

    $sql = "SELECT `event_eventtype_id`,
                   `event_minute`
            FROM `event`
            WHERE `event_game_id`='$game_id'
            AND `event_team_id`='$home_team_id'
            ORDER BY `event_minute` ASC";
    $event_sql = $mysqli->query($sql);

    $count_event = $event_sql->num_rows;
    $event_array = $event_sql->fetch_all(1);

    $sql = "SELECT `lineupsubstitution_in`,
                   `lineupsubstitution_lineupcondition_id`,
                   `lineupsubstitution_minute`,
                   `lineupsubstitution_out`
            FROM `lineupsubstitution`
            WHERE `lineupsubstitution_game_id`='$game_id'
            AND `lineupsubstitution_team_id`='$home_team_id'
            ORDER BY `lineupsubstitution_minute` ASC";
    $substitution_sql = $mysqli->query($sql);

    $count_substitution = $substitution_sql->num_rows;
    $substitution_array = $substitution_sql->fetch_all(1);

    for ($j=0; $j<$count_substitution; $j++)
    {
        $minute         = $substitution_array[$j]['lineupsubstitution_minute'];
        $condition_id   = $substitution_array[$j]['lineupsubstitution_minute'];
        $player_in      = $substitution_array[$j]['lineupsubstitution_in'];
        $player_out     = $substitution_array[$j]['lineupsubstitution_out'];
    }
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';