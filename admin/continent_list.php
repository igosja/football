<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `continent_id`, `continent_name`, `count_city`, `count_country`, `count_team`
        FROM `continent` AS `t1`
        LEFT JOIN 
        (
            SELECT `country_continent_id`, `country_id`, COUNT(`country_id`) AS `count_country`
            FROM `country`
            GROUP BY `country_continent_id`
        ) AS `t2`
        ON `t1`.`continent_id`=`t2`.`country_continent_id`
        LEFT JOIN
        (
            SELECT `country_continent_id`, COUNT(`city_id`) AS `count_city`
            FROM `city`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            GROUP BY `country_continent_id`
        ) AS `t3`
        ON `t1`.`continent_id`=`t3`.`country_continent_id`
        LEFT JOIN
        (
            SELECT `country_continent_id`, COUNT(`team_id`) AS `count_team`
            FROM `city`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            LEFT JOIN `team`
            ON `team_city_id`=`city_id`
            GROUP BY `country_continent_id`
        ) AS `t4`
        ON `t1`.`continent_id`=`t4`.`country_continent_id`";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('continent_array', $continent_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');