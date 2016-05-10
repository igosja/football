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

$sql = "SELECT `inboxtheme_name`,
               `inboxtheme_text`
        FROM `inboxtheme`
        WHERE `inboxtheme_id`='$num_get'
        LIMIT 1";
$inboxtheme_sql = $mysqli->query($sql);

$count_inboxtheme = $inboxtheme_sql->num_rows;

if (0 == $count_inboxtheme)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');
    exit;
}

if (isset($_POST['inboxtheme_name']))
{
    $inboxtheme_name = $_POST['inboxtheme_name'];
    $inboxtheme_text = $_POST['inboxtheme_text'];

    $sql = "UPDATE `inboxtheme` 
            SET `inboxtheme_name`=?,
                `inboxtheme_text`=?
            WHERE `inboxtheme_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $inboxtheme_name, $inboxtheme_text);
    $prepare->execute();
    $prepare->close();

    redirect('inboxtheme_list.php');
}

$inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

$inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
$inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];

$tpl = 'inboxtheme_create';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');