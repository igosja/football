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

$sql = "SELECT `eventtype_name`
        FROM `eventtype`
        WHERE `eventtype_id`='$get_num'
        LIMIT 1";
$eventtype_sql = $mysqli->query($sql);

$count_eventtype = $eventtype_sql->num_rows;

if (0 == $count_eventtype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['eventtype_name']))
{
    $eventtype_name = $_POST['eventtype_name'];

    $sql = "UPDATE `eventtype` 
            SET `eventtype_name`=?
            WHERE `eventtype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $eventtype_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['eventtype_logo']['type'])
    {
        copy($_FILES['eventtype_logo']['tmp_name'], '../img/eventtype/' . $get_num . '.png');
    }

    redirect('eventtype_list.php');

    exit;
}

$eventtype_array = $eventtype_sql->fetch_all(MYSQLI_ASSOC);

$eventtype_name = $eventtype_array[0]['eventtype_name'];

$smarty->assign('eventtype_name', $eventtype_name);
$smarty->assign('tpl', 'eventtype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');