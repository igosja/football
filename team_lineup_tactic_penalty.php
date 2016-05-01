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

    foreach ($data as $key => $value)
    {
        $penalty_id = (int) $key;
        $player_id  = (int) $value;

        $sql = "UPDATE `team`
                SET `team_penalty_player_id_" . $penalty_id . "`='$player_id'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_tactic_penalty.php?num=' . $num_get);
}

$sql = "SELECT `composure`,
               `name_name`,
               `penalty`,
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
            SELECT `playerattribute_value` AS `penalty`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='11'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `composure`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='26'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        LEFT JOIN `playerposition`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `player_team_id`='$num_get'
        AND `playerposition_value`='100'
        ORDER BY `position_id` ASC, `player_id` ASC";
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
            SELECT `playerattribute_value` AS `penalty`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='11'
        ) AS `t1`
        ON `t1`.`playerattribute_player_id`=`player_id`
        LEFT JOIN 
        (
            SELECT `playerattribute_value` AS `composure`,
                   `playerattribute_player_id`
            FROM `playerattribute`
            WHERE `playerattribute_attribute_id`='26'
        ) AS `t2`
        ON `t2`.`playerattribute_player_id`=`player_id`
        WHERE `player_team_id`='$num_get'
        ORDER BY `penalty` DESC, `composure` DESC, `player_id` ASC";
$penaltyplayer_sql = $mysqli->query($sql);

$penaltyplayer_array = $penaltyplayer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_penalty_player_id_1`,
               `team_penalty_player_id_2`,
               `team_penalty_player_id_3`,
               `team_penalty_player_id_4`,
               `team_penalty_player_id_5`,
               `team_penalty_player_id_6`,
               `team_penalty_player_id_7`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$penalty_sql = $mysqli->query($sql);

$penalty_array = $penalty_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Выбор исполнителей пенальти. ' . $seo_title;
$seo_description    = $header_title . '. Выбор исполнителей пенальти. ' . $seo_description;
$seo_keywords       = $header_title . ', выбор исполнителей пенальти, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');