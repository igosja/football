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

$sql = "SELECT `building_capacity`,
               `building_end_date`,
               `stadium_capacity`,
               `stadium_name`,
               `team_finance`
        FROM `stadium`
        LEFT JOIN `team`
        ON `team_id`=`stadium_team_id`
        LEFT JOIN
        (
            SELECT `building_capacity`,
                   `building_end_date`,
                   `building_team_id`
            FROM `building`
            WHERE `building_buildingtype_id`='3'
        ) AS `t1`
        ON `building_team_id`=`team_id`
        WHERE `stadium_team_id`='$num_get'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$team_finance = $stadium_array[0]['team_finance'];

if (isset($_GET['data']) &&
    isset($_GET['ok']) &&
    !$stadium_array[0]['building_capacity'])
{
    $ok             = (int) $_GET['ok'];
    $new_capacity   = (int) $_GET['data']['capacity'];
    $old_capacity   = $stadium_array[0]['stadium_capacity'];

    if (100 > $new_capacity)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Вместимоть трибун не может быть меньше 100 мест.';

        redirect('stadium.php');
    }

    if ($new_capacity <= $old_capacity)
    {
        $increase = 0;

        if (1 == $ok)
        {
            $sql = "UPDATE `stadium`
                    SET `stadium_capacity`='$new_capacity'
                    WHERE `stadium_team_id`='$num_get'
                    LIMIT 1";
            $mysqli->query($sql);

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Строительство прошло успешно.';

            redirect('team_team_information_condition.php?num=' . $num_get);
        }
    }

    $dif_capacity   = $new_capacity - $old_capacity;
    $price          = ($new_capacity + $dif_capacity) * 999;
    $increase       = 1;

    if ($team_finance < $price)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'У вашей команды недостаточно денег для расширения стадиона.';

        redirect('team_team_information_condition.php?num=' . $num_get);
    }

    if (1 == $ok)
    {
        $sql = "INSERT INTO `building`
                SET `building_capacity`='$new_capacity',
                    `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 30 DAY),
                    `building_buildingtype_id`='3',
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
                    `historyfinanceteam_historytext_id`='" .HISTORY_TEXT_EXPENCE_BUILD_STADIUM . "',
                    `historyfinanceteam_season_id`='$igosja_season_id',
                    `historyfinanceteam_team_id`='$num_get',
                    `historyfinanceteam_value`='$price'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Строительство началось успешно.';

        redirect('team_team_information_condition.php?num=' . $num_get);
    }
}

$header_title = $authorization_team_name;

include (__DIR__ . '/view/main.php');