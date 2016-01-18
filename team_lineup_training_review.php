<?php

include ('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data as $key => $value)
    {
        $player_id      = (int) $key;
        $position_id    = (int) $value['position'];
        $attribute_id   = (int) $value['attribute'];
        $intensity      = (int) $value['intensity'];

        $sql = "UPDATE `player`
                SET `player_training_position_id`='$position_id',
                    `player_training_attribute_id`='$attribute_id',
                    `player_training_intensity`='$intensity'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_training_review.php?num=' . $get_num);
    exit;
}

$sql = "SELECT `name_name`,
               `player_condition`,
               `player_id`,
               `player_training_attribute_id`,
               `player_training_intensity`,
               `player_training_position_id`,
               `position_id`,
               `position_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `position`
        ON `position_id`=`player_position_id`
        WHERE `player_team_id`='$get_num'
        ORDER BY `position_id` ASC, `player_id` ASC";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `position_id`, `position_description`
        FROM `position`
        WHERE `position_available`='1'
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQL_ASSOC);

$sql = "SELECT `attribute_id`, `attribute_name`
        FROM `attribute`
        WHERE `attribute_attributechapter_id` NOT IN ('1','2')
        ORDER BY `attribute_name` ASC";
$attribute_sql = $mysqli->query($sql);

$attribute_array = $attribute_sql->fetch_all(MYSQL_ASSOC);

$sql = "SELECT `attribute_id`, `attribute_name`
        FROM `attribute`
        WHERE `attribute_attributechapter_id` NOT IN ('1','3')
        ORDER BY `attribute_name` ASC";
$attribute_sql = $mysqli->query($sql);

$gk_attribute_array = $attribute_sql->fetch_all(MYSQL_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('position_array', $position_array);
$smarty->assign('attribute_array', $attribute_array);
$smarty->assign('gk_attribute_array', $gk_attribute_array);

$smarty->display('main.html');