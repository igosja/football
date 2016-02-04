<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];
    $chapter_id   = $_POST['chapter_id'];

    $sql = "INSERT INTO `forumthemegroup`
            SET `forumthemegroup_name`=?,
                `forumthemegroup_description`=?,
                `forumthemegroup_forumchapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssi', $chapter_name, $chapter_description, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('forumthemegroup_list.php');

    exit;
}

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_id` ASC";
$forumchapter_sql = $mysqli->query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('forumchapter_array', $forumchapter_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');