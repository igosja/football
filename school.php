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
               `team_school_level`,
               `team_finance`,
               `team_name`
        FROM `team`
        LEFT JOIN
        (
            SELECT `shedule_date`,
                   `building_team_id`
            FROM `building`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            WHERE `building_buildingtype_id`='2'
        ) AS `t1`
        ON `building_team_id`=`team_id`
        WHERE `team_id`='$num_get'";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(1);

$school_level   = $school_array[0]['team_school_level'];
$price          = pow($school_level + 1, 1.3) * 1000000;
$team_finance   = $school_array[0]['team_finance'];

if (isset($_GET['level']) &&
    isset($_GET['ok']) &&
    !$school_array[0]['shedule_date'])
{
    $level  = (int) $_GET['level'];
    $ok     = (int) $_GET['ok'];

    if (1 == $level)
    {
        if ($team_finance < $price)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'У вашей команды недостаточно денег для увеличения уровеня молодежной инфраструктуры.';

            redirect('school.php');
        }
        elseif ($school_level >= 10)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете максимальный уровень молодежной инфраструктуры.';

            redirect('school.php');
        }

        if (1 == $ok)
        {
            $sql = "INSERT INTO `building`
                    SET `building_shedule_id`=
                        (
                            SELECT `shedule_id`+'30'
                            FROM `shedule`
                            WHERE `shedule_date`=CURDATE()
                        ),
                        `building_buildingtype_id`='2',
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
                        `historyfinanceteam_historytext_id`='" .HISTORY_TEXT_EXPENCE_BUILD_SCHOOL . "',
                        `historyfinanceteam_season_id`='$igosja_season_id',
                        `historyfinanceteam_team_id`='$num_get',
                        `historyfinanceteam_value`='$price'";
            $mysqli->query($sql);

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Строительство началось успешно.';

            redirect('team_team_information_condition.php?num=' . $num_get);
        }
    }
    elseif (0 == $level)
    {
        if ($school_level <= 1)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете минимальный уровень тренировочной базы.';

            redirect('school.php');
        }

        if (1 == $ok)
        {
            $sql = "UPDATE `team`
                    SET `team_school_level`=`team_school_level`-'1'
                    WHERE `team_id`='$num_get'";
            $mysqli->query($sql);

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Строительство прошло успешно.';

            redirect('team_team_information_condition.php?num=' . $num_get);
        }
    }
}

$header_title       = $authorization_team_name;
$seo_title          = $header_title . '. Строительство спортшколы. ' . $seo_title;
$seo_description    = $header_title . '. Строительство спортшколы. ' . $seo_description;
$seo_keywords       = $header_title . ', строительство спортшколы, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');