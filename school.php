<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include($_SERVER['DOCUMENT_ROOT'] . '/view/only_my_team.html');
    exit;
}

$sql = "SELECT `building_end_date`,
               `team_school_level`,
               `team_finance`,
               `team_name`
        FROM `team`
        LEFT JOIN
        (
            SELECT `building_end_date`,
                   `building_team_id`
            FROM `building`
            WHERE `building_buildingtype_id`='2'
        ) AS `t1`
        ON `building_team_id`=`team_id`
        WHERE `team_id`='$get_num'";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

$school_level   = $school_array[0]['team_school_level'];
$price          = pow($school_level + 1, 1.3) * 1000000;
$team_finance   = $school_array[0]['team_finance'];

if (isset($_GET['level']) &&
    !$school_array[0]['building_end_date'])
{
    $level = (int) $_GET['level'];

    if (1 == $level)
    {
        if ($team_finance < $price)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'У вашей команды недостаточно денег для увеличения уровеня молодежной инфраструктуры.';

            redirect('school.php');
            exit;
        }
        elseif ($school_level >= 10)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете максимальный уровень молодежной инфраструктуры.';

            redirect('school.php');
            exit;
        }

        $sql = "INSERT INTO `building`
                SET `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 30 DAY),
                    `building_buildingtype_id`='2',
                    `building_team_id`='$get_num'";
        $mysqli->query($sql);

        $sql = "INSERT INTO `historyfinanceteam`
                SET `historyfinanceteam_date`=SYSDATE(),
                    `historyfinanceteam_historytext_id`='4',
                    `historyfinanceteam_team_id`='$get_num',
                    `historyfinanceteam_value`='$price'";
        $mysqli->query($sql);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`-'$price'
                WHERE `team_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "SELECT COUNT(`finance_id`) AS `count`
                FROM `finance`
                WHERE `finance_season_id`='$igosja_season_id'
                AND `finance_team_id`='$get_num'
                LIMIT 1";
        $finance_sql = $mysqli->query($sql);

        $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);
        $count_finance = $finance_array[0]['count'];

        if (0 == $count_finance)
        {
            $sql = "INSERT INTO `finance`
                    SET `finance_expense_build`='$price',
                        `finance_team_id`='$get_num',
                        `finance_season_id`='$igosja_season_id'";
            $mysqli->query($sql);
        }
        else
        {
            $sql = "UPDATE `finance`
                    SET `finance_expense_build`='$price'
                    WHERE `finance_team_id`='$get_num'
                    AND `finance_season_id`='$igosja_season_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Строительство началось успешно.';

        redirect('team_team_information_condition.php?num=' . $get_num);
        exit;
    }
    elseif (0 == $level)
    {
        if ($school_level <= 1)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете минимальный уровень тренировочной базы.';

            redirect('school.php');
            exit;
        }

        $sql = "UPDATE `team`
                SET `team_school_level`=`team_school_level`-'1'
                WHERE `team`='$get_num'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Строительство прошло успешно.';

        redirect('team_team_information_condition.php?num=' . $get_num);
        exit;
    }
}

$header_title = $authorization_team_name;

include($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');