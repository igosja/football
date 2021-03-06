<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['continent_id']))
{
    $continent_id = (int) $_GET['continent_id'];

    $sql = "SELECT SQL_CALC_FOUND_ROWS `continent_id`,
                   `continent_name`,
                   `count_city`,
                   `count_team`,
                   `country_id`,
                   `country_name`
            FROM `country` AS `t1`
            LEFT JOIN `continent` AS `t2`
            ON `t1`.`country_continent_id`=`t2`.`continent_id`
            LEFT JOIN
            (
                SELECT `city_country_id`,
                       COUNT(`city_id`) AS `count_city`
                FROM `city`
                GROUP BY `city_country_id`
            ) AS `t3`
            ON `t1`.`country_id`=`t3`.`city_country_id`
            LEFT JOIN
            (
                SELECT `city_country_id`,
                       COUNT(`team_id`) AS `count_team`
                FROM `city`
                LEFT JOIN `team`
                ON `team_city_id`=`city_id`
                GROUP BY `city_country_id`
            ) AS `t4`
            ON `t1`.`country_id`=`t4`.`city_country_id`
            WHERE `continent_id`='$continent_id'
            ORDER BY `continent_name` ASC, `country_name` ASC";
}
else
{
    $sql = "SELECT SQL_CALC_FOUND_ROWS `continent_id`,
                  `continent_name`,
                  `count_city`,
                  `count_team`,
                  `country_id`,
                  `country_name`
            FROM `country` AS `t1`
            LEFT JOIN `continent` AS `t2`
            ON `t1`.`country_continent_id`=`t2`.`continent_id`
            LEFT JOIN
            (
                SELECT `city_country_id`,
                       COUNT(`city_id`) AS `count_city`
                FROM `city`
                GROUP BY `city_country_id`
            ) AS `t3`
            ON `t1`.`country_id`=`t3`.`city_country_id`
            LEFT JOIN
            (
                SELECT `city_country_id`,
                       COUNT(`team_id`) AS `count_team`
                FROM `city`
                LEFT JOIN `team`
                ON `team_city_id`=`city_id`
                GROUP BY `city_country_id`
            ) AS `t4`
            ON `t1`.`country_id`=`t4`.`city_country_id`
            ORDER BY `continent_name` ASC, `country_name` ASC";
}

$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_country`";
$count_country = $mysqli->query($sql);
$count_country = $count_country->fetch_all(1);
$count_country = $count_country[0]['count_country'];

include (__DIR__ . '/../view/admin_main.php');