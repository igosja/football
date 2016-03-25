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

$sql = "SELECT `newstheme_name`,
               `newstheme_text`
        FROM `newstheme`
        WHERE `newstheme_id`='$get_num'
        LIMIT 1";
$newstheme_sql = $mysqli->query($sql);

$count_newstheme = $newstheme_sql->num_rows;

if (0 == $count_newstheme)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['newstheme_name']))
{
    $newstheme_name = $_POST['newstheme_name'];
    $newstheme_text = $_POST['newstheme_text'];

    $sql = "UPDATE `newstheme` 
            SET `newstheme_name`=?,
                `newstheme_text`=?
            WHERE `newstheme_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $newstheme_name, $newstheme_text);
    $prepare->execute();
    $prepare->close();

    redirect('newstheme_list.php');
}

$newstheme_array = $newstheme_sql->fetch_all(MYSQLI_ASSOC);

$newstheme_name = $newstheme_array[0]['newstheme_name'];
$newstheme_text = $newstheme_array[0]['newstheme_text'];

$smarty->assign('newstheme_name', $newstheme_name);
$smarty->assign('newstheme_text', $newstheme_text);
$smarty->assign('tpl', 'newstheme_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');