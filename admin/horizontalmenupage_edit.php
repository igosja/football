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

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenupage_name`
        FROM `horizontalmenupage`
        LEFT JOIN `horizontalmenuchapter`
        ON `horizontalmenuchapter_id`=`horizontalmenupage_horizontalmenuchapter_id`
        WHERE `horizontalmenupage_id`='$num_get'
        LIMIT 1";
$horizontalmenupage_sql = $mysqli->query($sql);

$count_horizontalmenupage = $horizontalmenupage_sql->num_rows;

if (0 == $count_horizontalmenupage)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_POST['horizontalmenupage_name']))
{
    $horizontalmenupage_name    = $_POST['horizontalmenupage_name'];
    $chapter_id                 = (int) $_POST['chapter_id'];

    $sql = "UPDATE `horizontalmenupage` 
            SET `horizontalmenupage_name`=?,
                `horizontalmenupage_horizontalmenuchapter_id`=?
            WHERE `horizontalmenupage_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $horizontalmenupage_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenupage_list.php');
}

$horizontalmenupage_array = $horizontalmenupage_sql->fetch_all(MYSQLI_ASSOC);

$horizontalmenupage_name    = $horizontalmenupage_array[0]['horizontalmenupage_name'];
$chapter_id                 = $horizontalmenupage_array[0]['horizontalmenuchapter_id'];

$sql = "SELECT `horizontalmenuchapter_id`, `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        ORDER BY `horizontalmenuchapter_name` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'horizontalmenupage_create';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');