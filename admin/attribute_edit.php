<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `attribute_attributechapter_id`, `attribute_name`
        FROM `attribute`
        WHERE `attribute_id`='$get_num'
        LIMIT 1";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;

if (0 == $count_attribute)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $attribute_name = $_POST['attribute_name'];

    $sql = "UPDATE `attribute` 
            SET `attribute_name`=?, 
                `attribute_attributechapter_id`=?
            WHERE `attribute_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $attribute_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('attribute_list.php');
}

$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$attribute_name = $attribute_array[0]['attribute_name'];
$chapter_id     = $attribute_array[0]['attribute_attributechapter_id'];

$sql = "SELECT `attributechapter_id`, `attributechapter_name`
        FROM `attributechapter`
        ORDER BY `attributechapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('chapter_array', $chapter_array);
$smarty->assign('attribute_name', $attribute_name);
$smarty->assign('chapter_id', $chapter_id);
$smarty->assign('tpl', 'attribute_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');