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

$sql = "SELECT `forumthemegroup_country_id`,
               `forumthemegroup_description`,
               `forumthemegroup_forumchapter_id`,
               `forumthemegroup_name`
        FROM `forumthemegroup`
        WHERE `forumthemegroup_id`='$num_get'
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
    $chapter_description = $_POST['chapter_description'];
    $chapter_name        = $_POST['chapter_name'];
    $chapter_id          = $_POST['chapter_id'];
    $country_id          = $_POST['country_id'];

    $sql = "UPDATE `forumthemegroup` 
            SET `forumthemegroup_name`=?,
                `forumthemegroup_description`=?,
                `forumthemegroup_country_id`=?,
                `forumthemegroup_forumchapter_id`=?
            WHERE `forumthemegroup_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssii', $chapter_name, $chapter_description, $country_id, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('forumthemegroup_list.php');
}

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`
        FROM `forumchapter`
        ORDER BY `forumchapter_id` ASC";
$forumchapter_sql = $mysqli->query($sql);

$forumchapter_array = $forumchapter_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `city`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        GROUP BY `country_id`
        ORDER BY `country_name` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'forumthemegroup_create';

include (__DIR__ . '/../view/admin_main.php');