<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['country_id']))
{
    $country_id = (int) $_POST['country_id'];
    $city_name  = $_POST['city_name'];

    $sql = "INSERT INTO `city`
            SET `city_name`=?,
                `city_country_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $city_name, $country_id);
    $prepare->execute();
    $prepare->close();

    redirect('city_list.php');
}

$sql = "SELECT `country_id`, `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('country_array', $country_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');