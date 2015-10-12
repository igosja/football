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

$sql = "SELECT `statusteam_name`
        FROM `statusteam`
        WHERE `statusteam_id`='$get_num'
        LIMIT 1";
$statusteam_sql = $mysqli->query($sql);

$count_statusteam = $statusteam_sql->num_rows;

if (0 == $count_statusteam)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['statusteam_name']))
{
    $statusteam_name = $_POST['statusteam_name'];

    $sql = "UPDATE `statusteam` 
            SET `statusteam_name`=?
            WHERE `statusteam_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusteam_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusteam_list.php');

    exit;
}

$statusteam_array = $statusteam_sql->fetch_all(MYSQLI_ASSOC);

$statusteam_name = $statusteam_array[0]['statusteam_name'];

$smarty->assign('statusteam_name', $statusteam_name);
$smarty->assign('tpl', 'statusteam_create');

$smarty->display('admin_main.html');