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

$sql = "SELECT `staffpost_name`
        FROM `staffpost`
        WHERE `staffpost_id`='$get_num'
        LIMIT 1";
$post_sql = $mysqli->query($sql);

$count_post = $post_sql->num_rows;

if (0 == $count_post)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['post_name']))
{
    $post_name = $_POST['post_name'];

    $sql = "UPDATE `staffpost` 
            SET `staffpost_name`=?
            WHERE `staffpost_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $post_name);
    $prepare->execute();
    $prepare->close();

    redirect('post_list.php');

    exit;
}

$post_array = $post_sql->fetch_all(MYSQLI_ASSOC);

$post_name = $post_array[0]['staffpost_name'];

$smarty->assign('post_name', $post_name);
$smarty->assign('tpl', 'post_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');