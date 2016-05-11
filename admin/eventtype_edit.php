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

$sql = "SELECT `eventtype_name`,
               `eventtype_id`
        FROM `eventtype`
        WHERE `eventtype_id`='$num_get'
        LIMIT 1";
$eventtype_sql = $mysqli->query($sql);

$count_eventtype = $eventtype_sql->num_rows;

if (0 == $count_eventtype)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['eventtype_name']))
{
    $eventtype_name = $_POST['eventtype_name'];

    $sql = "UPDATE `eventtype` 
            SET `eventtype_name`=?
            WHERE `eventtype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $eventtype_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['eventtype_logo']['type'])
    {
        copy($_FILES['eventtype_logo']['tmp_name'], __DIR__ . '/../img/eventtype/' . $num_get . '.png');
    }

    redirect('eventtype_list.php');
}

$eventtype_array = $eventtype_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'eventtype_create';

include (__DIR__ . '/../view/admin_main.php');