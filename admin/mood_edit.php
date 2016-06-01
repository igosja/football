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

$sql = "SELECT `mood_name`
        FROM `mood`
        WHERE `mood_id`='$num_get'
        LIMIT 1";
$mood_sql = $mysqli->query($sql);

$count_mood = $mood_sql->num_rows;

if (0 == $count_mood)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['mood_name']))
{
    $mood_name = $_POST['mood_name'];

    $sql = "UPDATE `mood` 
            SET `mood_name`=?
            WHERE `mood_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $mood_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['mood_logo']['type'])
    {
        copy($_FILES['mood_logo']['tmp_name'], __DIR__ . '/../img/mood/' . $num_get . '.png');
    }

    redirect('mood_list.php');
}

$mood_array = $mood_sql->fetch_all(1);

$tpl = 'mood_create';

include (__DIR__ . '/../view/admin_main.php');