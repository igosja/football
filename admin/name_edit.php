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

$sql = "SELECT `countryname_country_id`, `name_name`
        FROM `name`
        LEFT JOIN `countryname`
        ON `name_id`=`countryname_name_id`
        WHERE `name_id`='$get_num'
        LIMIT 1";
$name_sql = $mysqli->query($sql);

$count_name = $name_sql->num_rows;

if (0 == $count_name)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['name_name']))
{
    $country_id = (int) $_POST['country_id'];
    $name_name  = $_POST['name_name'];

    $sql = "UPDATE `name` 
            SET `name_name`=?
            WHERE `name_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $name_name);
    $prepare->execute();
    $prepare->close();

    $sql = "SELECT `countryname_id`
            FROM `countryname`
            WHERE `countryname_name_id`='$get_num'
            AND `countryname_country_id`='$country_id'
            LIMIT 1";
    $check_sql = $mysqli->query($sql);

    $count_check = $check_sql->num_rows;

    if (0 == $count_check)
    {
        $sql = "INSERT INTO `countryname`
                SET `countryname_name_id`='$get_num',
                    `countryname_country_id`='$country_id'";
        $mysqli->query($sql);
    }

    redirect('name_list.php');

    exit;
}

$name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

$name_name  = $name_array[0]['name_name'];
$country_id = $name_array[0]['countryname_country_id'];

$sql = "SELECT `country_id`, `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('country_id', $country_id);
$smarty->assign('name_name', $name_name);
$smarty->assign('country_array', $country_array);
$smarty->assign('tpl', 'name_create');

$smarty->display('admin_main.html');