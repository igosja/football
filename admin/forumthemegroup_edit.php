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

$sql = "SELECT `forumthemegroup_description`,
               `forumthemegroup_forumchapter_id`,
               `forumthemegroup_name`
        FROM `forumthemegroup`
        WHERE `forumthemegroup_id`='$get_num'
        LIMIT 1";
$chapter_sql = $mysqli->query($sql);

$count_chapter = $chapter_sql->num_rows;

if (0 == $count_chapter)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['chapter_name']))
{
    $chapter_description = $_POST['chapter_description'];
    $chapter_name        = $_POST['chapter_name'];
    $chapter_id          = $_POST['chapter_id'];

    $sql = "UPDATE `forumthemegroup` 
            SET `forumthemegroup_name`=?,
                `forumthemegroup_description`=?,
                `forumthemegroup_forumchapter_id`=?
            WHERE `forumthemegroup_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssi', $chapter_name, $chapter_description, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('forumthemegroup_list.php');
}

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$chapter_description = $chapter_array[0]['forumthemegroup_description'];
$chapter_name        = $chapter_array[0]['forumthemegroup_name'];
$chapter_id          = $chapter_array[0]['forumthemegroup_forumchapter_id'];

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_id` ASC";
$forumchapter_sql = $mysqli->query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('chapter_description', $chapter_description);
$smarty->assign('chapter_name', $chapter_name);
$smarty->assign('chapter_id', $chapter_id);
$smarty->assign('forumchapter_array', $forumchapter_array);
$smarty->assign('tpl', 'forumthemegroup_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');