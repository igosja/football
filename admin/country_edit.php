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

$sql = "SELECT `country_continent_id`, `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['continent_id']))
{
    $continent_id = (int) $_POST['continent_id'];
    $country_name = $_POST['country_name'];

    $sql = "UPDATE `country` 
            SET `country_name`=?, 
                `country_continent_id`=?
            WHERE `country_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $country_name, $continent_id);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['country_flag']['type'])
    {
        copy($_FILES['country_flag']['tmp_name'], '../img/flag/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['country_flag_90']['type'])
    {
        copy($_FILES['country_flag_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/90/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['country_flag_50']['type'])
    {
        copy($_FILES['country_flag_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/50/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['country_flag_12']['type'])
    {
        copy($_FILES['country_flag_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/12/' . $get_num . '.png');
    }

    redirect('country_list.php');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];
$continent_id = $country_array[0]['country_continent_id'];

$sql = "SELECT `continent_id`, `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('country_name', $country_name);
$smarty->assign('continent_id', $continent_id);
$smarty->assign('continent_array', $continent_array);
$smarty->assign('tpl', 'country_create');

$smarty->display('admin_main.html');