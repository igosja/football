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

$sql = "SELECT `horizontalmenuchapter_name`
        FROM `horizontalmenuchapter`
        WHERE `horizontalmenuchapter_id`='$num_get'
        LIMIT 1";
$horizontalmenuchapter_sql = $mysqli->query($sql);

$count_horizontalmenuchapter = $horizontalmenuchapter_sql->num_rows;

if (0 == $count_horizontalmenuchapter)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_horizontalmenuchapter.html');

    exit;
}

if (isset($_POST['horizontalmenuchapter_name']))
{
    $horizontalmenuchapter_name = $_POST['horizontalmenuchapter_name'];

    $sql = "UPDATE `horizontalmenuchapter` 
            SET `horizontalmenuchapter_name`=?
            WHERE `horizontalmenuchapter_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $horizontalmenuchapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenuchapter_list.php');
}

$horizontalmenuchapter_array = $horizontalmenuchapter_sql->fetch_all(MYSQLI_ASSOC);

$horizontalmenuchapter_name = $horizontalmenuchapter_array[0]['horizontalmenuchapter_name'];

$smarty->assign('horizontalmenuchapter_name', $horizontalmenuchapter_name);
$smarty->assign('tpl', 'horizontalmenuchapter_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');