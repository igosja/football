<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $num_get = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (!isset($authorization_team_id))
{
    if (isset($_POST['data']))
    {
        $team_id = (int) $_POST['data']['team'];

        $sql = "SELECT `team_name`,
                       `team_user_id`
                FROM `team`
                WHERE `team_id`='$team_id'
                LIMIT 1";
        $team_sql = $mysqli->query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $user_id = $team_array[0]['team_user_id'];

        if (0 == $user_id)
        {
            $sql = "UPDATE `team`
                    SET `team_user_id`='$authorization_id'
                    WHERE `team_id`='$team_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `standing`
                    SET `standing_user_id`='$authorization_id'
                    WHERE `standing_team_id`='$team_id'
                    AND `standing_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `cupparticipant`
                    SET `cupparticipant_user_id`='$authorization_id'
                    WHERE `cupparticipant_team_id`='$team_id'
                    AND `cupparticipant_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "UPDATE `leagueparticipant`
                    SET `leagueparticipant_user_id`='$authorization_id'
                    WHERE `leagueparticipant_team_id`='$team_id'
                    AND `leagueparticipant_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);

            f_igosja_history(1, $authorization_id, 0, $team_id);

            $sql = "UPDATE `user`
                    SET `user_team`=`user_team`+'1'
                    WHERE `user_id`='$user_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $team_name = $team_array[0]['team_name'];

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Вы успешно взяли команду ' . $team_name . ' под управление.';

            redirect('profile_home_home.php');
        }
    }

    $sql = "SELECT `country_id`,
                   `country_name`,
                   `team_finance`,
                   `team_id`,
                   `team_name`,
                   `tournament_id`,
                   `tournament_name`
            FROM `team`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            LEFT JOIN `country`
            ON `country_id`=`city_country_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`team_id`
            LEFT JOIN `tournament`
            ON `standing_tournament_id`=`tournament_id`
            WHERE `team_user_id`='0'
            AND `team_id`!='0'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `team_id` ASC";
    $team_sql = $mysqli->query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $num            = $authorization_id;
    $header_title   = $authorization_login;

    include (__DIR__ . '/view/main.php');
    exit;
}

$sql = "SELECT `game_temperature`,
               `guest`.`team_id` AS `guest_id`,
               `guest`.`team_name` AS `guest_name`,
               `home`.`team_id` AS `home_id`,
               `home`.`team_name` AS `home_name`,
               `shedule_date`,
               `stadium_name`,
               `tournament_id`,
               `tournament_name`,
               `weather_id`,
               `weather_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `team` AS `home`
        ON `home`.`team_id`=`game_home_team_id`
        LEFT JOIN `team` AS `guest`
        ON `guest`.`team_id`=`game_guest_team_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        LEFT JOIN `weather`
        ON `weather_id`=`game_weather_id`
        WHERE `game_played`='0'
        AND (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$next_sql = $mysqli->query($sql);

$next_array = $next_sql->fetch_all(MYSQLI_ASSOC);

if (isset($authorization_country_id))
{
    $sql = "SELECT `game_temperature`,
                   `guest`.`country_id` AS `guest_id`,
                   `guest`.`country_name` AS `guest_country_name`,
                   `home`.`country_id` AS `home_id`,
                   `home`.`country_name` AS `home_country_name`,
                   `shedule_date`,
                   `stadium_name`,
                   `tournament_id`,
                   `tournament_name`,
                   `weather_id`,
                   `weather_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `country` AS `home`
            ON `home`.`country_id`=`game_home_country_id`
            LEFT JOIN `country` AS `guest`
            ON `guest`.`country_id`=`game_guest_country_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            LEFT JOIN `tournament`
            ON `tournament_id`=`game_tournament_id`
            LEFT JOIN `weather`
            ON `weather_id`=`game_weather_id`
            WHERE `game_played`='0'
            AND (`game_home_country_id`='$authorization_country_id'
            OR `game_guest_country_id`='$authorization_country_id')
            ORDER BY `shedule_date` ASC
            LIMIT 1";
    $next_sql = $mysqli->query($sql);

    $next_country_array = $next_sql->fetch_all(MYSQLI_ASSOC);

    $next_array = array_merge($next_array, $next_country_array);

    usort($next_array, 'f_igosja_nearest_game_sort');

    $next_array = array_slice($next_array, 0, 1);
}

$sql = "SELECT `game_home_team_id`,
               IF (`game_home_team_id`='$authorization_team_id', `game_home_score`, `game_guest_score`) AS `home_score`,
               `game_id`,
               IF (`game_home_team_id`='$authorization_team_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$authorization_team_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        AND `game_played`='1'
        ORDER BY `shedule_date` DESC
        LIMIT 5";
$latest_sql = $mysqli->query($sql);

$latest_array = $latest_sql->fetch_all(MYSQLI_ASSOC);

if (isset($authorization_country_id))
{
    $sql = "SELECT `game_home_country_id`,
                   IF (`game_home_country_id`='$authorization_country_id', `game_home_score`, `game_guest_score`) AS `home_score`,
                   `game_id`,
                   IF (`game_home_country_id`='$authorization_country_id', `game_guest_score`, `game_home_score`) AS `guest_score`,
                   `shedule_date`,
                   `country_id`,
                   `country_name`,
                   `tournament_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `country`
            ON IF (`game_home_country_id`='$authorization_country_id', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE (`game_home_country_id`='$authorization_country_id'
            OR `game_guest_country_id`='$authorization_country_id')
            AND `game_played`='1'
            ORDER BY `shedule_date` DESC
            LIMIT 1";
    $latest_sql = $mysqli->query($sql);

    $latest_country_array = $latest_sql->fetch_all(MYSQLI_ASSOC);

    $latest_array = array_merge($latest_array, $latest_country_array);

    usort($latest_array, 'f_igosja_nearest_game_sort');
}

$sql = "SELECT `game_home_team_id`,
               `game_id`,
               `lineupmain_id`,
               `shedule_date`,
               `team_id`,
               `team_name`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `team`
        ON IF (`game_home_team_id`='$authorization_team_id', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `lineupmain`
        ON (`lineupmain_game_id`=`game_id`
        AND `lineupmain_team_id`='$authorization_team_id')
        WHERE (`game_home_team_id`='$authorization_team_id'
        OR `game_guest_team_id`='$authorization_team_id')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 5";
$nearest_sql = $mysqli->query($sql);

$nearest_array = $nearest_sql->fetch_all(MYSQLI_ASSOC);

if (isset($authorization_country_id))
{
    $sql = "SELECT `game_home_country_id`,
                   `game_id`,
                   `lineupmain_id`,
                   `shedule_date`,
                   `country_id`,
                   `country_name`,
                   `tournament_name`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `country`
            ON IF (`game_home_country_id`='$authorization_country_id', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            LEFT JOIN `lineupmain`
            ON (`lineupmain_game_id`=`game_id`
            AND `lineupmain_country_id`='$authorization_country_id')
            WHERE (`game_home_country_id`='$authorization_country_id'
            OR `game_guest_country_id`='$authorization_country_id')
            AND `game_played`='0'
            ORDER BY `shedule_date` ASC
            LIMIT 2";
    $nearest_sql = $mysqli->query($sql);

    $nearest_country_array = $nearest_sql->fetch_all(MYSQLI_ASSOC);

    $nearest_array = array_merge($nearest_array, $nearest_country_array);

    usort($nearest_array, 'f_igosja_nearest_game_sort');
}

$sql = "SELECT `team_id`,
               `team_name`,
               `standing_place`,
               `standing_point`
        FROM `standing`
        LEFT JOIN `team`
        ON `standing_team_id`=`team_id`
        WHERE `standing_tournament_id`=
        (
            SELECT `standing_tournament_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            AND `standing_team_id`='$authorization_team_id'
        )
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `standing_place` ASC";
$standing_sql = $mysqli->query($sql);

$standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statisticteam_full_house`,
               `statisticteam_game`,
               `statisticteam_goal`,
               `statisticteam_pass`,
               `statisticteam_red`,
               ROUND(`statisticteam_visitor`/`statisticteam_game`) AS `statisticteam_visitor`,
               `statisticteam_yellow`,
               `tournament_id`,
               `tournament_name`
        FROM `statisticteam`
        LEFT JOIN `tournament`
        ON `statisticteam_tournament_id`=`tournament_id`
        WHERE `statisticteam_season_id`='$igosja_season_id'
        AND `statisticteam_team_id`='$authorization_team_id'
        AND `tournament_tournamenttype_id`='2'
        LIMIT 1";
$statistic_team_sql = $mysqli->query($sql);

$statistic_team_array = $statistic_team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `best_name`,
               `best_player_id`,
               `best_surname`,
               `game_name`,
               `game_player_id`,
               `game_surname`,
               `name_name` AS `goal_name`,
               `player_id` AS `goal_player_id`,
               `surname_name` AS `goal_surname`,
               `pass_name`,
               `pass_player_id`,
               `pass_surname`,
               `red_name`,
               `red_player_id`,
               `red_surname`,
               `t3`.`statisticplayer_best` AS `statisticplayer_best`,
               `t2`.`statisticplayer_game` AS `statisticplayer_game`,
               `statisticplayer_goal`,
               `t1`.`statisticplayer_pass_scoring` AS `statisticplayer_pass_scoring`,
               `t5`.`statisticplayer_red` AS `statisticplayer_red`,
               `t4`.`statisticplayer_yellow` AS `statisticplayer_yellow`,
               `tournament_id`,
               `tournament_name`,
               `yellow_name`,
               `yellow_player_id`,
               `yellow_surname`
        FROM `statisticplayer` AS `t0`
        LEFT JOIN `tournament`
        ON `statisticplayer_tournament_id`=`tournament_id`
        LEFT JOIN `player`
        ON `player_id`=`statisticplayer_player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN
        (
            SELECT `name_name` AS `pass_name`,
                   `player_id` AS `pass_player_id`,
                   `surname_name` AS `pass_surname`,
                   `statisticplayer_pass_scoring`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            LEFT JOIN `tournament`
            ON `statisticplayer_tournament_id`=`tournament_id`
            LEFT JOIN `player`
            ON `player_id`=`statisticplayer_player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `statisticplayer_team_id`='$authorization_team_id'
            AND `statisticplayer_season_id`='$igosja_season_id'
            ORDER BY `statisticplayer_pass_scoring` DESC
            LIMIT 1
        ) AS `t1`
        ON `t1`.`statisticplayer_team_id`=`t0`.`statisticplayer_team_id`
        LEFT JOIN
        (
            SELECT `name_name` AS `game_name`,
                   `player_id` AS `game_player_id`,
                   `surname_name` AS `game_surname`,
                   `statisticplayer_game`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            LEFT JOIN `tournament`
            ON `statisticplayer_tournament_id`=`tournament_id`
            LEFT JOIN `player`
            ON `player_id`=`statisticplayer_player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `statisticplayer_team_id`='$authorization_team_id'
            AND `statisticplayer_season_id`='$igosja_season_id'
            ORDER BY `statisticplayer_game` DESC
            LIMIT 1
        ) AS `t2`
        ON `t2`.`statisticplayer_team_id`=`t0`.`statisticplayer_team_id`
        LEFT JOIN
        (
            SELECT `name_name` AS `best_name`,
                   `player_id` AS `best_player_id`,
                   `surname_name` AS `best_surname`,
                   `statisticplayer_best`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            LEFT JOIN `tournament`
            ON `statisticplayer_tournament_id`=`tournament_id`
            LEFT JOIN `player`
            ON `player_id`=`statisticplayer_player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `statisticplayer_team_id`='$authorization_team_id'
            AND `statisticplayer_season_id`='$igosja_season_id'
            ORDER BY `statisticplayer_best` DESC
            LIMIT 1
        ) AS `t3`
        ON `t3`.`statisticplayer_team_id`=`t0`.`statisticplayer_team_id`
        LEFT JOIN
        (
            SELECT `name_name` AS `yellow_name`,
                   `player_id` AS `yellow_player_id`,
                   `surname_name` AS `yellow_surname`,
                   `statisticplayer_yellow`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            LEFT JOIN `tournament`
            ON `statisticplayer_tournament_id`=`tournament_id`
            LEFT JOIN `player`
            ON `player_id`=`statisticplayer_player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `statisticplayer_team_id`='$authorization_team_id'
            AND `statisticplayer_season_id`='$igosja_season_id'
            ORDER BY `statisticplayer_yellow` DESC
            LIMIT 1
        ) AS `t4`
        ON `t4`.`statisticplayer_team_id`=`t0`.`statisticplayer_team_id`
        LEFT JOIN
        (
            SELECT `name_name` AS `red_name`,
                   `player_id` AS `red_player_id`,
                   `surname_name` AS `red_surname`,
                   `statisticplayer_red`,
                   `statisticplayer_team_id`
            FROM `statisticplayer`
            LEFT JOIN `tournament`
            ON `statisticplayer_tournament_id`=`tournament_id`
            LEFT JOIN `player`
            ON `player_id`=`statisticplayer_player_id`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            WHERE `statisticplayer_team_id`='$authorization_team_id'
            AND `statisticplayer_season_id`='$igosja_season_id'
            ORDER BY `statisticplayer_red` DESC
            LIMIT 1
        ) AS `t5`
        ON `t5`.`statisticplayer_team_id`=`t0`.`statisticplayer_team_id`
        WHERE `t0`.`statisticplayer_team_id`='$authorization_team_id'
        AND `statisticplayer_season_id`='$igosja_season_id'
        ORDER BY `statisticplayer_goal` DESC
        LIMIT 1";
$statistic_player_sql = $mysqli->query($sql);

$statistic_player_array = $statistic_player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT DATEDIFF(`injury_end_date`,SYSDATE()) AS `day`,
               `injurytype_name`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `injury`
        LEFT JOIN `player`
        ON `injury_player_id`=`player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `injurytype`
        ON `injury_injurytype_id`=`injurytype_id`
        WHERE `injury_end_date`>SYSDATE()
        AND `player_team_id`='$authorization_team_id'
        ORDER BY `injury_id` ASC";
$injury_sql = $mysqli->query($sql);

$injury_array = $injury_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `average_player_salary`,
               `average_staff_salary`,
               `finance_income_attributes` +
               `finance_income_donat` +
               `finance_income_prize` +
               `finance_income_sponsor` +
               `finance_income_subscription` +
               `finance_income_ticket` +
               `finance_income_transfer` +
               `finance_income_tv` +
               `finance_expense_agent` -
               `finance_expense_base` -
               `finance_expense_build` -
               `finance_expense_loan` -
               `finance_expense_penalty` -
               `finance_expense_salary` -
               `finance_expense_scout` -
               `finance_expense_stadium` -
               `finance_expense_tax` -
               `finance_expense_transfer` -
               `finance_expense_transport` AS `profit`,
               `team_finance`,
               `total_player_salary`,
               `total_staff_salary`
        FROM `team`
        LEFT JOIN 
        (
            SELECT ROUND(AVG(`player_salary`)) AS `average_player_salary`,
                   `player_team_id`,
                   SUM(`player_salary`) AS `total_player_salary`
            FROM `player`
            WHERE `player_team_id`='$authorization_team_id'
        ) AS `t1`
        ON `team_id`=`player_team_id`
        LEFT JOIN 
        (
            SELECT ROUND(AVG(`staff_salary`)) AS `average_staff_salary`,
                   SUM(`staff_salary`) AS `total_staff_salary`,
                   `staff_team_id`
            FROM `staff`
            WHERE `staff_team_id`='$authorization_team_id'
        ) AS `t2`
        ON `staff_team_id`=`team_id`
        LEFT JOIN `finance`
        ON `finance_team_id`=`team_id`
        WHERE `team_id`='$authorization_team_id'
        AND `finance_season_id`='$igosja_season_id'
        LIMIT 1";
$finance_sql = $mysqli->query($sql);

$finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `standing_place`,
               `tournament_id`,
               `tournament_name`
        FROM `standing`
        LEFT JOIN `tournament`
        ON `standing_tournament_id`=`tournament_id`
        WHERE `standing_season_id`='$igosja_season_id'
        AND `standing_team_id`='$authorization_team_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
        LIMIT 1";
$tournament_championship_sql = $mysqli->query($sql);

$tournament_championship_array = $tournament_championship_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name`,
               `tournament_id`,
               `tournament_name`
        FROM `cupparticipant`
        LEFT JOIN `tournament`
        ON `cupparticipant_tournament_id`=`tournament_id`
        LEFT JOIN `stage`
        ON `stage_id`=`cupparticipant_out`
        WHERE `cupparticipant_season_id`='$igosja_season_id'
        AND `cupparticipant_team_id`='$authorization_team_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        LIMIT 1";
$tournament_cup_sql = $mysqli->query($sql);

$tournament_cup_array = $tournament_cup_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `stage_name`,
               `tournament_id`,
               `tournament_name`
        FROM `leagueparticipant`
        LEFT JOIN `tournament`
        ON `leagueparticipant_tournament_id`=`tournament_id`
        LEFT JOIN `stage`
        ON `stage_id`=`leagueparticipant_out`
        WHERE `leagueparticipant_season_id`='$igosja_season_id'
        AND `leagueparticipant_team_id`='$authorization_team_id'
        AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
        LIMIT 1";
$tournament_league_sql = $mysqli->query($sql);

$tournament_league_array = $tournament_league_sql->fetch_all(MYSQLI_ASSOC);

if (isset($authorization_country_id))
{
    $sql = "SELECT `worldcup_place`,
                   `tournament_id`,
                   `tournament_name`
            FROM `worldcup`
            LEFT JOIN `tournament`
            ON `worldcup_tournament_id`=`tournament_id`
            WHERE `worldcup_season_id`='$igosja_season_id'
            AND `worldcup_country_id`='$authorization_country_id'
            AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_WORLD_CUP . "'
            LIMIT 1";
    $tournament_worldcup_sql = $mysqli->query($sql);

    $tournament_worldcup_array = $tournament_worldcup_sql->fetch_all(MYSQLI_ASSOC);
}

$num            = $authorization_id;
$header_title   = $authorization_login;

include (__DIR__ . '/view/main.php');