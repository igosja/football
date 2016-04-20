<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_country_id))
{
    $get_num = $authorization_country_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data as $key => $value)
    {
        $captain_id = (int) $key;
        $player_id  = (int) $value;

        $sql = "UPDATE `country`
                SET `country_captain_player_id_" . $captain_id . "`='$player_id'
                WHERE `country_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('national_lineup_tactic_captain.php?num=' . $get_num);
}

$sql = "SELECT `leader`,
               `name_name`,
               `player_age`,
               `player_id`,
               `position_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `leader`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='22'
        ) AS `t1`
        ON `playerattribute_player_id`=`player_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `position_id` ASC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `leader`,
               `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `leader`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='22'
        ) AS `t1`
        ON `playerattribute_player_id`=`player_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `leader` DESC, `player_id` ASC";
$leader_sql = $mysqli->query($sql);

$leader_array = $leader_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_captain_player_id_1`,
               `country_captain_player_id_2`,
               `country_captain_player_id_3`,
               `country_captain_player_id_4`,
               `country_captain_player_id_5`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$captain_sql = $mysqli->query($sql);

$captain_array = $captain_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $country_name;

include (__DIR__ . '/view/main.php');