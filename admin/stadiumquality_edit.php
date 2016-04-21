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

$sql = "SELECT `stadiumquality_name`
        FROM `stadiumquality`
        WHERE `stadiumquality_id`='$num_get'
        LIMIT 1";
$stadiumquality_sql = $mysqli->query($sql);

$count_stadiumquality = $stadiumquality_sql->num_rows;

if (0 == $count_stadiumquality)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['stadiumquality_name']))
{
    $stadiumquality_name = $_POST['stadiumquality_name'];

    $sql = "UPDATE `stadiumquality` 
            SET `stadiumquality_name`=?
            WHERE `stadiumquality_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stadiumquality_name);
    $prepare->execute();
    $prepare->close();

    redirect('stadiumquality_list.php');
}

$stadiumquality_array = $stadiumquality_sql->fetch_all(MYSQLI_ASSOC);

$stadiumquality_name = $stadiumquality_array[0]['stadiumquality_name'];

$smarty->assign('stadiumquality_name', $stadiumquality_name);
$smarty->assign('tpl', 'stadiumquality_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');