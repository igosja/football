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

$sql = "SELECT `stage_name`
        FROM `stage`
        WHERE `stage_id`='$num_get'
        LIMIT 1";
$stage_sql = $mysqli->query($sql);

$count_stage = $stage_sql->num_rows;

if (0 == $count_stage)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['stage_name']))
{
    $stage_name = $_POST['stage_name'];

    $sql = "UPDATE `stage` 
            SET `stage_name`=?
            WHERE `stage_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stage_name);
    $prepare->execute();
    $prepare->close();

    redirect('stage_list.php');
}

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'stage_create';

include (__DIR__ . '/../view/admin_main.php');