<?php

include ('../include/include.php');

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $attribute_name = $_POST['attribute_name'];

    $sql = "INSERT INTO `attributestaff`
            SET `attributestaff_name`=?,
                `attributestaff_attributechapterstaff_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $attribute_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('attribute_staff_list.php');

    exit;
}

$sql = "SELECT `attributechapterstaff_id`, `attributechapterstaff_name`
        FROM `attributechapterstaff`
        ORDER BY `attributechapterstaff_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQL_ASSOC);

$smarty->assign('chapter_array', $chapter_array);

$smarty->display('admin_main.html');