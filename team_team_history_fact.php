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

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `cheap_salary`,
               `cheap_id`,
               `cheap_name`,
               `cheap_surname`,
               `count_country`,
               `count_native`,
               `expensive_salary`,
               `expensive_id`,
               `expensive_name`,
               `expensive_surname`,
               `height_height`,
               `heavy_weight`,
               `heavy_id`,
               `heavy_name`,
               `heavy_surname`,
               `light_weight`,
               `light_id`,
               `light_name`,
               `light_surname`,
               `player_height` AS `low_height`,
               `player_id` AS `low_id`,
               `name_name` AS `low_name`,
               `surname_name` AS `low_surname`,
               `salary_salary`,
               `tall_height`,
               `tall_id`,
               `tall_name`,
               `tall_surname`,
               `weight_weight`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `player_height` AS `tall_height`,
                   `player_id` AS `tall_id`,
                   `name_name` AS `tall_name`,
                   `surname_name` AS `tall_surname`,
                   `player_team_id` AS `tall_team_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            WHERE `player_team_id`='$get_num'
            ORDER BY `player_height` DESC
            LIMIT 1
        ) AS `t1`
        ON `player_team_id`=`tall_team_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_height`),0) AS `height_height`,
                   `player_team_id` AS `height_team_id`
            FROM `player`
            WHERE `player_team_id`='$get_num'
        ) AS `t2`
        ON `player_team_id`=`height_team_id`
        LEFT JOIN
        (
            SELECT `player_weight` AS `light_weight`,
                   `player_id` AS `light_id`,
                   `name_name` AS `light_name`,
                   `surname_name` AS `light_surname`,
                   `player_team_id` AS `light_team_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            WHERE `player_team_id`='$get_num'
            ORDER BY `player_weight` ASC
            LIMIT 1
        ) AS `t3`
        ON `player_team_id`=`light_team_id`
        LEFT JOIN
        (
            SELECT `player_weight` AS `heavy_weight`,
                   `player_id` AS `heavy_id`,
                   `name_name` AS `heavy_name`,
                   `surname_name` AS `heavy_surname`,
                   `player_team_id` AS `heavy_team_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            WHERE `player_team_id`='$get_num'
            ORDER BY `player_weight` DESC
            LIMIT 1
        ) AS `t4`
        ON `player_team_id`=`heavy_team_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_weight`),0) AS `weight_weight`,
                   `player_team_id` AS `weight_team_id`
            FROM `player`
            WHERE `player_team_id`='$get_num'
        ) AS `t5`
        ON `player_team_id`=`weight_team_id`
        LEFT JOIN
        (
            SELECT `player_salary` AS `cheap_salary`,
                   `player_id` AS `cheap_id`,
                   `name_name` AS `cheap_name`,
                   `surname_name` AS `cheap_surname`,
                   `player_team_id` AS `cheap_team_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            WHERE `player_team_id`='$get_num'
            ORDER BY `player_salary` ASC
            LIMIT 1
        ) AS `t6`
        ON `player_team_id`=`cheap_team_id`
        LEFT JOIN
        (
            SELECT `player_salary` AS `expensive_salary`,
                   `player_id` AS `expensive_id`,
                   `name_name` AS `expensive_name`,
                   `surname_name` AS `expensive_surname`,
                   `player_team_id` AS `expensive_team_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            WHERE `player_team_id`='$get_num'
            ORDER BY `player_salary` DESC
            LIMIT 1
        ) AS `t7`
        ON `player_team_id`=`expensive_team_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_salary`),0) AS `salary_salary`,
                   `player_team_id` AS `salary_team_id`
            FROM `player`
            WHERE `player_team_id`='$get_num'
        ) AS `t8`
        ON `player_team_id`=`salary_team_id`
        LEFT JOIN
        (
            SELECT COUNT(`player_id`) AS `count_native`,
                   `player_team_id` AS `native_team_id`
            FROM `player`
            WHERE `player_team_id`='$get_num'
            AND `player_country_id`=
            (
                SELECT `city_country_id`
                FROM `team`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$get_num'
            )
        ) AS `t9`
        ON `player_team_id`=`native_team_id`
        LEFT JOIN
        (
            SELECT COUNT(DISTINCT `player_country_id`) AS `count_country`,
                   `player_team_id` AS `country_team_id`
            FROM `player`
            WHERE `player_team_id`='$get_num'
        ) AS `t10`
        ON `player_team_id`=`country_team_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `player_height` ASC
        LIMIT 1";
$team_fact_sql = $mysqli->query($sql);

$team_fact_array = $team_fact_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `tournament_id`,
               `tournament_name`
        FROM `tournament`
        LEFT JOIN `standing`
        ON `standing_tournament_id`=`tournament_id`
        WHERE `tournament_tournamenttype_id`='2'
        AND `standing_season_id`='$igosja_season_id'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_id = $tournament_array[0]['tournament_id'];

$sql = "SELECT `cheap_salary`,
               `cheap_id`,
               `cheap_name`,
               `cheap_surname`,
               `count_country`,
               `count_native`,
               `expensive_salary`,
               `expensive_id`,
               `expensive_name`,
               `expensive_surname`,
               `height_height`,
               `heavy_weight`,
               `heavy_id`,
               `heavy_name`,
               `heavy_surname`,
               `light_weight`,
               `light_id`,
               `light_name`,
               `light_surname`,
               `player_height` AS `low_height`,
               `player_id` AS `low_id`,
               `name_name` AS `low_name`,
               `surname_name` AS `low_surname`,
               `salary_salary`,
               `tall_height`,
               `tall_id`,
               `tall_name`,
               `tall_surname`,
               `weight_weight`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `standing`
        ON `standing_team_id`=`player_team_id`
        LEFT JOIN
        (
            SELECT `player_height` AS `tall_height`,
                   `player_id` AS `tall_id`,
                   `name_name` AS `tall_name`,
                   `surname_name` AS `tall_surname`,
                   `standing_tournament_id` AS `tall_tournament_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `player_height` DESC
            LIMIT 1
        ) AS `t1`
        ON `standing_tournament_id`=`tall_tournament_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_height`),0) AS `height_height`,
                   `standing_tournament_id` AS `height_tournament_id`
            FROM `player`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
        ) AS `t2`
        ON `standing_tournament_id`=`height_tournament_id`
        LEFT JOIN
        (
            SELECT `player_weight` AS `light_weight`,
                   `player_id` AS `light_id`,
                   `name_name` AS `light_name`,
                   `surname_name` AS `light_surname`,
                   `standing_tournament_id` AS `light_tournament_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `player_weight` ASC
            LIMIT 1
        ) AS `t3`
        ON `standing_tournament_id`=`light_tournament_id`
        LEFT JOIN
        (
            SELECT `player_weight` AS `heavy_weight`,
                   `player_id` AS `heavy_id`,
                   `name_name` AS `heavy_name`,
                   `surname_name` AS `heavy_surname`,
                   `standing_tournament_id` AS `heavy_tournament_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `player_weight` DESC
            LIMIT 1
        ) AS `t4`
        ON `standing_tournament_id`=`heavy_tournament_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_weight`),0) AS `weight_weight`,
                   `standing_tournament_id` AS `weight_tournament_id`
            FROM `player`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
        ) AS `t5`
        ON `standing_tournament_id`=`weight_tournament_id`
        LEFT JOIN
        (
            SELECT `player_salary` AS `cheap_salary`,
                   `player_id` AS `cheap_id`,
                   `name_name` AS `cheap_name`,
                   `surname_name` AS `cheap_surname`,
                   `standing_tournament_id` AS `cheap_tournament_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `player_salary` ASC
            LIMIT 1
        ) AS `t6`
        ON `standing_tournament_id`=`cheap_tournament_id`
        LEFT JOIN
        (
            SELECT `player_salary` AS `expensive_salary`,
                   `player_id` AS `expensive_id`,
                   `name_name` AS `expensive_name`,
                   `surname_name` AS `expensive_surname`,
                   `standing_tournament_id` AS `expensive_tournament_id`
            FROM `player`
            LEFT JOIN `name`
            ON `name_id`=`player_name_id`
            LEFT JOIN `surname`
            ON `surname_id`=`player_surname_id`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY `player_salary` DESC
            LIMIT 1
        ) AS `t7`
        ON `standing_tournament_id`=`expensive_tournament_id`
        LEFT JOIN
        (
            SELECT ROUND(AVG(`player_salary`),0) AS `salary_salary`,
                   `standing_tournament_id` AS `salary_tournament_id`
            FROM `player`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
        ) AS `t8`
        ON `standing_tournament_id`=`salary_tournament_id`
        LEFT JOIN
        (
            SELECT COUNT(`player_id`) AS `count_native`,
                   `standing_tournament_id` AS `native_tournament_id`
            FROM `player`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
            AND `player_country_id`=
            (
                SELECT `city_country_id`
                FROM `team`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$get_num'
            )
        ) AS `t9`
        ON `standing_tournament_id`=`native_tournament_id`
        LEFT JOIN
        (
            SELECT COUNT(DISTINCT `player_country_id`) AS `count_country`,
                   `standing_tournament_id` AS `country_tournament_id`
            FROM `player`
            LEFT JOIN `standing`
            ON `standing_team_id`=`player_team_id`
            WHERE `standing_tournament_id`='$tournament_id'
            AND `standing_season_id`='$igosja_season_id'
        ) AS `t10`
        ON `standing_tournament_id`=`country_tournament_id`
        WHERE `standing_tournament_id`='$tournament_id'
        AND `standing_season_id`='$igosja_season_id'
        ORDER BY `player_height` ASC
        LIMIT 1";
$tournament_fact_sql = $mysqli->query($sql);

$tournament_fact_array = $tournament_fact_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('team_name', $team_name);
$smarty->assign('team_fact_array', $team_fact_array);
$smarty->assign('tournament_array', $tournament_array);
$smarty->assign('tournament_fact_array', $tournament_fact_array);

$smarty->display('main.html');