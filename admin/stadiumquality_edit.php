<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `stadiumquality_name`
        FROM `stadiumquality`
        WHERE `stadiumquality_id`='$get_num'
        LIMIT 1";
$stadiumquality_sql = $mysqli->query($sql);

$count_stadiumquality = $stadiumquality_sql->num_rows;

if (0 == $count_stadiumquality)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['stadiumquality_name']))
{
    $stadiumquality_name = $_POST['stadiumquality_name'];

    $sql = "UPDATE `stadiumquality` 
            SET `stadiumquality_name`=?
            WHERE `stadiumquality_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stadiumquality_name);
    $prepare->execute();
    $prepare->close();

    redirect('stadiumquality_list.php');

    exit;
}

$stadiumquality_array = $stadiumquality_sql->fetch_all(MYSQLI_ASSOC);

$stadiumquality_name = $stadiumquality_array[0]['stadiumquality_name'];

$smarty->assign('stadiumquality_name', $stadiumquality_name);
$smarty->assign('tpl', 'stadiumquality_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');