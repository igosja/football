<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['continent_name']))
{
    $continent_name = $_POST['continent_name'];

    $sql = "INSERT INTO `continent`
            SET `continent_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $continent_name);
    $prepare->execute();
    $prepare->close();

    $continent_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['continent_logo']['type'])
    {
        copy($_FILES['continent_logo']['tmp_name'], '../img/continent/' . $continent_id . '.png');
    }

    redirect('continent_list.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');