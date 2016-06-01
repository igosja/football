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

$sql = "SELECT `name_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        WHERE `player_id`='$num_get'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `statisticplayer_best`,
               `statisticplayer_foul`,
               `statisticplayer_game`,
               `statisticplayer_goal`,
               ROUND(`statisticplayer_mark`/`statisticplayer_game`,'2') AS `statisticplayer_mark`,
               `statisticplayer_ontarget`,
               ROUND(`statisticplayer_pass_accurate`/`statisticplayer_pass`*'100') AS `statisticplayer_pass_accurate`,
               `statisticplayer_pass_scoring`,
               `statisticplayer_penalty`,
               `statisticplayer_red`,
               `statisticplayer_shot`,
               `statisticplayer_yellow`,
               `tournamenttype_name`
        FROM `statisticplayer`
        LEFT JOIN `tournament`
        ON `tournament_id`=`statisticplayer_tournament_id`
        LEFT JOIN `tournamenttype`
        ON `tournamenttype_id`=`tournament_tournamenttype_id`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `tournament_id`";
$statistic_sql = $mysqli->query($sql);

$statistic_array = $statistic_sql->fetch_all(1);

$sql = "SELECT SUM(`statisticplayer_best`) AS `count_best`,
               SUM(`statisticplayer_foul`) AS `count_foul`,
               SUM(`statisticplayer_game`) AS `count_game`,
               SUM(`statisticplayer_goal`) AS `count_goal`,
               ROUND(SUM(`statisticplayer_mark`)/SUM(`statisticplayer_game`),2) AS `count_mark`,
               SUM(`statisticplayer_ontarget`) AS `count_ontarget`,
               ROUND(SUM(`statisticplayer_pass_accurate`)/SUM(`statisticplayer_pass`)*'100') AS `count_pass_accurate`,
               SUM(`statisticplayer_pass_scoring`) AS `count_pass_scoring`,
               SUM(`statisticplayer_penalty`) AS `count_penalty`,
               SUM(`statisticplayer_penalty_goal`) AS `count_penalty_goal`,
               SUM(`statisticplayer_red`) AS `count_red`,
               SUM(`statisticplayer_shot`) AS `count_shot`,
               SUM(`statisticplayer_yellow`) AS `count_yellow`,
               SUM(`statisticplayer_win`) AS `count_win`
        FROM `statisticplayer`
        WHERE `statisticplayer_player_id`='$num_get'
        AND `statisticplayer_season_id`='$igosja_season_id'";
$total_statistic_sql = $mysqli->query($sql);

$total_statistic_array = $total_statistic_sql->fetch_all(1);

if (0 == $total_statistic_array[0]['count_game'])
{
    $count_total_game = 1;
}
else
{
    $count_total_game = $total_statistic_array[0]['count_game'];
}

if (0 == $total_statistic_array[0]['count_shot'])
{
    $count_total_shot = 1;
}
else
{
    $count_total_shot = $total_statistic_array[0]['count_shot'];
}

if (0 == $total_statistic_array[0]['count_penalty'])
{
    $count_total_penalty = 1;
}
else
{
    $count_total_penalty = $total_statistic_array[0]['count_penalty'];
}

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. Статистика футболиста. ' . $seo_title;
$seo_description    = $header_title . '. Статистика футболиста. ' . $seo_description;
$seo_keywords       = $header_title . ', статистика футболиста, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');