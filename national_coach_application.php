<?php

include (__DIR__ . '/include/include.php');

if ('national_coach_application.php' != $coach_link)
{
    redirect('index.php');
}

if (!isset($authorization_user_id))
{
    include (__DIR__ . '/view/only_logged.php');
    exit;
}

if (isset($_POST['country_id']))
{
    $country_id = (int) $_POST['country_id'];
    $text       = strip_tags($_POST['text']);

    $sql = "SELECT COUNT(`coachapplication_id`) AS `count`
            FROM `coachapplication`
            WHERE `coachapplication_country_id`='$country_id'
            AND `coachapplication_season_id`='$igosja_season_id'
            AND `coachapplication_user_id`='$authorization_user_id'";
    $count_sql = $mysqli->query($sql);

    $count_array = $count_sql->fetch_all(1);

    $count = $count_array[0]['count'];

    if (0 == $count)
    {
        $sql = "INSERT INTO `coachapplication`
                SET `coachapplication_country_id`='$country_id',
                    `coachapplication_date`=UNIX_TIMESTAMP(),
                    `coachapplication_season_id`='$igosja_season_id',
                    `coachapplication_text`=?,
                    `coachapplication_user_id`='$authorization_user_id'";
    }
    else
    {
        $sql = "UPDATE `coachapplication`
                SET `coachapplication_date`=UNIX_TIMESTAMP(),
                    `coachapplication_text`=?
                WHERE `coachapplication_country_id`='$country_id'
                AND `coachapplication_season_id`='$igosja_season_id'
                AND `coachapplication_user_id`='$authorization_user_id'
                LIMIT 1";
    }

    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $text);
    $prepare->execute();
    $prepare->close();

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Ваша заявка успешно сохранена.';

    redirect('national_coach_application.php');
}

$sql = "SELECT `country_id`,
               `country_name`,
               IF (`count` IS NOT NULL, `count`, '0') AS `count`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT COUNT(`coachapplication_id`) AS `count`,
                   `coachapplication_country_id`
            FROM `coachapplication`
            WHERE `coachapplication_season_id`='$igosja_season_id'
            AND `coachapplication_ready`='0'
            GROUP BY `coachapplication_country_id`
        ) AS `t1`
        ON `coachapplication_country_id`=`country_id`
        WHERE `city_id`!='0'
        AND `country_user_id`='0'
        GROUP BY `country_id`
        ORDER BY `country_name` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$country_id = $country_array[0]['country_id'];

$sql = "SELECT `coachapplication_text`
        FROM `coachapplication`
        WHERE `coachapplication_country_id`='$country_id'
        AND `coachapplication_season_id`='$igosja_season_id'
        AND `coachapplication_user_id`='$authorization_user_id'";
$application_sql = $mysqli->query($sql);

$application_array = $application_sql->fetch_all(1);

$header_title       = 'Выборы';
$seo_title          = $header_title . ' тренеров национальных сборных. Подача заявок. ' . $seo_title;
$seo_description    = $header_title . ' тренеров национальных сборных. Подача заявок. ' . $seo_description;
$seo_keywords       = $header_title . ' тренеров национальных сборных, Подача заявок. ' . $seo_keywords;

include (__DIR__ . '/view/main.php');