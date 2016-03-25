<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['mood_name']))
{
    $mood_name = $_POST['mood_name'];

    $sql = "INSERT INTO `mood`
            SET `mood_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $mood_name);
    $prepare->execute();
    $prepare->close();

    $mood_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['mood_logo']['type'])
    {
        copy($_FILES['mood_logo']['tmp_name'], '/img/mood/' . $mood_id . '.png');
    }

    redirect('mood_list.php');
}

$sql = "SELECT `mood_id`, `mood_name`
        FROM `mood`
        ORDER BY `mood_id` ASC";
$mood_sql = $mysqli->query($sql);

$mood_array = $mood_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('mood_array', $mood_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');