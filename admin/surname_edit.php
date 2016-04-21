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

$sql = "SELECT `countrysurname_country_id`, `surname_name`
        FROM `surname`
        LEFT JOIN `countrysurname`
        ON `surname_id`=`countrysurname_surname_id`
        WHERE `surname_id`='$num_get'
        LIMIT 1";
$surname_sql = $mysqli->query($sql);

$count_surname = $surname_sql->num_rows;

if (0 == $count_surname)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['surname_name']))
{
    $country_id     = (int) $_POST['country_id'];
    $surname_name   = $_POST['surname_name'];

    $sql = "UPDATE `surname` 
            SET `surname_name`=?
            WHERE `surname_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $surname_name);
    $prepare->execute();
    $prepare->close();

    $sql = "SELECT `countrysurname_id`
            FROM `countrysurname`
            WHERE `countrysurname_surname_id`='$num_get'
            AND `countrysurname_country_id`='$country_id'
            LIMIT 1";
    $check_sql = $mysqli->query($sql);

    $count_check = $check_sql->num_rows;

    if (0 == $count_check)
    {
        $sql = "INSERT INTO `countrysurname`
                SET `countrysurname_surname_id`='$num_get',
                    `countrysurname_country_id`='$country_id'";
        $mysqli->query($sql);
    }

    redirect('surname_list.php');
}

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$surname_name   = $surname_array[0]['surname_name'];
$country_id     = $surname_array[0]['countrysurname_country_id'];

$sql = "SELECT `country_id`, `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('country_id', $country_id);
$smarty->assign('surname_name', $surname_name);
$smarty->assign('country_array', $country_array);
$smarty->assign('tpl', 'surname_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');