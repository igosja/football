<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `weather_name`
        FROM `weather`
        WHERE `weather_id`='$get_num'
        LIMIT 1";
$weather_sql = $mysqli->query($sql);

$count_weather = $weather_sql->num_rows;

if (0 == $count_weather)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['weather_name']))
{
    $weather_name = $_POST['weather_name'];

    $sql = "UPDATE `weather` 
            SET `weather_name`=?
            WHERE `weather_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $weather_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['weather_logo']['type'])
    {
        copy($_FILES['weather_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['weather_logo_12']['type'])
    {
        copy($_FILES['weather_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/weather/12/' . $get_num . '.png');
    }

    redirect('weather_list.php');

    exit;
}

$weather_array = $weather_sql->fetch_all(MYSQLI_ASSOC);

$weather_name = $weather_array[0]['weather_name'];

$smarty->assign('weather_name', $weather_name);
$smarty->assign('tpl', 'weather_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');