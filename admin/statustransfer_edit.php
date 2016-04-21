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

$sql = "SELECT `statustransfer_name`
        FROM `statustransfer`
        WHERE `statustransfer_id`='$num_get'
        LIMIT 1";
$statustransfer_sql = $mysqli->query($sql);

$count_statustransfer = $statustransfer_sql->num_rows;

if (0 == $count_statustransfer)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['statustransfer_name']))
{
    $statustransfer_name = $_POST['statustransfer_name'];

    $sql = "UPDATE `statustransfer` 
            SET `statustransfer_name`=?
            WHERE `statustransfer_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statustransfer_name);
    $prepare->execute();
    $prepare->close();

    redirect('statustransfer_list.php');
}

$statustransfer_array = $statustransfer_sql->fetch_all(MYSQLI_ASSOC);

$statustransfer_name = $statustransfer_array[0]['statustransfer_name'];

$smarty->assign('statustransfer_name', $statustransfer_name);
$smarty->assign('tpl', 'statustransfer_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');