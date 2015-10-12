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

$sql = "SELECT `stage_name`
        FROM `stage`
        WHERE `stage_id`='$get_num'
        LIMIT 1";
$stage_sql = $mysqli->query($sql);

$count_stage = $stage_sql->num_rows;

if (0 == $count_stage)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['stage_name']))
{
    $stage_name          = $_POST['stage_name'];

    $sql = "UPDATE `stage` 
            SET `stage_name`=?
            WHERE `stage_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stage_name);
    $prepare->execute();
    $prepare->close();

    redirect('stage_list.php');

    exit;
}

$stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

$stage_name          = $stage_array[0]['stage_name'];

$smarty->assign('stage_name', $stage_name);
$smarty->assign('tpl', 'stage_create');

$smarty->display('admin_main.html');