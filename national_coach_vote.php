<?php

include (__DIR__ . '/include/include.php');

if ('national_coach_vote.php' != $coach_link)
{
    redirect('index.php');
}

if (!isset($authorization_user_id))
{
    include (__DIR__ . '/view/only_logged.php');
    exit;
}

if (isset($_POST['application_id']))
{
    $application_id = (int) $_POST['application_id'];

    $sql = "SELECT COUNT(`coachvote_id`) AS `count`
            FROM `coachvote`
            WHERE `coachvote_user_id`='$authorization_user_id'
            AND `coachvote_season_id`='$igosja_season_id'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count = $count_array[0]['count'];

    if (0 != $count)
    {
        redirect('national_coach_vote.php');
    }

    $sql = "INSERT INTO `coachvote`
            SET `coachvote_coachapplication_id`='$application_id',
                `coachvote_date`=UNIX_TIMESTAMP(),
                `coachvote_season_id`='$igosja_season_id',
                `coachvote_user_id`='$authorization_user_id'";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Ваша голос успешно сохранен.';

    redirect('national_coach_vote.php');
}

$sql = "SELECT `coachapplication_text`,
               `coachapplication_id`,
               `count`,
               `team_name`,
               `team_id`,
               `user_login`,
               `user_national`,
               `user_registration_date`,
               `user_team`
        FROM `coachapplication`
        LEFT JOIN `user`
        ON `user_id`=`coachapplication_user_id`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        LEFT JOIN
        (
            SELECT COUNT(`coachvote_id`) AS `count`,
                   `coachvote_coachapplication_id`
            FROM `coachvote`
            WHERE `coachvote_season_id`='$igosja_season_id'
            GROUP BY `coachvote_coachapplication_id`
        ) AS `t1`
        ON `coachvote_coachapplication_id`=`coachapplication_id`
        WHERE `coachapplication_season_id`='$igosja_season_id'
        AND `coachapplication_country_id`=
        (
            SELECT `city_country_id`
            FROM `city`
            LEFT JOIN `team`
            ON `team_city_id`=`city_id`
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1
        )
        ORDER BY `count` DESC";
$application_sql = $mysqli->query($sql);

$application_array = $application_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`coachvote_id`) AS `count`
        FROM `coachvote`
        WHERE `coachvote_user_id`='$authorization_user_id'
        AND `coachvote_season_id`='$igosja_season_id'";
$coachvote_sql = $mysqli->query($sql);

$coachvote_array = $coachvote_sql->fetch_all(MYSQLI_ASSOC);

$header_title       = 'Выборы';
$seo_title          = $header_title . ' тренеров национальных сборных. ' . $seo_title;
$seo_description    = $header_title . ' тренеров национальных сборных. ' . $seo_description;
$seo_keywords       = $header_title . ' тренеров национальных сборных, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');