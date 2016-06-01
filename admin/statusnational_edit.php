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

$sql = "SELECT `statusnational_name`
        FROM `statusnational`
        WHERE `statusnational_id`='$num_get'
        LIMIT 1";
$statusnational_sql = $mysqli->query($sql);

$count_statusnational = $statusnational_sql->num_rows;

if (0 == $count_statusnational)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['statusnational_name']))
{
    $statusnational_name = $_POST['statusnational_name'];

    $sql = "UPDATE `statusnational` 
            SET `statusnational_name`=?
            WHERE `statusnational_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusnational_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusnational_list.php');
}

$statusnational_array = $statusnational_sql->fetch_all(1);

$tpl = 'statusnational_create';

include (__DIR__ . '/../view/admin_main.php');