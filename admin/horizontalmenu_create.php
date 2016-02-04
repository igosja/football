<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['horizontalmenuchapter_id']))
{
    $horizontalmenuchapter_id    = (int) $_POST['horizontalmenuchapter_id'];
    $menu_name  = $_POST['menu_name'];

    $sql = "INSERT INTO `horizontalmenu`
            SET `horizontalmenu_name`=?,
                `horizontalmenu_horizontalmenuchapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $menu_name, $horizontalmenuchapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenu_list.php');

    exit;
}

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('horizontalmenuchapter_array', $horizontalmenuchapter_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');