<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `attributechapterstaff_name`
        FROM `attributechapterstaff`
        WHERE `attributechapterstaff_id`='$num_get'
        LIMIT 1";
$chapter_sql = $mysqli->query($sql);

$count_chapter = $chapter_sql->num_rows;

if (0 == $count_chapter)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];

    $sql = "UPDATE `attributechapterstaff` 
            SET `attributechapterstaff_name`=?
            WHERE `attributechapterstaff_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $chapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('attributechapter_staff_list.php');
}

$chapter_array = $chapter_sql->fetch_all(1);

$tpl = 'attributechapter_staff_create';

include (__DIR__ . '/../view/admin_main.php');