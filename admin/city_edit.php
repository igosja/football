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

$sql = "SELECT `city_country_id`, `city_name`
        FROM `city`
        WHERE `city_id`='$num_get'
        LIMIT 1";
$city_sql = $mysqli->query($sql);

$count_city = $city_sql->num_rows;

if (0 == $count_city)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

if (isset($_POST['country_id']))
{
    $country_id = (int) $_POST['country_id'];
    $city_name  = $_POST['city_name'];

    $sql = "UPDATE `city` 
            SET `city_name`=?, 
                `city_country_id`=?
            WHERE `city_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $city_name, $country_id);
    $prepare->execute();
    $prepare->close();

    redirect('city_list.php');
}

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$city_name  = $city_array[0]['city_name'];
$country_id = $city_array[0]['city_country_id'];

$sql = "SELECT `country_id`, `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('city_name', $city_name);
$smarty->assign('country_id', $country_id);
$smarty->assign('country_array', $country_array);
$smarty->assign('tpl', 'city_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');