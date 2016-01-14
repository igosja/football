<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `average_mark`,
               `count_game`,
               `count_penalty`,
               `count_red`,
               `count_yellow`,
               `country_id`,
               `country_name`,
               `name_name`,
               `surname_name`,
               `referee_age`,
               `referee_reputation`
        FROM `referee`
        LEFT JOIN `name`
        ON `name_id`=`referee_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`referee_surname_id`
        LEFT JOIN `country`
        ON `country_id`=`referee_country_id`
        LEFT JOIN
        (
            SELECT ROUND(SUM(`statisticreferee_mark`)/SUM(`statisticreferee_game`),2) AS `average_mark`,
                   SUM(`statisticreferee_game`) AS `count_game`,
                   SUM(`statisticreferee_penalty`) AS `count_penalty`,
                   SUM(`statisticreferee_red`) AS `count_red`,
                   SUM(`statisticreferee_yellow`) AS `count_yellow`,
                   `statisticreferee_referee_id`
            FROM `statisticreferee`
            WHERE `statisticreferee_referee_id`='$get_num'
        ) AS `t1`
        ON `statisticreferee_referee_id`=`referee_id`
        WHERE `referee_id`='$get_num'";
$referee_sql = $mysqli->query($sql);

$count_referee = $referee_sql->num_rows;

if (0 == $count_referee)
{
    $smarty->display('wrong_page.html');

    exit;
}

$referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

$referee_name    = $referee_array[0]['name_name'];
$referee_surname = $referee_array[0]['surname_name'];
$header_2_title  = $referee_name . ' ' . $referee_surname;

$sql = "SELECT `game_guest_team_id`,
               `game_guest_score`,
               `game_home_team_id`,
               `game_home_score`,
               `game_id`,
               `game_guest_penalty`+`game_home_penalty` AS `game_penalty`,
               `game_guest_red`+`game_home_red` AS `game_red`,
               `game_referee_mark`,
               `game_guest_yellow`+`game_home_yellow` AS `game_yellow`,
               `t2`.`team_name` AS `guest_team_name`,
               `t1`.`team_name` AS `home_team_name`,
               `shedule_date`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        LEFT JOIN `team` AS `t1`
        ON `t1`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `t2`
        ON `t2`.`team_id`=`game_guest_team_id`
        WHERE `game_referee_id`='$get_num'
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC, `game_id` DESC
        LIMIT 10";
$game_sql = $mysqli->query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('header_title', $header_2_title);
$smarty->assign('num', $get_num);
$smarty->assign('referee_array', $referee_array);
$smarty->assign('game_array', $game_array);

$smarty->display('main.html');