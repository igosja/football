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

$sql = "SELECT `role_description`,
               `role_name`,
               `role_short`
        FROM `role`
        WHERE `role_id`='$num_get'
        LIMIT 1";
$role_sql = $mysqli->query($sql);

$count_role = $role_sql->num_rows;

if (0 == $count_role)
{
    include (__DIR__ . '/../view/wrong_page.php');
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
            WHERE `role_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $role_name, $role_description, $role_short);
    $prepare->execute();
    $prepare->close();

    redirect('role_list.php');
}

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'role_create';

include (__DIR__ . '/../view/admin_main.php');