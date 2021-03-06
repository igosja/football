<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_team_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT COUNT(`player_id`) AS `count_player`
        FROM `player`
        WHERE `player_team_id`='$authorization_team_id'
        AND `player_position_id`='1'
        AND `player_id`!='$num_get'";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count = $count_array[0]['count_player'];

if (2 > $count)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'В команде должно остаться не менее 2 вратарей.';

    redirect('player_home_profile.php?num=' . $num_get);
}

$sql = "SELECT COUNT(`player_id`) AS `count_player`
        FROM `player`
        WHERE `player_team_id`='$authorization_team_id'
        AND `player_position_id`!='1'
        AND `player_id`!='$num_get'";
$count_sql = $mysqli->query($sql);

$count_array = $count_sql->fetch_all(1);

$count = $count_array[0]['count_player'];

if (16 > $count)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'В команде должно остаться не менее 16 полевых игроков.';

    redirect('player_transfer_status.php?num=' . $num_get);
}

$sql = "SELECT `name_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        WHERE `player_id`='$num_get'
        AND `player_team_id`='$authorization_team_id'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

if (isset($_GET['ok']))
{
    $sql = "UPDATE `player`
            SET `player_team_id`='0'
            WHERE `player_id`='$num_get'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "DELETE FROM `playeroffer`
            WHERE `playeroffer_player_id`='$num_get'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `transfer`
            WHERE `transfer_player_id`='$num_get'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `teamwork`
            WHERE `teamwork_first_id`='$num_get'
            OR `teamwork_second_id`='$num_get'";
    $mysqli->query($sql);

    f_igosja_history(HISTORY_TEXT_PLAYER_FIRE, $authorization_user_id, 0, $authorization_team_id, $num_get);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Игрок успешно уволен.';

    redirect('player_home_profile.php?num=' . $num_get);
}

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. Увольнение футболиста. ' . $seo_title;
$seo_description    = $header_title . '. Увольнение футболиста. ' . $seo_description;
$seo_keywords       = $header_title . ', увольнение футболиста, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');
