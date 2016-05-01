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

$sql = "SELECT `building_end_date`,
               `team_training_level`,
               `team_finance`,
               `team_name`
        FROM `team`
        LEFT JOIN
        (
            SELECT `building_end_date`,
                   `building_team_id`
            FROM `building`
            WHERE `building_buildingtype_id`='1'
        ) AS `t1`
        ON `building_team_id`=`team_id`
        WHERE `team_id`='$num_get'";
$base_sql = $mysqli->query($sql);

$base_array = $base_sql->fetch_all(MYSQLI_ASSOC);

$base_level     = $base_array[0]['team_training_level'];
$price          = pow($base_level + 1, 1.3) * 1000000;
$team_finance   = $base_array[0]['team_finance'];

if (isset($_GET['level']) &&
    isset($_GET['ok']) &&
    !$base_array[0]['building_end_date'])
{
    $level  = (int) $_GET['level'];
    $ok     = (int) $_GET['ok'];

    if (1 == $level)
    {
        if ($team_finance < $price)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'У вашей команды недостаточно денег для увеличения уровеня тренировочной базы.';

            redirect('base.php');
        }
        elseif ($base_level >= 10)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете максимальный уровень тренировочной базы.';

            redirect('base.php');
        }

        if (1 == $ok)
        {
            $sql = "INSERT INTO `building`
                    SET `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 30 DAY),
                        `building_buildingtype_id`='1',
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

            $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);
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
                    SET `historyfinanceteam_date`=SYSDATE(),
                        `historyfinanceteam_historytext_id`='" .HISTORY_TEXT_EXPENCE_BUILD_TRAINING . "',
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
        if ($base_level <= 1)
        {
            $_SESSION['message_class']  = 'info';
            $_SESSION['message_text']   = 'Вы имеете минимальный уровень тренировочной базы.';

            redirect('base.php');
        }

        if (1 == $ok)
        {
            $sql = "UPDATE `team`
                    SET `team_training_level`=`team_training_level`-'1'
                    WHERE `team_id`='$num_get'";
            $mysqli->query($sql);

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Строительство прошло успешно.';

            redirect('team_team_information_condition.php?num=' . $num_get);
        }
    }
}

$header_title       = $authorization_team_name;
$seo_title          = $authorization_team_name . '. База команды. ' . $seo_title;
$seo_description    = $authorization_team_name . '. База команды. ' . $seo_description;
$seo_keywords       = $authorization_team_name . ', база команды, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');