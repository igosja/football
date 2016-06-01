<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_country_id))
{
    $num_get = $authorization_country_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(1);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `mood_id`,
               `mood_name`,
               `name_name`,
               `player_age`,
               `player_condition`,
               `player_height`,
               `player_national_id`,
               `player_id`,
               `position_name`,
               `player_practice`,
               `player_weight`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `mood`
        ON `player_mood_id`=`mood_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `player_country_id`='$num_get'
        AND `player_statusnational_id`='1'
        ORDER BY `player_position_id` ASC, `player_reputation` DESC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Кандидаты в сборную. ' . $seo_title;
$seo_description    = $header_title . '. Кандидаты в сборную. ' . $seo_description;
$seo_keywords       = $header_title . ', кандидаты в сборную, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');