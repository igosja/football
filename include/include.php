<?php

$start_time = microtime(true);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/constants.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/database.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/function.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/session.php');

$file_name  = $_SERVER['PHP_SELF'];
$file_name  = explode('/', $file_name);
$chapter    = $file_name[1];
$file_name  = end($file_name);
$file_name  = explode('.', $file_name);
$file_name  = $file_name[0];
$button     = explode('_', $file_name);

if (isset($button[0]) &&
    isset($button[1]))
{
    if ('team' == $button[0] &&
        'lineup' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'team_team_review_profile.php?num=' . $_GET['num'], 'class' => '', 'text' => 'Команда'),
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Состав'),
        );
    }
    elseif ('team' == $button[0] &&
            'team' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Команда'),
            array('href' => 'team_lineup_team_player.php?num=' . $_GET['num'], 'class' => '', 'text' => 'Состав'),
        );
    }
    elseif ('national' == $button[0] &&
            'lineup' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'national_team_review_profile.php?num=' . $_GET['num'], 'class' => '', 'text' => 'Команда'),
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Состав'),
        );
    }
    elseif ('national' == $button[0] &&
            'team' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Команда'),
            array('href' => 'national_lineup_team_player.php?num=' . $_GET['num'], 'class' => '', 'text' => 'Состав'),
        );
    }
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = $mysqli->query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$igosja_season_id = $season_array[0]['season_id'];

$sql = "SELECT `continent_id`,
               `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `horizontalmenu_authorization`,
               `horizontalmenu_myteam`,
               `horizontalmenu_name`,
               `horizontalsubmenu_authorization`,
               `horizontalsubmenu_name`,
               `horizontalsubmenu_href`
        FROM `horizontalmenu`
        LEFT JOIN `horizontalsubmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenu_horizontalmenuchapter_id`=`horizontalmenuchapter_id`
        LEFT JOIN `horizontalmenupage`
        ON `horizontalmenuchapter_id`=`horizontalmenupage_horizontalmenuchapter_id`
        WHERE `horizontalmenupage_name`='$file_name'
        ORDER BY `horizontalmenu_id` ASC, `horizontalsubmenu_id` ASC";
$horizontalmenu_sql = $mysqli->query($sql);

$horizontalmenu_array = $horizontalmenu_sql->fetch_all(MYSQLI_ASSOC);

if ('admin' == $chapter)
{
    f_igosja_admin_permission($authorization_permission);
}

if (isset($_SESSION['message_class']))
{
    $alert_message['class'] = $_SESSION['message_class'];
    $alert_message['text']  = $_SESSION['message_text'];

    unset($_SESSION['message_class']);
    unset($_SESSION['message_text']);
}

$header_title   = 'Лига';
$tpl            = $file_name;

$sql = "SELECT `horizontalmenupage_authorization`,
               `horizontalmenupage_myteam`
        FROM `horizontalmenupage`
        WHERE `horizontalmenupage_name`='$file_name'
        LIMIT 1";
$horizontalmenupage_sql = $mysqli->query($sql);

$horizontalmenupage_array = $horizontalmenupage_sql->fetch_all(MYSQLI_ASSOC);

if (isset($horizontalmenupage_array[0]['horizontalmenupage_authorization']))
{
    $page_authorization = $horizontalmenupage_array[0]['horizontalmenupage_authorization'];
}
else
{
    $page_authorization = 0;
}

if (1 == $page_authorization &&
    !isset($authorization_id))
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/only_logged.html');
    exit;
}