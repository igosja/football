<?php

$start_time = microtime(true);

if (!defined('_SAPE_USER'))
{
    define('_SAPE_USER', 'c5bcf069b3ccb0d8c2b5dfba420b8478');
}

require_once (realpath($_SERVER['DOCUMENT_ROOT'] . '/' . _SAPE_USER . '/sape.php'));

$o              = array();
$o['charset']   = 'UTF-8'; 
$sape           = new SAPE_client($o); 
unset($o);

$phpstorm_licence = 'http://idea.qinxi1992.cn/';
$wind_php_command = 'D:\xampp\php\php-cgi.exe D:\xampp\htdocs\fm.local.net\www\generator\generator.php';
$denw_php_command = '\usr\local\php5\php-cgi.exe \home\fm.local.net\www\generator\generator.php';

include (__DIR__ . '/constants.php');
include (__DIR__ . '/server_constants.php');
include (__DIR__ . '/database.php');
include (__DIR__ . '/function.php');
include (__DIR__ . '/session.php');

$header_title           = 'Лига';
$horizontalmenu_array   = array();

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

$sql = "SELECT `site_status`,
               `site_version_1`,
               `site_version_2`,
               `site_version_3`,
               `site_version_4`,
               `site_version_date`
        FROM `site`
        WHERE `site_id`='1'
        LIMIT 1";
$site_sql = $mysqli->query($sql);

$site_array = $site_sql->fetch_all(MYSQLI_ASSOC);

$site_status = $site_array[0]['site_status'];

if (SITE_CLOSED == $site_status && 'admin' != $chapter)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/site_closed.php');
    exit;
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
        AND `horizontalsubmenu_status`='1'
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

$tpl = $file_name;

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
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_logged.php');
    exit;
}

$sql = "SELECT COUNT(`shedule_id`) AS `count`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_OFF_SEASON . "'
        AND `shedule_date`<=CURDATE()
        AND `shedule_season_id`='$igosja_season_id'";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);
$count_shedule = $shedule_array[0]['count'];

if (0 == $count_shedule)
{
    $coach_link = '';
}
elseif (5 >= $count_shedule)
{
    $coach_link = 'national_coach_application.php';
}
else
{
    $coach_link = 'national_coach_vote.php';
}