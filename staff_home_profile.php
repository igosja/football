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
               `name_name`,
               `staff_age`,
               `staff_reputation`,
               `staffpost_id`,
               `staffpost_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `staff`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        LEFT JOIN `staffpost`
        ON `staff_staffpost_id`=`staffpost_id`
        LEFT JOIN `country`
        ON `country_id`=`staff_country_id`
        LEFT JOIN `team`
        ON `team_id`=`staff_team_id`
        WHERE `staff_id`='$num_get'
        LIMIT 1";
$staff_sql = $mysqli->query($sql);

$count_staff = $staff_sql->num_rows;

if (0 == $count_staff)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$staff_array = $staff_sql->fetch_all(1);

$sql = "SELECT `attributestaff_name`,
               `attributechapterstaff_name`,
               `staffattribute_value`
        FROM `staff`
        LEFT JOIN `staffattribute`
        ON `staffattribute_staff_id`=`staff_id`
        LEFT JOIN `attributestaff`
        ON `attributestaff_id`=`staffattribute_attributestaff_id`
        LEFT JOIN `attributechapterstaff`
        ON `attributechapterstaff_id`=`attributestaff_attributechapterstaff_id`
        WHERE `staff_id`='$num_get'
        ORDER BY `attributechapterstaff_id` ASC, `attributestaff_id` ASC";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;
$attribute_array = $attribute_sql->fetch_all(1);

$sql = "SELECT ROUND(COUNT(`scout_id`)/`count_player`*100) AS `count_scout`,
               `country_id`,
               `country_name`
        FROM `scout`
        LEFT JOIN `player`
        ON `player_id`=`scout_player_id`
        LEFT JOIN `country`
        ON `player`.`player_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT COUNT(`player_country_id`) AS `count_player`,
                   `player_country_id`
            FROM `player`
            GROUP BY `player_country_id`
            ORDER BY `player_country_id` ASC
        ) AS `t1`
        ON `t1`.`player_country_id`=`country_id`
        WHERE `scout_team_id`=
        (
            SELECT `staff_team_id`
            FROM `staff`
            WHERE `staff_id`='$num_get'
        )
        GROUP BY `player`.`player_country_id`
        ORDER BY `player`.`player_country_id` ASC";
$scout_sql = $mysqli->query($sql);

$scout_array = $scout_sql->fetch_all(1);

$staff_name     = $staff_array[0]['name_name'];
$staff_surname  = $staff_array[0]['surname_name'];

$num                = $num_get;
$header_title       = $staff_name . ' ' . $staff_surname;
$seo_title          = $header_title . '. Профиль персонала. ' . $seo_title;
$seo_description    = $header_title . '. Профиль персонала. ' . $seo_description;
$seo_keywords       = $header_title . ', профиль персонала, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');