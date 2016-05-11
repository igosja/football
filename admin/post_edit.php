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

$sql = "SELECT `staffpost_name`
        FROM `staffpost`
        WHERE `staffpost_id`='$num_get'
        LIMIT 1";
$post_sql = $mysqli->query($sql);

$count_post = $post_sql->num_rows;

if (0 == $count_post)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['post_name']))
{
    $post_name = $_POST['post_name'];

    $sql = "UPDATE `staffpost` 
            SET `staffpost_name`=?
            WHERE `staffpost_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $post_name);
    $prepare->execute();
    $prepare->close();

    redirect('post_list.php');
}

$post_array = $post_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'post_create';

include (__DIR__ . '/../view/admin_main.php');