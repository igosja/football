<?php

include ('../include/include.php');

if (isset($_POST['continent_id']))
{
    $continent_id = (int) $_POST['continent_id'];
    $country_name = $_POST['country_name'];

    $sql = "INSERT INTO `country`
            SET `country_name`=?,
                `country_continent_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $country_name, $continent_id);
    $prepare->execute();
    $prepare->close();

    $country_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['country_flag_90']['type'])
    {
        copy($_FILES['country_flag_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/90/' . $country_id . '.png');
    }

    if ('image/png' == $_FILES['country_flag_50']['type'])
    {
        copy($_FILES['country_flag_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/50/' . $country_id . '.png');
    }

    if ('image/png' == $_FILES['country_flag_12']['type'])
    {
        copy($_FILES['country_flag_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/12/' . $country_id . '.png');
    }

    redirect('country_list.php');

    exit;
}

$sql = "SELECT `continent_id`, `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('continent_array', $continent_array);

$smarty->display('admin_main.html');