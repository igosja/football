<?php

include ('../include/include.php');

if (isset($_POST['weather_name']))
{
    $weather_name = $_POST['weather_name'];

    $sql = "INSERT INTO `weather`
            SET `weather_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $weather_name);
    $prepare->execute();
    $prepare->close();

    $weather_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['weather_logo']['type'])
    {
        copy($_FILES['weather_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/' . $weather_id . '.png');
    }

    if ('image/png' == $_FILES['weather_logo_12']['type'])
    {
        copy($_FILES['weather_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/12/' . $weather_id . '.png');
    }

    redirect('weather_list.php');

    exit;
}

$smarty->display('admin_main.html');