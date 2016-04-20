<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `building_end_date`,
               `building_length`,
               `building_width`,
               `stadium_length`,
               `stadium_name`,
               `stadium_width`
        FROM `stadium`
        LEFT JOIN
        (
            SELECT `building_end_date`,
                   `building_length`,
                   `building_team_id`,
                   `building_width`
            FROM `building`
            WHERE `building_buildingtype_id`='5'
        ) AS `t1`
        ON `building_team_id`=`stadium_team_id`
        WHERE `stadium_team_id`='$get_num'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['data']) &&
    $_GET['ok'] &&
    !$stadium_array[0]['building_end_date'])
{
    $data   = $_GET['data'];
    $ok     = (int) $_GET['ok'];

    if (1 == $ok)
    {
        $length = (int) $data['length'];
        $width  = (int) $data['width'];

        if (100 > $length ||
            110 < $length ||
            64 > $width ||
            75 < $width)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Не правильно введены размеры поля.';

            redirect('fieldsize.php?num=' . $get_num);
        }

        $sql = "INSERT INTO `building`
                SET `building_buildingtype_id`='5',
                    `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 1 DAY),
                    `building_length`='$length',
                    `building_team_id`='$get_num',
                    `building_width`='$width'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Работы по смене размеров поля начались успешно.';

        redirect('team_team_information_condition.php?num=' . $get_num);
    }
}

$num            = $get_num;
$header_title   = $authorization_team_name;

include (__DIR__ . '/view/main.php');