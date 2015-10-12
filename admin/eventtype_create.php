<?php

include ('../include/include.php');

if (isset($_POST['eventtype_name']))
{
    $eventtype_name = $_POST['eventtype_name'];

    $sql = "INSERT INTO `eventtype`
            SET `eventtype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $eventtype_name);
    $prepare->execute();
    $prepare->close();

    $eventtype_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['eventtype_logo']['type'])
    {
        copy($_FILES['eventtype_logo']['tmp_name'], '../img/eventtype/' . $eventtype_id . '.png');
    }

    redirect('eventtype_list.php');

    exit;
}

$smarty->display('admin_main.html');