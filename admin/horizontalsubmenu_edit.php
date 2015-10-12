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

$sql = "SELECT `horizontalmenu_horizontalmenuchapter_id`, `horizontalsubmenu_href`, `horizontalsubmenu_horizontalmenu_id`, `horizontalsubmenu_name`
        FROM `horizontalsubmenu`
        LEFT JOIN `horizontalmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        WHERE `horizontalsubmenu_id`='$get_num'
        LIMIT 1";
$menu_sql = $mysqli->query($sql);

$count_menu = $menu_sql->num_rows;

if (0 == $count_menu)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['menu_id']))
{
    $menu_id    = (int) $_POST['menu_id'];
    $menu_name  = $_POST['menu_name'];
    $menu_href  = $_POST['menu_href'];

    $sql = "UPDATE `horizontalsubmenu` 
            SET `horizontalsubmenu_href`=?, 
                `horizontalsubmenu_name`=?, 
                `horizontalsubmenu_horizontalmenu_id`=?
            WHERE `horizontalsubmenu_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssi', $menu_href, $menu_name, $menu_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalsubmenu_list.php');

    exit;
}

$menu_array = $menu_sql->fetch_all(MYSQLI_ASSOC);

$page_id    = $menu_array[0]['horizontalmenu_horizontalmenuchapter_id'];
$parent_id  = $menu_array[0]['horizontalsubmenu_horizontalmenu_id'];
$menu_name  = $menu_array[0]['horizontalsubmenu_name'];
$menu_href  = $menu_array[0]['horizontalsubmenu_href'];

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `horizontalmenu_id`, `horizontalmenu_name`
        FROM `horizontalmenu`
        WHERE `horizontalmenu_horizontalmenuchapter_id`='$page_id'";
$horizontalmenu_sql = $mysqli->query($sql);

$horizontalmenu_array = $horizontalmenu_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('horizontalmenuchapter_array', $horizontalmenuchapter_array);
$smarty->assign('horizontalmenu_array', $horizontalmenu_array);
$smarty->assign('page_id', $page_id);
$smarty->assign('parent_id', $parent_id);
$smarty->assign('menu_name', $menu_name);
$smarty->assign('menu_href', $menu_href);
$smarty->assign('tpl', 'horizontalsubmenu_create');

$smarty->display('admin_main.html');