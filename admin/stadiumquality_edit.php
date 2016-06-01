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

$sql = "SELECT `stadiumquality_name`
        FROM `stadiumquality`
        WHERE `stadiumquality_id`='$num_get'
        LIMIT 1";
$stadiumquality_sql = $mysqli->query($sql);

$count_stadiumquality = $stadiumquality_sql->num_rows;

if (0 == $count_stadiumquality)
{
    include (__DIR__ . '/../view/wrong_page.php');
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

$stadiumquality_array = $stadiumquality_sql->fetch_all(1);

$tpl = 'stadiumquality_create';

include (__DIR__ . '/../view/admin_main.php');