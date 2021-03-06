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

$sql = "SELECT `statusrent_name`
        FROM `statusrent`
        WHERE `statusrent_id`='$num_get'
        LIMIT 1";
$statusrent_sql = $mysqli->query($sql);

$count_statusrent = $statusrent_sql->num_rows;

if (0 == $count_statusrent)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['statusrent_name']))
{
    $statusrent_name = $_POST['statusrent_name'];

    $sql = "UPDATE `statusrent` 
            SET `statusrent_name`=?
            WHERE `statusrent_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusrent_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusrent_list.php');
}

$statusrent_array = $statusrent_sql->fetch_all(1);

$tpl = 'statusrent_create';

include (__DIR__ . '/../view/admin_main.php');