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

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data as $key => $value)
    {
        $statusnational_id  = (int)$value;
        $player_id          = (int)$key;

        $sql = "UPDATE `player`
                SET `player_statusnational_id`='$statusnational_id'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены';

    redirect('team_team_player_international.php?num=' . $get_num);
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_height`,
               `player_id`,
               `player_price`,
               `player_statusnational_id`,
               `player_weight`,
               `position_name`,
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
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `country`
        ON `country_id`=`player_country_id`
        WHERE `team_id`='$get_num'";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `statusnational_id`,
               `statusnational_name`
        FROM `statusnational`
        ORDER BY `statusnational_id` ASC";
$statusnational_sql = $mysqli->query($sql);

$statusnational_array = $statusnational_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('statusnational_array', $statusnational_array);

$smarty->display('main.html');