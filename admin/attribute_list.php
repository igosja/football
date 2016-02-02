<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `attribute_id`, `attribute_name`, `attributechapter_id`, `attributechapter_name`
            FROM `attribute` AS `t1`
            LEFT JOIN
            (
                SELECT `attributechapter_id`, `attributechapter_name`
                FROM `attributechapter`
            ) AS `t2`
            ON `t1`.`attribute_attributechapter_id`=`t2`.`attributechapter_id`
            WHERE `attributechapter_id`='$chapter_id'
            ORDER BY `attribute_attributechapter_id` ASC, `attribute_id` ASC";
}
else
{
    $sql = "SELECT `attribute_id`, `attribute_name`, `attributechapter_id`, `attributechapter_name`
            FROM `attribute` AS `t1`
            LEFT JOIN
            (
                SELECT `attributechapter_id`, `attributechapter_name`
                FROM `attributechapter`
            ) AS `t2`
            ON `t1`.`attribute_attributechapter_id`=`t2`.`attributechapter_id`
            ORDER BY `attribute_attributechapter_id` ASC, `attribute_id` ASC";
}

$attribute_sql = $mysqli->query($sql);

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('attribute_array', $attribute_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');