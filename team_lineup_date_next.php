<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `game_id`,
               `team_id`,
               `team_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$num_get', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        WHERE (`game_home_team_id`='$num_get'
        OR `game_guest_team_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$nearest_game_sql = $mysqli->query($sql);

$count_nearest_game = $nearest_game_sql->num_rows;

if (0 == $count_nearest_game)
{
    include(__DIR__ . '/view/no_game.php');
    exit;
}
$nearest_game_array = $nearest_game_sql->fetch_all(1);

$opponent_id = $nearest_game_array[0]['team_id'];

$sql = "SELECT `game_guest_score`,
               `game_guest_team_id`,
               `t2`.`team_name` AS `game_guest_team_name`,
               `game_home_score`,
               `game_home_team_id`,
               `t1`.`team_name` AS `game_home_team_name`,
               `game_id`,
               `shedule_date`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `team` AS `t1`
        ON `game_home_team_id`=`t1`.`team_id`
        LEFT JOIN `team` AS `t2`
        ON `game_guest_team_id`=`t2`.`team_id`
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE ((`game_home_team_id`='$num_get'
        AND `game_guest_team_id`='$opponent_id')
        OR (`game_guest_team_id`='$num_get'
        AND `game_home_team_id`='$opponent_id'))
        AND `game_played`='1'
        ORDER BY `game_id`";
$game_sql = $mysqli->query($sql);

$game = $game_sql->num_rows;

$game_array = $game_sql->fetch_all(1);

$win    = 0;
$draw   = 0;
$loose  = 0;
$score  = 0;
$pass   = 0;

for ($i=0; $i<$game; $i++)
{
    $team_id     = $game_array[$i]['game_home_team_id'];
    $home_score  = $game_array[$i]['game_home_score'];
    $guest_score = $game_array[$i]['game_guest_score'];

    if ($home_score > $guest_score)
    {
        if ($team_id == $num_get)
        {
            $win++;
        }
        else
        {
            $loose++;
        }
    }
    elseif ($home_score == $guest_score)
    {
        $draw++;
    }
    elseif ($home_score < $guest_score)
    {
        if ($team_id == $num_get)
        {
            $loose++;
        }
        else
        {
            $win++;
        }
    }

    if ($team_id == $num_get)
    {
        $score = $score + $home_score;
        $pass  = $pass + $guest_score;
    }
    else
    {
        $score = $score + $guest_score;
        $pass  = $pass + $home_score;
    }
}

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Следующий соперник. ' . $seo_title;
$seo_description    = $header_title . '. Следующий соперник. ' . $seo_description;
$seo_keywords       = $header_title . ', следующий соперник, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');