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

$sql = "SELECT `statusteam_name`
        FROM `statusteam`
        WHERE `statusteam_id`='$num_get'
        LIMIT 1";
$statusteam_sql = $mysqli->query($sql);

$count_statusteam = $statusteam_sql->num_rows;

if (0 == $count_statusteam)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['statusteam_name']))
{
    $statusteam_name = $_POST['statusteam_name'];

    $sql = "UPDATE `statusteam` 
            SET `statusteam_name`=?
            WHERE `statusteam_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusteam_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusteam_list.php');
}

$statusteam_array = $statusteam_sql->fetch_all(MYSQLI_ASSOC);

$statusteam_name = $statusteam_array[0]['statusteam_name'];

$smarty->assign('statusteam_name', $statusteam_name);
$smarty->assign('tpl', 'statusteam_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');