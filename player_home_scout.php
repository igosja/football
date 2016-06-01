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

if (!isset($authorization_team_id))
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Сначала нужно взять команду под упраление.';

    redirect($_SERVER['HTTP_REFERER']);
}

$sql = "SELECT COUNT(`scout_id`) AS `count`
        FROM `scout`
        WHERE `scout_player_id`='$num_get'
        AND `scout_team_id`='$authorization_team_id'";
$scout_sql = $mysqli->query($sql);

$scout_array = $scout_sql->fetch_all(1);
$count_scout = $scout_array[0]['count'];

$sql = "SELECT COUNT(`player_id`) AS `count`
        FROM `player`
        WHERE `player_id`='$num_get'
        AND `player_team_id`='$authorization_team_id'";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);
$count_player = $player_array[0]['count'];

if (0 != $count_scout ||
    0 != $count_player)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Игрок уже изучен.';

    redirect($_SERVER['HTTP_REFERER']);
}

$sql = "SELECT COUNT(`scoutnearest_id`) AS `count`
        FROM `scoutnearest`
        WHERE `scoutnearest_player_id`='$num_get'
        AND `scoutnearest_team_id`='$authorization_team_id'";
$scoutnearest_sql = $mysqli->query($sql);

$scoutnearest_array = $scoutnearest_sql->fetch_all(1);
$count_scoutnearest = $scoutnearest_array[0]['count'];

if (0 != $count_scoutnearest)
{
    $_SESSION['message_class']  = 'error';
    $_SESSION['message_text']   = 'Игрок уже добавлен в список ваших скаутов.';

    redirect($_SERVER['HTTP_REFERER']);
}

$sql = "INSERT INTO `scoutnearest`
        SET `scoutnearest_player_id`='$num_get',
            `scoutnearest_team_id`='$authorization_team_id'";
$mysqli->query($sql);

$_SESSION['message_class']  = 'success';
$_SESSION['message_text']   = 'Игрок добавлен в список ваших скаутов.';

redirect($_SERVER['HTTP_REFERER']);