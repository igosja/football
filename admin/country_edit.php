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

$sql = "SELECT `country_continent_id`,
               `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['continent_id']))
{
    $continent_id = (int) $_POST['continent_id'];
    $country_name = $_POST['country_name'];

    $sql = "UPDATE `country` 
            SET `country_name`=?, 
                `country_continent_id`=?
            WHERE `country_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $country_name, $continent_id);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['country_flag_90']['type'])
    {
        copy($_FILES['country_flag_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/90/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['country_flag_50']['type'])
    {
        copy($_FILES['country_flag_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/50/' . $num_get . '.png');
    }

    if ('image/png' == $_FILES['country_flag_12']['type'])
    {
        copy($_FILES['country_flag_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/flag/12/' . $num_get . '.png');
    }

    redirect('country_list.php');
}

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `continent_id`,
               `continent_name`
        FROM `continent`
        ORDER BY `continent_id` ASC";
$continent_sql = $mysqli->query($sql);

$continent_array = $continent_sql->fetch_all(1);

$tpl = 'country_create';

include (__DIR__ . '/../view/admin_main.php');