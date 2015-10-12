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

$sql = "SELECT `injurytype_day`, `injurytype_name`
        FROM `injurytype`
        WHERE `injurytype_id`='$get_num'
        LIMIT 1";
$injurytype_sql = $mysqli->query($sql);

$count_injurytype = $injurytype_sql->num_rows;

if (0 == $count_injurytype)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['injurytype_name']))
{
    $injurytype_name = $_POST['injurytype_name'];
    $injurytype_day  = (int) $_POST['injurytype_day'];

    $sql = "UPDATE `injurytype` 
            SET `injurytype_name`=?,
                `injurytype_day`=?
            WHERE `injurytype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $injurytype_name, $injurytype_day);
    $prepare->execute();
    $prepare->close();

    redirect('injurytype_list.php');

    exit;
}

$injurytype_array = $injurytype_sql->fetch_all(MYSQLI_ASSOC);

$injurytype_day  = $injurytype_array[0]['injurytype_day'];
$injurytype_name = $injurytype_array[0]['injurytype_name'];

$smarty->assign('injurytype_day', $injurytype_day);
$smarty->assign('injurytype_name', $injurytype_name);
$smarty->assign('tpl', 'injurytype_create');

$smarty->display('admin_main.html');