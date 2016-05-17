<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['chapter_name']))
{
    $chapter_description    = $_POST['chapter_description'];
    $chapter_name           = $_POST['chapter_name'];
    $chapter_id             = $_POST['chapter_id'];
    $country_id             = $_POST['country_id'];

    $sql = "INSERT INTO `forumthemegroup`
            SET `forumthemegroup_name`=?,
                `forumthemegroup_description`=?,
                `forumthemegroup_country_id`=?,
                `forumthemegroup_forumchapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssii', $chapter_name, $chapter_description, $country_id, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('forumthemegroup_list.php');
}

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

include (__DIR__ . '/../view/admin_main.php');