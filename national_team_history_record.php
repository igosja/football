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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `recordcountrytype_id`
        FROM `recordcountrytype`
        ORDER BY `recordcountrytype_id` ASC";
$recordtype_sql = $mysqli->query($sql);

$count_recordtype = $recordtype_sql->num_rows;

$sql = "SELECT `recordcountry_id`
        FROM `recordcountry`
        WHERE `recordcountry_country_id`='$get_num'
        ORDER BY `recordcountry_recordcountrytype_id` ASC";
$record_sql = $mysqli->query($sql);

$count_record = $record_sql->num_rows;

if ($count_record != $count_recordtype)
{
    $recordtype_array = $recordtype_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_recordtype; $i++)
    {
        $recordtype_id = $recordtype_array[$i]['recordcountrytype_id'];

        $sql = "SELECT `recordcountry_id`
                FROM `recordcountry`
                WHERE `recordcountry_country_id`='$get_num'
                AND `recordcountry_recordcountrytype_id`='$recordtype_id'";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `recordcountry`
                    SET `recordcountry_country_id`='$get_num',
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
        WHERE `recordcountry_country_id`='$get_num'
        ORDER BY `recordcountrytype_id` ASC";
$record_sql = $mysqli->query($sql);

$record_array = $record_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $country_name);
$smarty->assign('record_array', $record_array);

$smarty->display('main.html');