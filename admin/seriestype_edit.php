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

$sql = "SELECT `seriestype_name`
        FROM `seriestype`
        WHERE `seriestype_id`='$num_get'
        LIMIT 1";
$seriestype_sql = $mysqli->query($sql);

$count_seriestype = $seriestype_sql->num_rows;

if (0 == $count_seriestype)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['seriestype_name']))
{
    $seriestype_name = $_POST['seriestype_name'];

    $sql = "UPDATE `seriestype` 
            SET `seriestype_name`=?
            WHERE `seriestype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $seriestype_name);
    $prepare->execute();
    $prepare->close();

    redirect('seriestype_list.php');
}

$seriestype_array = $seriestype_sql->fetch_all(1);

$tpl = 'seriestype_create';

include (__DIR__ . '/../view/admin_main.php');