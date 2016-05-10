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

$sql = "SELECT `countryname_country_id`,
               `name_name`
        FROM `name`
        LEFT JOIN `countryname`
        ON `name_id`=`countryname_name_id`
        WHERE `name_id`='$num_get'
        LIMIT 1";
$name_sql = $mysqli->query($sql);

$count_name = $name_sql->num_rows;

if (0 == $count_name)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['name_name']))
{
    $country_id = (int) $_POST['country_id'];
    $name_name  = $_POST['name_name'];

    $sql = "UPDATE `name` 
            SET `name_name`=?
            WHERE `name_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $name_name);
    $prepare->execute();
    $prepare->close();

    $sql = "SELECT `countryname_id`
            FROM `countryname`
            WHERE `countryname_name_id`='$num_get'
            AND `countryname_country_id`='$country_id'
            LIMIT 1";
    $check_sql = $mysqli->query($sql);

    $count_check = $check_sql->num_rows;

    if (0 == $count_check)
    {
        $sql = "INSERT INTO `countryname`
                SET `countryname_name_id`='$num_get',
                    `countryname_country_id`='$country_id'";
        $mysqli->query($sql);
    }

    redirect('name_list.php');
}

$name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);
$tpl = 'name_create';

include (__DIR__ . '/../view/admin_main.php');