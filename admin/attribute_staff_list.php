<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `attributestaff_id`, `attributestaff_name`, `attributechapterstaff_id`, `attributechapterstaff_name`
            FROM `attributestaff` AS `t1`
            LEFT JOIN
            (
                SELECT `attributechapterstaff_id`, `attributechapterstaff_name`
                FROM `attributechapterstaff`
            ) AS `t2`
            ON `t1`.`attributestaff_attributechapterstaff_id`=`t2`.`attributechapterstaff_id`
            WHERE `attributechapterstaff_id`='$chapter_id'
            ORDER BY `attributestaff_attributechapterstaff_id` ASC, `attributestaff_id` ASC";
}
else
{
    $sql = "SELECT `attributestaff_id`, `attributestaff_name`, `attributechapterstaff_id`, `attributechapterstaff_name`
            FROM `attributestaff` AS `t1`
            LEFT JOIN
            (
                SELECT `attributechapterstaff_id`, `attributechapterstaff_name`
                FROM `attributechapterstaff`
            ) AS `t2`
            ON `t1`.`attributestaff_attributechapterstaff_id`=`t2`.`attributechapterstaff_id`
            ORDER BY `attributestaff_attributechapterstaff_id` ASC, `attributestaff_id` ASC";
}

$attribute_sql = $mysqli->query($sql);

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('attribute_array', $attribute_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');

?>