<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `average_mark`,
               `count_game`,
               `count_goal`,
               `count_pass`,
               `name_name`,
               `player_id`,
               `rent_end_date`,
               `rent_price`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `rent_team_id`=`team_id`
        LEFT JOIN
        (
            SELECT ROUND(SUM(`statisticplayer_mark`)/SUM(`statisticplayer_game`),2) AS `average_mark`,
                   SUM(`statisticplayer_game`) AS `count_game`,
                   SUM(`statisticplayer_goal`) AS `count_goal`,
                   SUM(`statisticplayer_pass_scoring`) AS `count_pass`,
                   `statisticplayer_player_id`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            GROUP BY `statisticplayer_player_id`, `statisticplayer_team_id`
        ) AS `t1`
        ON (`statisticplayer_player_id`=`player_id`
        AND `statisticplayer_team_id`=`team_id`)
        WHERE `player_team_id`='$get_num'
        AND TO_DAYS(`rent_end_date`)>=TO_DAYS(SYSDATE())
        ORDER BY `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');