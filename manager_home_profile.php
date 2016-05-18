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

$sql = "SELECT `country_id`,
               `country_name`,
               `formation_name`,
               `gamemood_name`,
               `gamestyle_name`,
               `user_last_visit`,
               `user_login`,
               `user_registration_date`,
               `user_reputation`
        FROM `user`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
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

$count_user = $user_sql->num_rows;

if (0 == $count_user)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

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
$career_array = $career_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`statisticuser_draw`) AS `draw`,
               SUM(`statisticuser_game`) AS `game`,
               SUM(`statisticuser_loose`) AS `loose`,
               SUM(`statisticuser_pass`) AS `pass`,
               SUM(`statisticuser_score`) AS `score`,
               SUM(`statisticuser_win`) AS `win`,
               ROUND((UNIX_TIMESTAMP() - `user_registration_date`) / 24 / 60 / 60) AS `day`
        FROM `statisticuser`
        LEFT JOIN `user`
        ON `user_id`=`statisticuser_user_id`
        WHERE `statisticuser_user_id`='$num_get'";
$career_statistic_sql = $mysqli->query($sql);

$career_statistic_array = $career_statistic_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_buy_max`,
               `user_buy_player`,
               `user_buy_price`,
               `user_national`,
               `user_sell_max`,
               `user_sell_player`,
               `user_sell_price`,
               `user_team`,
               `user_team_time_max`,
               `user_trophy`
        FROM `user`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$summary_sql = $mysqli->query($sql);

$summary_array = $summary_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `standing_place`,
               `standing_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `tournament_id`=`standing_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`standing_team_id`
        WHERE `standing_user_id`='$num_get'
        AND `standing_season_id`<'$igosja_season_id'
        ORDER BY `standing_season_id` DESC";
$championship_sql = $mysqli->query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `cupparticipant_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `cupparticipant`
        LEFT JOIN `tournament`
        ON `tournament_id`=`cupparticipant_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`cupparticipant_team_id`
        LEFT JOIN `stage`
        ON `stage_id`=`cupparticipant_out`
        WHERE `cupparticipant_user_id`='$num_get'
        AND `cupparticipant_season_id`<'$igosja_season_id'
        ORDER BY `cupparticipant_season_id` DESC";
$cup_sql = $mysqli->query($sql);

$cup_array = $cup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name` AS `standing_place`,
               `leagueparticipant_season_id` AS `season_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `leagueparticipant`
        LEFT JOIN `tournament`
        ON `tournament_id`=`leagueparticipant_tournament_id`
        LEFT JOIN `team`
        ON `team_id`=`leagueparticipant_team_id`
        LEFT JOIN `stage`
        ON `stage_id`=`leagueparticipant_out`
        WHERE `leagueparticipant_user_id`='$num_get'
        AND `leagueparticipant_season_id`<'$igosja_season_id'
        ORDER BY `leagueparticipant_season_id` DESC";
$league_sql = $mysqli->query($sql);

$league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `worldcup_place` AS `standing_place`,
               `worldcup_season_id` AS `season_id`,
               `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`
        FROM `worldcup`
        LEFT JOIN `tournament`
        ON `tournament_id`=`worldcup_tournament_id`
        LEFT JOIN `country`
        ON `country_id`=`worldcup_country_id`
        WHERE `worldcup_user_id`='$num_get'
        AND `worldcup_season_id`<'$igosja_season_id'
        ORDER BY `worldcup_season_id` DESC";
$worldcup_sql = $mysqli->query($sql);

$worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

$progress_array = array_merge($championship_array, $worldcup_array, $cup_array, $league_array);

usort($progress_array, 'f_igosja_trophy_sort');

$num                = $num_get;
$header_title       = $user_array[0]['user_login'];
$seo_title          = $header_title . '. Профиль менеджера. ' . $seo_title;
$seo_description    = $header_title . '. Профиль менеджера. ' . $seo_description;
$seo_keywords       = $header_title . ', профиль менеджера, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');