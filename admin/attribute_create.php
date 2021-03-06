<?php

include (__DIR__ . '/../include/include.php');

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
}

$sql = "SELECT `attributechapter_id`,
               `attributechapter_name`
        FROM `attributechapter`
        ORDER BY `attributechapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');