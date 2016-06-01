<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `attributestaff_id`,
                   `attributestaff_name`,
                   `attributechapterstaff_id`,
                   `attributechapterstaff_name`
            FROM `attributestaff` AS `t1`
            LEFT JOIN `attributechapterstaff`
            ON `attributestaff_attributechapterstaff_id`=`attributechapterstaff_id`
            WHERE `attributechapterstaff_id`='$chapter_id'
            ORDER BY `attributestaff_attributechapterstaff_id` ASC, `attributestaff_id` ASC";
}
else
{
    $sql = "SELECT `attributestaff_id`,
                   `attributestaff_name`,
                   `attributechapterstaff_id`,
                   `attributechapterstaff_name`
            FROM `attributestaff`
            LEFT JOIN `attributechapterstaff`
            ON `attributestaff_attributechapterstaff_id`=`attributechapterstaff_id`
            ORDER BY `attributestaff_attributechapterstaff_id` ASC, `attributestaff_id` ASC";
}

$attribute_sql = $mysqli->query($sql);

$attribute_array = $attribute_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');