<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['horizontalmenupage_name']))
{
    $horizontalmenupage_name    = $_POST['horizontalmenupage_name'];
    $chapter_id                 = (int) $_POST['chapter_id'];

    $sql = "INSERT INTO `horizontalmenupage`
            SET `horizontalmenupage_name`=?,
                `horizontalmenupage_horizontalmenuchapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $horizontalmenupage_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenupage_list.php');
}

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');