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

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

if (isset($_GET['ok']))
{
    $sql = "UPDATE `player`
            SET `player_team_id`='0'
            WHERE `player_id`='$num_get'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "INSERT INTO `history`
            SET `history_date`=UNIX_TIMESTAMP(),
                `history_historytext_id`='" . HISTORY_TEXT_PLAYER_FIRE . "',
                `history_player_id`='$num_get',
                `history_season_id`='$igosja_season_id',
                `history_team_id`='$authorization_team_id'";
    $mysqli->query($sql);

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