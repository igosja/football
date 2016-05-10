<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `attribute_id`,
                   `attribute_name`,
                   `attributechapter_id`,
                   `attributechapter_name`
            FROM `attribute` AS `t1`
            LEFT JOIN `attributechapter`
            ON `attribute_attributechapter_id`=`attributechapter_id`
            WHERE `attributechapter_id`='$chapter_id'
            ORDER BY `attribute_attributechapter_id` ASC, `attribute_id` ASC";
}
else
{
    $sql = "SELECT `attribute_id`,
                   `attribute_name`,
                   `attributechapter_id`,
                   `attributechapter_name`
            FROM `attribute` AS `t1`
            LEFT JOIN `attributechapter`
            ON `attribute_attributechapter_id`=`attributechapter_id`
            ORDER BY `attribute_attributechapter_id` ASC, `attribute_id` ASC";
}

$attribute_sql = $mysqli->query($sql);

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');