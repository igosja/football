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
               `building_length`,
               `building_width`,
               `stadium_length`,
               `stadium_name`,
               `stadium_width`
        FROM `stadium`
        LEFT JOIN
        (
            SELECT `shedule_date`,
                   `building_length`,
                   `building_team_id`,
                   `building_width`
            FROM `building`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            WHERE `building_buildingtype_id`='5'
        ) AS `t1`
        ON `building_team_id`=`stadium_team_id`
        WHERE `stadium_team_id`='$num_get'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(1);

if (isset($_GET['data']) &&
    isset($_GET['ok']) &&
    !$stadium_array[0]['shedule_date'])
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

            redirect('fieldsize.php?num=' . $num_get);
        }

        $sql = "INSERT INTO `building`
                SET `building_buildingtype_id`='5',
                    `building_shedule_id`=
                    (
                        SELECT `shedule_id`+'1'
                        FROM `shedule`
                        WHERE `shedule_date`=CURDATE()
                    ),
                    `building_length`='$length',
                    `building_team_id`='$num_get',
                    `building_width`='$width'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Работы по смене размеров поля начались успешно.';

        redirect('team_team_information_condition.php?num=' . $num_get);
    }
}

$num                = $num_get;
$header_title       = $authorization_team_name;
$seo_title          = $authorization_team_name . '. Изменение размеров поля. ' . $seo_title;
$seo_description    = $authorization_team_name . '. Изменение размеров поля. ' . $seo_description;
$seo_keywords       = $authorization_team_name . ', изменение размеров поля, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');