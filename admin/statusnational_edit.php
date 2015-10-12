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

$sql = "SELECT `statusnational_name`
        FROM `statusnational`
        WHERE `statusnational_id`='$get_num'
        LIMIT 1";
$statusnational_sql = $mysqli->query($sql);

$count_statusnational = $statusnational_sql->num_rows;

if (0 == $count_statusnational)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['statusnational_name']))
{
    $statusnational_name = $_POST['statusnational_name'];

    $sql = "UPDATE `statusnational` 
            SET `statusnational_name`=?
            WHERE `statusnational_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusnational_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusnational_list.php');

    exit;
}

$statusnational_array = $statusnational_sql->fetch_all(MYSQLI_ASSOC);

$statusnational_name = $statusnational_array[0]['statusnational_name'];

$smarty->assign('statusnational_name', $statusnational_name);
$smarty->assign('tpl', 'statusnational_create');

$smarty->display('admin_main.html');