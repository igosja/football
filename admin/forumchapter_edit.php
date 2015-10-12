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

$sql = "SELECT `forumchapter_name`
        FROM `forumchapter`
        WHERE `forumchapter_id`='$get_num'
        LIMIT 1";
$chapter_sql = $mysqli->query($sql);

$count_chapter = $chapter_sql->num_rows;

if (0 == $count_chapter)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];

    $sql = "UPDATE `forumchapter` 
            SET `forumchapter_name`=?
            WHERE `forumchapter_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $chapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('forumchapter_list.php');

    exit;
}

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$chapter_name = $chapter_array[0]['forumchapter_name'];

$smarty->assign('chapter_name', $chapter_name);
$smarty->assign('tpl', 'forumchapter_create');

$smarty->display('admin_main.html');