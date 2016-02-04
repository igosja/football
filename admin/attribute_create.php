<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $attribute_name = $_POST['attribute_name'];

    $sql = "INSERT INTO `attribute`
            SET `attribute_name`=?,
                `attribute_attributechapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $attribute_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('attribute_list.php');
    exit;
}

$sql = "SELECT `attributechapter_id`, `attributechapter_name`
        FROM `attributechapter`
        ORDER BY `attributechapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('chapter_array', $chapter_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');