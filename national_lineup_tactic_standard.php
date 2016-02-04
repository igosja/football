<?php

include ('include/include.php');

if (isset($authorization_country_id))
{
    $get_num = $authorization_country_id;
}
else
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.html');
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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `corner`,
               `free_kick`,
               `name_name`,
               `out`,
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
            SELECT `playerattribute_value` AS `free_kick`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='6'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `corner`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='14'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `out`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='1'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `position_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `corner`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='14'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `corner` DESC";
$corner_sql = $mysqli->query($sql);

$corner_array = $corner_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `freekick`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='6'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `freekick` DESC";
$freekick_sql = $mysqli->query($sql);

$freekick_array = $freekick_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN
        (
            SELECT `playerattribute_value` AS `out`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='1'
        ) AS `t3`
        ON `t3`.`playerattribute_player_id`=`player_id`
        WHERE `player_national_id`='$get_num'
        ORDER BY `out` DESC";
$out_sql = $mysqli->query($sql);

$out_array = $out_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_corner_left_player_id_1`,
               `country_corner_left_player_id_2`,
               `country_corner_left_player_id_3`,
               `country_corner_left_player_id_4`,
               `country_corner_left_player_id_5`,
               `country_corner_right_player_id_1`,
               `country_corner_right_player_id_2`,
               `country_corner_right_player_id_3`,
               `country_corner_right_player_id_4`,
               `country_corner_right_player_id_5`,
               `country_freekick_left_player_id_1`,
               `country_freekick_left_player_id_2`,
               `country_freekick_left_player_id_3`,
               `country_freekick_left_player_id_4`,
               `country_freekick_left_player_id_5`,
               `country_freekick_right_player_id_1`,
               `country_freekick_right_player_id_2`,
               `country_freekick_right_player_id_3`,
               `country_freekick_right_player_id_4`,
               `country_freekick_right_player_id_5`,
               `country_out_left_player_id_1`,
               `country_out_left_player_id_2`,
               `country_out_left_player_id_3`,
               `country_out_left_player_id_4`,
               `country_out_left_player_id_5`,
               `country_out_right_player_id_1`,
               `country_out_right_player_id_2`,
               `country_out_right_player_id_3`,
               `country_out_right_player_id_4`,
               `country_out_right_player_id_5`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$standard_sql = $mysqli->query($sql);

$standard_array = $standard_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $country_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('corner_array', $corner_array);
$smarty->assign('freekick_array', $freekick_array);
$smarty->assign('out_array', $out_array);
$smarty->assign('standard_array', $standard_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.html');