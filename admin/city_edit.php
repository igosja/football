<?php

include ('../include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `city_country_id`, `city_name`
        FROM `city`
        WHERE `city_id`='$get_num'
        LIMIT 1";
$city_sql = $mysqli->query($sql);

$count_city = $city_sql->num_rows;

if (0 == $count_city)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['country_id']))
{
    $country_id = (int) $_POST['country_id'];
    $city_name  = $_POST['city_name'];

    $sql = "UPDATE `city` 
            SET `city_name`=?, 
                `city_country_id`=?
            WHERE `city_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $city_name, $country_id);
    $prepare->execute();
    $prepare->close();

    redirect('city_list.php');

    exit;
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

$smarty->display('admin_main.html');