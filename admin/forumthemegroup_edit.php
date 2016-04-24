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

$sql = "SELECT `forumthemegroup_description`,
               `forumthemegroup_forumchapter_id`,
               `forumthemegroup_name`
        FROM `forumthemegroup`
        WHERE `forumthemegroup_id`='$num_get'
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
            WHERE `forumthemegroup_id`='$num_get'
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

$tpl = 'forumthemegroup_create';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');