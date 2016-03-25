<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `role_description`, `role_name`, `role_short`
        FROM `role`
        WHERE `role_id`='$get_num'
        LIMIT 1";
$role_sql = $mysqli->query($sql);

$count_role = $role_sql->num_rows;

if (0 == $count_role)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['role_name']))
{
    $role_name          = $_POST['role_name'];
    $role_description   = $_POST['role_description'];
    $role_short         = $_POST['role_short'];

    $sql = "UPDATE `role` 
            SET `role_name`=?,
                `role_description`=?,
                `role_short`=?
            WHERE `role_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $role_name, $role_description, $role_short);
    $prepare->execute();
    $prepare->close();

    redirect('role_list.php');
}

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

$role_name          = $role_array[0]['role_name'];
$role_description   = $role_array[0]['role_description'];
$role_short         = $role_array[0]['role_short'];

$smarty->assign('role_name', $role_name);
$smarty->assign('role_description', $role_description);
$smarty->assign('role_short', $role_short);
$smarty->assign('tpl', 'role_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');