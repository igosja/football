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

$sql = "SELECT `horizontalmenu_horizontalmenuchapter_id`, `horizontalmenu_name`
        FROM `horizontalmenu`
        WHERE `horizontalmenu_id`='$num_get'
        LIMIT 1";
$menu_sql = $mysqli->query($sql);

$count_menu = $menu_sql->num_rows;

if (0 == $count_menu)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_horizontalmenuchapter.html');

    exit;
}

if (isset($_POST['horizontalmenuchapter_id']))
{
    $horizontalmenuchapter_id    = (int) $_POST['horizontalmenuchapter_id'];
    $menu_name  = $_POST['menu_name'];

    $sql = "UPDATE `horizontalmenu` 
            SET `horizontalmenu_name`=?, 
                `horizontalmenu_horizontalmenuchapter_id`=?
            WHERE `horizontalmenu_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $menu_name, $horizontalmenuchapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenu_list.php');
}

$menu_array = $menu_sql->fetch_all(MYSQLI_ASSOC);

$menu_name  = $menu_array[0]['horizontalmenu_name'];
$horizontalmenuchapter_id    = $menu_array[0]['horizontalmenu_horizontalmenuchapter_id'];

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('horizontalmenuchapter_array', $horizontalmenuchapter_array);
$smarty->assign('horizontalmenuchapter_id', $horizontalmenuchapter_id);
$smarty->assign('menu_name', $menu_name);
$smarty->assign('tpl', 'horizontalmenu_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');