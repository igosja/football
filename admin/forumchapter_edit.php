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

$sql = "SELECT `forumchapter_name`
        FROM `forumchapter`
        WHERE `forumchapter_id`='$num_get'
        LIMIT 1";
$chapter_sql = $mysqli->query($sql);

$count_chapter = $chapter_sql->num_rows;

if (0 == $count_chapter)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];

    $sql = "UPDATE `forumchapter` 
            SET `forumchapter_name`=?
            WHERE `forumchapter_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $chapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('forumchapter_list.php');
}

$chapter_array = $chapter_sql->fetch_all(1);

$tpl = 'forumchapter_create';

include (__DIR__ . '/../view/admin_main.php');