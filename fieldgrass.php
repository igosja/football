<?php

include('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `building_end_date`,
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
            SELECT `building_end_date`,
                   `building_team_id`
            FROM `building`
            WHERE `building_buildingtype_id`='4'
        ) AS `t1`
        ON `building_team_id`=`stadium_team_id`
        WHERE `stadium_team_id`='$get_num'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$price          = 1000;
$team_finance   = $stadium_array[0]['team_finance'];

if (isset($_GET['change']) &&
    !$stadium_array[0]['building_end_date'])
{
    if ($team_finance < $price)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'У вашей команды недостаточно денег для замены газона.';

        redirect('fieldgrass.php');
        exit;
    }

    $sql = "INSERT INTO `building`
            SET `building_buildingtype_id`='4',
                `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 1 DAY),
                `building_team_id`='$get_num'";
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
    $_SESSION['message_text']   = 'Работы по замене газона начались успешно.';

    redirect('team_team_information_condition.php?num=' . $get_num);
    exit;
}

$smarty->assign('header_title', $authorization_team_name);
$smarty->assign('stadium_array', $stadium_array);
$smarty->assign('price', $price);
$smarty->assign('team_finance', $team_finance);

$smarty->display('main.html');