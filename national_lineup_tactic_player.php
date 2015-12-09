<?php

include ('include/include.php');

if (isset($authorization_country_id))
{
    $get_num = $authorization_country_id;
}
else
{
    $smarty->display('only_my_country.html');
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
    $smarty->display('wrong_page.html');

    exit;
}

$sql = "SELECT COUNT(`lineupcurrent_id`) AS `count`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_country_id`='$get_num'";
$lineupcurrent_sql = $mysqli->query($sql);

$lineupcurrent_array = $lineupcurrent_sql->fetch_all(MYSQLI_ASSOC);

$count_lineupcurrent = $lineupcurrent_array[0]['count'];

if (0 == $count_lineupcurrent)
{
    $sql = "INSERT INTO `lineupcurrent`
            SET `lineupcurrent_country_id`='$get_num'";
    $mysqli->query($sql);
}

if (isset($_POST['role_id']))
{
    $role_id  = (int) $_POST['role_id'];
    $position = (int) $_POST['position'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_role_id_" . $position . "`='$role_id'
            WHERE `lineupcurrent_country_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class'] = 'success';
    $_SESSION['message_text']  = 'Изменения успешно сохранены';

    redirect('country_lineup_tactic_player.php?num=' . $get_num);

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `lineupcurrent_formation_id`,
               `lineupcurrent_player_id_1`,
               `lineupcurrent_player_id_2`,
               `lineupcurrent_player_id_3`,
               `lineupcurrent_player_id_4`,
               `lineupcurrent_player_id_5`,
               `lineupcurrent_player_id_6`,
               `lineupcurrent_player_id_7`,
               `lineupcurrent_player_id_8`,
               `lineupcurrent_player_id_9`,
               `lineupcurrent_player_id_10`,
               `lineupcurrent_player_id_11`,
               `lineupcurrent_player_id_12`,
               `lineupcurrent_player_id_13`,
               `lineupcurrent_player_id_14`,
               `lineupcurrent_player_id_15`,
               `lineupcurrent_player_id_16`,
               `lineupcurrent_player_id_17`,
               `lineupcurrent_player_id_18`,
               `lineupcurrent_position_id_1`,
               `lineupcurrent_position_id_2`,
               `lineupcurrent_position_id_3`,
               `lineupcurrent_position_id_4`,
               `lineupcurrent_position_id_5`,
               `lineupcurrent_position_id_6`,
               `lineupcurrent_position_id_7`,
               `lineupcurrent_position_id_8`,
               `lineupcurrent_position_id_9`,
               `lineupcurrent_position_id_10`,
               `lineupcurrent_position_id_11`,
               `lineupcurrent_position_id_12`,
               `lineupcurrent_position_id_13`,
               `lineupcurrent_position_id_14`,
               `lineupcurrent_position_id_15`,
               `lineupcurrent_position_id_16`,
               `lineupcurrent_position_id_17`,
               `lineupcurrent_position_id_18`,
               `lineupcurrent_role_id_1`,
               `lineupcurrent_role_id_2`,
               `lineupcurrent_role_id_3`,
               `lineupcurrent_role_id_4`,
               `lineupcurrent_role_id_5`,
               `lineupcurrent_role_id_6`,
               `lineupcurrent_role_id_7`,
               `lineupcurrent_role_id_8`,
               `lineupcurrent_role_id_9`,
               `lineupcurrent_role_id_10`,
               `lineupcurrent_role_id_11`
        FROM `lineupcurrent`
        WHERE `lineupcurrent_country_id`='$get_num'
        LIMIT 1";
$lineup_sql = $mysqli->query($sql);

$lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $country_name);
$smarty->assign('lineup_array', $lineup_array);

$smarty->display('main.html');