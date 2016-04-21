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

$sql = "SELECT `horizontalmenu_horizontalmenuchapter_id`, `horizontalsubmenu_href`, `horizontalsubmenu_horizontalmenu_id`, `horizontalsubmenu_name`
        FROM `horizontalsubmenu`
        LEFT JOIN `horizontalmenu`
        ON `horizontalmenu_id`=`horizontalsubmenu_horizontalmenu_id`
        WHERE `horizontalsubmenu_id`='$num_get'
        LIMIT 1";
$menu_sql = $mysqli->query($sql);

$count_menu = $menu_sql->num_rows;

if (0 == $count_menu)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
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
            WHERE `horizontalsubmenu_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssi', $menu_href, $menu_name, $menu_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalsubmenu_list.php');
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

$tpl = 'horizontalsubmenu_create';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');