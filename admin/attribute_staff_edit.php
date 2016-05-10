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

$sql = "SELECT `attributestaff_attributechapterstaff_id`, `attributestaff_name`
        FROM `attributestaff`
        WHERE `attributestaff_id`='$num_get'
        LIMIT 1";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;

if (0 == $count_attribute)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $attribute_name = $_POST['attribute_name'];

    $sql = "UPDATE `attributestaff` 
            SET `attributestaff_name`=?, 
                `attributestaff_attributechapterstaff_id`=?
            WHERE `attributestaff_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $attribute_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('attribute_staff_list.php');
}

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$attribute_name = $attribute_array[0]['attributestaff_name'];
$chapter_id     = $attribute_array[0]['attributestaff_attributechapterstaff_id'];

$sql = "SELECT `attributechapterstaff_id`, `attributechapterstaff_name`
        FROM `attributechapterstaff`
        ORDER BY `attributechapterstaff_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('chapter_array', $chapter_array);
$smarty->assign('attribute_name', $attribute_name);
$smarty->assign('chapter_id', $chapter_id);
$smarty->assign('tpl', 'attribute_staff_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');