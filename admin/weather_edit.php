<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `weather_name`
        FROM `weather`
        WHERE `weather_id`='$num_get'
        LIMIT 1";
$weather_sql = $mysqli->query($sql);

$count_weather = $weather_sql->num_rows;

if (0 == $count_weather)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_POST['weather_name']))
{
    $weather_name = $_POST['weather_name'];

    $sql = "UPDATE `weather` 
            SET `weather_name`=?
            WHERE `weather_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $weather_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['weather_logo']['type'])
    {
        copy($_FILES['weather_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['weather_logo_12']['type'])
    {
        copy($_FILES['weather_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/12/' . $num_get . '.png');
    }

    redirect('weather_list.php');
}

$weather_array = $weather_sql->fetch_all(MYSQLI_ASSOC);

$weather_name   = $weather_array[0]['weather_name'];
$tpl            = 'weather_create';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');