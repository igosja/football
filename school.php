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

if (isset($_GET['level']) &&
    !$school_array[0]['building_end_date'])
{
    $level          = (int)$_GET['level'];
    $school_level   = $school_array[0]['team_school_level'];

    if (1 == $level)
    {
        $price          = pow($school_level + 1, 1.3) * 1000000;
        $team_finance   = $school_array[0]['team_finance'];

        if ($team_finance >= $price && $school_level < 10)
        {
            $sql = "INSERT INTO `building`
                    SET `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 30 DAY),
                        `building_buildingtype_id`='2',
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

            redirect('team_team_information_condition.php?num=' . $get_num);
            exit;
        }
        else
        {
            $error_message = 'У вашей команды недостаточно денег для увеличения уровеня молодежнои инфраструктуры';

            $smarty->assign('error_message', $error_message);
        }
    }
    elseif (0 == $level)
    {
        $sql = "UPDATE `team`
                SET `team_school_level`=`team_school_level`-'1'
                WHERE `team`='$get_num'";
        $mysqli->query($sql);

        redirect('team_team_information_condition.php?num=' . $get_num);
        exit;
    }
}

$smarty->assign('header_title', $authorization_team_name);
$smarty->assign('school_array', $school_array);

$smarty->display('main.html');