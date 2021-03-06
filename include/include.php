<?php

$start_time = microtime(true);

$css_js_version = 3;

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
$seo_title              = 'Виртуальная футбольная лига.';
$seo_description        = 'Виртуальная футбольная лига - футбольный онлайн менеджер.';
$seo_keywords           = 'футбол, игра, менеджер, онлайн, футбольный онлайн менеджер, онлайн менеджер футбол';

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
    if (!isset($_GET['num']))
    {
        if (isset($authorization_team_id))
        {
            $num_get = $authorization_team_id;
        }
        else
        {
            $num_get = 0;
        }
    }
    else
    {
        $num_get = $_GET['num'];
    }

    if ('team' == $button[0] &&
        'lineup' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'team_team_review_profile.php?num=' . $num_get, 'class' => '', 'text' => 'Команда'),
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Состав'),
        );
    }
    elseif ('team' == $button[0] &&
            'team' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Команда'),
            array('href' => 'team_lineup_team_player.php?num=' . $num_get, 'class' => '', 'text' => 'Состав'),
        );
    }
    elseif ('national' == $button[0] &&
            'lineup' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'national_team_review_profile.php?num=' . $num_get, 'class' => '', 'text' => 'Команда'),
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Состав'),
        );
    }
    elseif ('national' == $button[0] &&
            'team' == $button[1])
    {
        $button_array = array
        (
            array('href' => 'javascript:;', 'class' => 'active', 'text' => 'Команда'),
            array('href' => 'national_lineup_team_player.php?num=' . $num_get, 'class' => '', 'text' => 'Состав'),
        );
    }
    elseif ('player' == $button[0] &&
            isset($_GET['num']))
    {
        $num_get = (int) $_GET['num'];

        $button_array = f_igosja_player_to_scout_and_fire_button($num_get);
    }
    elseif ('profile' == $button[0] &&
            isset($authorization_team_id))
    {
        $button_array = array
        (
            array('href' => 'profile_team_refuse.php', 'class' => '', 'text' => 'Отказаться от команды'),
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

$site_array = $site_sql->fetch_all(1);

$site_status = $site_array[0]['site_status'];

if (SITE_CLOSED == $site_status && 'admin' != $chapter)
{
    include (__DIR__ . '/../view/site_closed.php');
    exit;
}

if ('admin' == $chapter)
{
    $sql = "SELECT COUNT(`inbox_id`) AS `count`
            FROM `inbox`
            WHERE `inbox_support`='1'
            AND `inbox_user_id`='0'
            AND `inbox_read`='0'";
    $admin_support_sql = $mysqli->query($sql);

    $admin_support_array = $admin_support_sql->fetch_all(1);
    $count_admin_support = $admin_support_array[0]['count'];

    if (0 == $count_admin_support)
    {
        $count_admin_support = '';
    }

    $sql = "SELECT COUNT(`vote_id`) AS `count`
            FROM `vote`
            WHERE `vote_view`='0'";
    $admin_vote_sql = $mysqli->query($sql);

    $admin_vote_array = $admin_vote_sql->fetch_all(1);
    $count_admin_vote = $admin_vote_array[0]['count'];

    if (0 == $count_admin_vote)
    {
        $count_admin_vote = '';
    }
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = $mysqli->query($sql);

$season_array = $season_sql->fetch_all(1);

$igosja_season_id = $season_array[0]['season_id'];

$sql = "SELECT `continent_id`,
               `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(1);

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

$horizontalmenu_array = $horizontalmenu_sql->fetch_all(1);

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

$horizontalmenupage_array = $horizontalmenupage_sql->fetch_all(1);

if (isset($horizontalmenupage_array[0]['horizontalmenupage_authorization']))
{
    $page_authorization = $horizontalmenupage_array[0]['horizontalmenupage_authorization'];
}
else
{
    $page_authorization = 0;
}

if (1 == $page_authorization &&
    !isset($authorization_user_id))
{
    include (__DIR__ . '/../view/only_logged.php');
    exit;
}

$sql = "SELECT COUNT(`shedule_id`) AS `count`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_OFF_SEASON . "'
        AND `shedule_date`<=CURDATE()
        AND `shedule_season_id`='$igosja_season_id'";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(1);
$count_shedule = $shedule_array[0]['count'];

$sql = "SELECT COUNT(`country_id`) AS `count`
        FROM `city`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `country_user_id`='0'
        AND `city_id`!='0'";
$coach_country_sql = $mysqli->query($sql);

$coach_country_array = $coach_country_sql->fetch_all(1);
$count_coach_country = $coach_country_array[0]['count'];

$sql = "SELECT COUNT(`coachapplication_id`) AS `count`
        FROM `coachapplication`
        WHERE `coachapplication_ready`='0'
        AND `coachapplication_date`<UNIX_TIMESTAMP()-'24'*'60'*'60'";
$coach_application_sql = $mysqli->query($sql);

$coach_application_array = $coach_application_sql->fetch_all(1);
$coach_application_country = $coach_application_array[0]['count'];

if (isset($authorization_team_id))
{
    $sql = "SELECT COUNT(`coachapplication_id`) AS `count`
            FROM `coachapplication`
            LEFT JOIN `country`
            ON `country_id`=`coachapplication_country_id`
            LEFT JOIN `city`
            ON `city_country_id`=`country_id`
            LEFT JOIN `team`
            ON `team_city_id`=`city_id`
            WHERE `coachapplication_ready`='0'
            AND `coachapplication_date`<UNIX_TIMESTAMP()-'24'*'60'*'60'
            AND `team_id`='$authorization_team_id'";
    $my_coach_application_sql = $mysqli->query($sql);

    $my_coach_application_array = $my_coach_application_sql->fetch_all(1);
    $my_coach_application_country = $my_coach_application_array[0]['count'];
}
else
{
    $my_coach_application_country = 0;
}

if (0 == $count_shedule && 0 == $count_coach_country && 0 == $coach_application_country)
{
    $coach_link = '';
}
elseif (0 != $count_coach_country && 0 != $my_coach_application_country)
{
    $coach_link = 'national_coach_vote.php';
}
elseif (4 >= $count_shedule || (0 != $count_coach_country && 0 == $coach_application_country))
{
    $coach_link = 'national_coach_application.php';
}
else
{
    $coach_link = 'national_coach_vote.php';
}