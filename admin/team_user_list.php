<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `city_id`,
               `city_name`,
               `continent_id`,
               `continent_name`,
               `country_id`,
               `country_name`,
               `stadium_name`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `team`
        LEFT JOIN `stadium`
        ON `stadium_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `continent`
        ON `country_continent_id`=`continent_id`
        LEFT JOIN `user`
        ON `user_id`=`team_user_id`
        WHERE `team_user_id`!='0'
        ORDER BY `continent_name` ASC, `country_name` ASC, `team_name` ASC, `city_name` ASC";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');