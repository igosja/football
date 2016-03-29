<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `game_first_game_id`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_home_team_id`,
               `game_stage_id`,
               `game_tournament_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `shedule_date`=CURDATE()
        AND `game_played`='1'
        AND `game_first_game_id`!='0'
        ORDER BY `game_id` ASC";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_game; $i++)
{
    $game_id         = $game_array[$i]['game_first_game_id'];
    $home_score      = $game_array[$i]['game_home_score'];
    $home_shoot_out  = $game_array[$i]['game_home_shoot_out'];
    $home_team_id    = $game_array[$i]['game_home_team_id'];
    $guest_score     = $game_array[$i]['game_guest_score'];
    $guest_shoot_out = $game_array[$i]['game_guest_shoot_out'];
    $guest_team_id   = $game_array[$i]['game_guest_team_id'];
    $stage_id        = $game_array[$i]['game_stage_id'];
    $tournament_id   = $game_array[$i]['game_tournament_id'];

    $sql = "SELECT `game_guest_score`,
                   `game_home_score`
            FROM `game`
            WHERE `game_id`='$game_id'
            LIMIT 1";
    $first_game_sql = $mysqli->query($sql);

    $first_game_array = $first_game_sql->fetch_all(MYSQLI_ASSOC);

    $first_home_score  = $first_game_array[0]['game_home_score'];
    $first_guest_score = $first_game_array[0]['game_guest_score'];

    if ($home_score + $home_shoot_out + $first_guest_score > $guest_score + $guest_shoot_out + $first_home_score)
    {
        $looser = $guest_team_id;
    }
    else
    {
        $looser = $home_team_id;
    }
}

print '<pre>';
print_r($looser);
exit;