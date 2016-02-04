<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['continent_id']))
{
    $continent_id = (int) $_GET['continent_id'];

    $sql = "SELECT `city_id`, `city_name`, `continent_id`, `continent_name`, `count_team`, `country_id`, `country_name`
            FROM `city` AS `t1`
            LEFT JOIN `country` AS `t2`
            ON `t1`.`city_country_id`=`t2`.`country_id`
            LEFT JOIN `continent` AS `t3`
            ON `t2`.`country_continent_id`=`t3`.`continent_id`
            LEFT JOIN
            (
                SELECT `team_city_id`, COUNT(`team_id`) AS `count_team`
                FROM `team`
                GROUP BY `team_city_id`
            ) AS `t4`
            ON `t1`.`city_id`=`t4`.`team_city_id`
            WHERE `continent_id`='$continent_id'
            ORDER BY `continent_name` ASC, `country_name` ASC, `city_name` ASC";
}
elseif (isset($_GET['country_id']))
{
    $country_id = (int) $_GET['country_id'];
    
    $sql = "SELECT `city_id`, `city_name`, `continent_id`, `continent_name`, `count_team`, `country_id`, `country_name`
            FROM `city` AS `t1`
            LEFT JOIN `country` AS `t2`
            ON `t1`.`city_country_id`=`t2`.`country_id`
            LEFT JOIN `continent` AS `t3`
            ON `t2`.`country_continent_id`=`t3`.`continent_id`
            LEFT JOIN
            (
                SELECT `team_city_id`, COUNT(`team_id`) AS `count_team`
                FROM `team`
                GROUP BY `team_city_id`
            ) AS `t4`
            ON `t1`.`city_id`=`t4`.`team_city_id`
            WHERE `country_id`='$country_id'
            ORDER BY `continent_name` ASC, `country_name` ASC, `city_name` ASC";
}
else
{
    $sql = "SELECT `city_id`, `city_name`, `continent_id`, `continent_name`, `count_team`, `country_id`, `country_name`
            FROM `city` AS `t1`
            LEFT JOIN `country` AS `t2`
            ON `t1`.`city_country_id`=`t2`.`country_id`
            LEFT JOIN `continent` AS `t3`
            ON `t2`.`country_continent_id`=`t3`.`continent_id`
            LEFT JOIN
            (
                SELECT `team_city_id`, COUNT(`team_id`) AS `count_team`
                FROM `team`
                GROUP BY `team_city_id`
            ) AS `t4`
            ON `t1`.`city_id`=`t4`.`team_city_id`
            ORDER BY `continent_name` ASC, `country_name` ASC, `city_name` ASC";
}

$city_sql = $mysqli->query($sql);

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('city_array', $city_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');