<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data['corner_left'] as $key => $value)
    {
        $corner_left    = (int) $key;
        $player_id      = (int) $value;

        $sql = "UPDATE `team`
                SET `team_corner_left_player_id_" . $corner_left . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    foreach ($data['corner_right'] as $key => $value)
    {
        $corner_right   = (int) $key;
        $player_id      = (int) $value;

        $sql = "UPDATE `team`
                SET `team_corner_right_player_id_" . $corner_right . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    foreach ($data['freekick_left'] as $key => $value)
    {
        $freekick_left  = (int) $key;
        $player_id      = (int) $value;

        $sql = "UPDATE `team`
                SET `team_freekick_left_player_id_" . $freekick_left . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    foreach ($data['freekick_right'] as $key => $value)
    {
        $freekick_right = (int) $key;
        $player_id      = (int) $value;

        $sql = "UPDATE `team`
                SET `team_freekick_right_player_id_" . $freekick_right . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    foreach ($data['out_left'] as $key => $value)
    {
        $out_left   = (int) $key;
        $player_id  = (int) $value;

        $sql = "UPDATE `team`
                SET `team_out_left_player_id_" . $out_left . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    foreach ($data['out_right'] as $key => $value)
    {
        $out_right  = (int) $key;
        $player_id  = (int) $value;

        $sql = "UPDATE `team`
                SET `team_out_right_player_id_" . $out_right . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_standard.php?num=' . $num_get);
}

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
        LEFT JOIN `playerposition`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `player_team_id`='$num_get'
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
        WHERE `player_team_id`='$num_get'
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
        WHERE `player_team_id`='$num_get'
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
        WHERE `player_team_id`='$num_get'
        ORDER BY `out` DESC";
$out_sql = $mysqli->query($sql);

$out_array = $out_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_corner_left_player_id_1`,
               `team_corner_left_player_id_2`,
               `team_corner_left_player_id_3`,
               `team_corner_left_player_id_4`,
               `team_corner_left_player_id_5`,
               `team_corner_right_player_id_1`,
               `team_corner_right_player_id_2`,
               `team_corner_right_player_id_3`,
               `team_corner_right_player_id_4`,
               `team_corner_right_player_id_5`,
               `team_freekick_left_player_id_1`,
               `team_freekick_left_player_id_2`,
               `team_freekick_left_player_id_3`,
               `team_freekick_left_player_id_4`,
               `team_freekick_left_player_id_5`,
               `team_freekick_right_player_id_1`,
               `team_freekick_right_player_id_2`,
               `team_freekick_right_player_id_3`,
               `team_freekick_right_player_id_4`,
               `team_freekick_right_player_id_5`,
               `team_out_left_player_id_1`,
               `team_out_left_player_id_2`,
               `team_out_left_player_id_3`,
               `team_out_left_player_id_4`,
               `team_out_left_player_id_5`,
               `team_out_right_player_id_1`,
               `team_out_right_player_id_2`,
               `team_out_right_player_id_3`,
               `team_out_right_player_id_4`,
               `team_out_right_player_id_5`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$standard_sql = $mysqli->query($sql);

$standard_array = $standard_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');