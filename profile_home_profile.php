<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_user_id))
{
    $num_get = $authorization_user_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `country_id`,
               `country_name`,
               `formation_name`,
               `gamemood_name`,
               `gamestyle_name`,
               `statisticuser_draw`,
               `statisticuser_game`,
               `statisticuser_loose`,
               `statisticuser_pass`,
               `statisticuser_score`,
               `statisticuser_win`,
               `user_reputation`
        FROM `user`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        LEFT JOIN 
        (
            SELECT SUM(`statisticuser_draw`) AS `statisticuser_draw`,
                   SUM(`statisticuser_game`) AS `statisticuser_game`,
                   SUM(`statisticuser_loose`) AS `statisticuser_loose`,
                   SUM(`statisticuser_pass`) AS `statisticuser_pass`,
                   SUM(`statisticuser_score`) AS `statisticuser_score`,
                   `statisticuser_user_id`,
                   SUM(`statisticuser_win`) AS `statisticuser_win`
            FROM `statisticuser`
            WHERE `statisticuser_user_id`='$num_get'
        ) AS `t0`
        ON `statisticuser_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT `gamestyle_name`,
                   `usergamestyle_user_id`
            FROM `usergamestyle`
            LEFT JOIN `gamestyle`
            ON `gamestyle_id`=`usergamestyle_gamestyle_id`
            WHERE `usergamestyle_user_id`='$num_get'
            ORDER BY `usergamestyle_value` DESC
            LIMIT 1
        ) AS `t1`
        ON `usergamestyle_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT `gamemood_name`,
                   `usergamemood_user_id`
            FROM `usergamemood`
            LEFT JOIN `gamemood`
            ON `gamemood_id`=`usergamemood_gamemood_id`
            WHERE `usergamemood_user_id`='$num_get'
            ORDER BY `usergamemood_value` DESC
            LIMIT 1
        ) AS `t2`
        ON `usergamemood_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT `formation_name`,
                   `userformation_user_id`
            FROM `userformation`
            LEFT JOIN `formation`
            ON `formation_id`=`userformation_formation_id`
            WHERE `userformation_user_id`='$num_get'
            ORDER BY `userformation_value` DESC
            LIMIT 1
        ) AS `t3`
        ON `userformation_user_id`=`user_id`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
               `history_season_id`,
               `team_id`,
               `team_name`
        FROM `history`
        LEFT JOIN `team`
        ON `history_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `history_historytext_id`='1'
        AND `history_user_id`='$num_get'
        ORDER BY `history_id` ASC";
$career_sql = $mysqli->query($sql);

$count_career = $career_sql->num_rows;
$career_array = $career_sql->fetch_all(1);

$num                = $authorization_user_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. ?????????????? ??????????????????. ' . $seo_title;
$seo_description    = $header_title . '. ?????????????? ??????????????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ?????????????? ??????????????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');