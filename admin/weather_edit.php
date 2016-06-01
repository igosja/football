<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `weather_id`,
               `weather_name`
        FROM `weather`
        WHERE `weather_id`='$num_get'
        LIMIT 1";
$weather_sql = $mysqli->query($sql);

$count_weather = $weather_sql->num_rows;

if (0 == $count_weather)
{
    include (__DIR__ . '/../view/wrong_page.php');
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
        copy($_FILES['weather_logo']['tmp_name'], __DIR__ . '/../img/weather/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['weather_logo_12']['type'])
    {
        copy($_FILES['weather_logo_12']['tmp_name'], __DIR__ . '/../img/weather/12/' . $num_get . '.png');
    }

    redirect('weather_list.php');
}

$weather_array = $weather_sql->fetch_all(1);

$tpl            = 'weather_create';

include (__DIR__ . '/../view/admin_main.php');