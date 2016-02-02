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

$sql = "SELECT `mood_name`
        FROM `mood`
        WHERE `mood_id`='$get_num'
        LIMIT 1";
$mood_sql = $mysqli->query($sql);

$count_mood = $mood_sql->num_rows;

if (0 == $count_mood)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['mood_name']))
{
    $mood_name = $_POST['mood_name'];

    $sql = "UPDATE `mood` 
            SET `mood_name`=?
            WHERE `mood_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $mood_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['mood_logo']['type'])
    {
        copy($_FILES['mood_logo']['tmp_name'], '../img/mood/' . $get_num . '.png');
    }

    redirect('mood_list.php');

    exit;
}

$mood_array = $mood_sql->fetch_all(MYSQLI_ASSOC);

$mood_name = $mood_array[0]['mood_name'];

$smarty->assign('mood_name', $mood_name);
$smarty->assign('tpl', 'mood_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');