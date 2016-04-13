<?php

include ('include/include.php');

if ('national_coach_application.php' != $coach_link)
{
    redirect('index.php');
}

if (!isset($authorization_user_id))
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/only_logged.php');
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

    $count_array = $count_sql->fetch_all(MYSQLI_ASSOC);

    $count = $count_array[0]['count'];

    if (0 == $count)
    {
        $sql = "INSERT INTO `coachapplication`
                SET `coachapplication_country_id`='$country_id',
                    `coachapplication_date`=SYSDATE(),
                    `coachapplication_season_id`='$igosja_season_id',
                    `coachapplication_text`=?,
                    `coachapplication_user_id`='$authorization_user_id'";
    }
    else
    {
        $sql = "UPDATE `coachapplication`
                SET `coachapplication_date`=SYSDATE(),
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
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `city_id`!='0'
        GROUP BY `country_id`
        ORDER BY `country_name` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_id = $country_array[0]['country_id'];

$sql = "SELECT `coachapplication_text`
        FROM `coachapplication`
        WHERE `coachapplication_country_id`='$country_id'
        AND `coachapplication_season_id`='$igosja_season_id'
        AND `coachapplication_user_id`='$authorization_user_id'";
$application_sql = $mysqli->query($sql);

$application_array = $application_sql->fetch_all(MYSQLI_ASSOC);

$header_title = 'Выборы';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');