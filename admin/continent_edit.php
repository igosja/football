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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$num_get'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['continent_name']))
{
    $continent_name = $_POST['continent_name'];

    $sql = "UPDATE `continent` 
            SET `continent_name`=?
            WHERE `continent_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $continent_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['continent_logo']['type'])
    {
        copy($_FILES['continent_logo']['tmp_name'], '../img/continent/' . $num_get . '.png');
    }

    redirect('continent_list.php');
}

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

$smarty->assign('continent_name', $continent_name);
$smarty->assign('tpl', 'continent_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');