<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `shedule_date`,
               `stadium_name`,
               `stadiumquality_name`,
               `team_finance`
        FROM `stadium`
        LEFT JOIN `stadiumquality`
        ON `stadiumquality_id`=`stadium_stadiumquality_id`
        LEFT JOIN `team`
        ON `team_id`=`stadium_team_id`
        LEFT JOIN
        (
            SELECT `shedule_date`,
                   `building_team_id`
            FROM `building`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            WHERE `building_buildingtype_id`='4'
        ) AS `t1`
        ON `building_team_id`=`stadium_team_id`
        WHERE `stadium_team_id`='$num_get'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

$price          = 1000;
$team_finance   = $stadium_array[0]['team_finance'];

if (isset($_GET['change']) &&
    isset($_GET['ok']) &&
    !$stadium_array[0]['shedule_date'])
{
    if ($team_finance < $price)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'У вашей команды недостаточно денег для замены газона.';

        redirect('fieldgrass.php');
    }

    $change = (int) $_GET['change'];
    $ok     = (int) $_GET['ok'];

    if (1 == $ok)
    {
        $sql = "INSERT INTO `building`
                SET `building_buildingtype_id`='4',
                    `building_shedule_id`=
                    (
                        SELECT `shedule_id`+'1'
                        FROM `shedule`
                        WHERE `shedule_date`=CURDATE()
                    ),
                    `building_team_id`='$num_get'";
        $mysqli->query($sql);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`-'$price'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "SELECT COUNT(`finance_id`) AS `count`
                FROM `finance`
                WHERE `finance_season_id`='$igosja_season_id'
                AND `finance_team_id`='$num_get'
                LIMIT 1";
        $finance_sql = $mysqli->query($sql);

        $finance_array = $finance_sql->fetch_all(1);
        $count_finance = $finance_array[0]['count'];

        if (0 == $count_finance)
        {
            $sql = "INSERT INTO `finance`
                    SET `finance_expense_build`='$price',
                        `finance_team_id`='$num_get',
                        `finance_season_id`='$igosja_season_id'";
            $mysqli->query($sql);
        }
        else
        {
            $sql = "UPDATE `finance`
                    SET `finance_expense_build`=`finance_expense_build`+'$price'
                    WHERE `finance_team_id`='$num_get'
                    AND `finance_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $sql = "INSERT INTO `historyfinanceteam`
                SET `historyfinanceteam_date`=UNIX_TIMESTAMP(),
                    `historyfinanceteam_historytext_id`='" .HISTORY_TEXT_EXPENCE_BUILD_GRASS . "',
                    `historyfinanceteam_season_id`='$igosja_season_id',
                    `historyfinanceteam_team_id`='$num_get',
                    `historyfinanceteam_value`='$price'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Работы по замене газона начались успешно.';

        redirect('team_team_information_condition.php?num=' . $num_get);
    }
}

$num                = $num_get;
$header_title       = $authorization_team_name;
$seo_title          = $authorization_team_name . '. Замена газона. ' . $seo_title;
$seo_description    = $authorization_team_name . '. Замена газона. ' . $seo_description;
$seo_keywords       = $authorization_team_name . ', замена газона, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');