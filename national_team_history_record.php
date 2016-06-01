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

$sql = "SELECT `recordcountrytype_id`
        FROM `recordcountrytype`
        ORDER BY `recordcountrytype_id` ASC";
$recordtype_sql = $mysqli->query($sql);

$count_recordtype = $recordtype_sql->num_rows;

$sql = "SELECT `recordcountry_id`
        FROM `recordcountry`
        WHERE `recordcountry_country_id`='$num_get'
        ORDER BY `recordcountry_recordcountrytype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;

if ($count_record != $count_recordtype)
{
    $recordtype_array = $recordtype_sql->fetch_all(1);

    for ($i=0; $i<$count_recordtype; $i++)
    {
        $recordtype_id = $recordtype_array[$i]['recordcountrytype_id'];

        $sql = "SELECT `recordcountry_id`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$num_get'
                AND `recordcountry_recordcountrytype_id`='$recordtype_id'";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_country_id`='$num_get',
                        `recordcountry_recordcountrytype_id`='$recordtype_id'";
            $mysqli->query($sql);
        }
    }
}

$sql = "SELECT `game_guest_score`,
               `game_home_score`,
               `game_id`,
               `name_name`,
               `player_id`,
               `recordcountry_date_end`,
               `recordcountry_date_start`,
               `recordcountry_value`,
               `recordcountrytype_name`,
               `shedule_date`,
               `surname_name`,
               `tournament_id`,
               `tournament_name`
        FROM `recordcountry`
        LEFT JOIN `recordcountrytype`
        ON `recordcountrytype_id`=`recordcountry_recordcountrytype_id`
        LEFT JOIN `tournament`
        ON `tournament_id`=`recordcountry_tournament_id`
        LEFT JOIN `game`
        ON `recordcountry_game_id`=`game_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `player`
        ON `player_id`=`recordcountry_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        WHERE `recordcountry_country_id`='$num_get'
        ORDER BY `recordcountrytype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;
$record_array = $record_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Рекорды сборной. ' . $seo_title;
$seo_description    = $header_title . '. Рекорды сборной. ' . $seo_description;
$seo_keywords       = $header_title . ', рекорды сборной, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');