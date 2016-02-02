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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$get_num'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['continent_name']))
{
    $continent_name = $_POST['continent_name'];

    $sql = "UPDATE `continent` 
            SET `continent_name`=?
            WHERE `continent_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $continent_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['continent_logo']['type'])
    {
        copy($_FILES['continent_logo']['tmp_name'], '../img/continent/' . $get_num . '.png');
    }

    redirect('continent_list.php');

    exit;
}

$continent_array = $continent_sql->fetch_all(MYSQLI_ASSOC);

$continent_name = $continent_array[0]['continent_name'];

$smarty->assign('continent_name', $continent_name);
$smarty->assign('tpl', 'continent_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');