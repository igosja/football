<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['menu_id']))
{
    $menu_id    = (int) $_POST['menu_id'];
    $menu_name  = $_POST['menu_name'];
    $menu_href  = $_POST['menu_href'];

    $sql = "INSERT INTO `horizontalsubmenu`
            SET `horizontalsubmenu_href`=?,
                `horizontalsubmenu_name`=?,
                `horizontalsubmenu_horizontalmenu_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssi', $menu_href, $menu_name, $menu_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalsubmenu_list.php');
}

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$horizontalmenuchapter_id = $horizontalmenuchapter_array[0]['horizontalmenuchapter_id'];

$sql = "SELECT `horizontalmenu_id`, `horizontalmenu_name`
        FROM `horizontalmenu`
        WHERE `horizontalmenu_horizontalmenuchapter_id`='$horizontalmenuchapter_id'";
$horizontalmenu_sql = $mysqli->query($sql);

$horizontalmenu_array = $horizontalmenu_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');