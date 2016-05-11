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

$sql = "SELECT `gamemood_description`,
               `gamemood_name`
        FROM `gamemood`
        WHERE `gamemood_id`='$num_get'
        LIMIT 1";
$gamemood_sql = $mysqli->query($sql);

$count_gamemood = $gamemood_sql->num_rows;

if (0 == $count_gamemood)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['gamemood_name']))
{
    $gamemood_name          = $_POST['gamemood_name'];
    $gamemood_description   = $_POST['gamemood_description'];

    $sql = "UPDATE `gamemood` 
            SET `gamemood_name`=?,
                `gamemood_description`=?
            WHERE `gamemood_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamemood_name, $gamemood_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamemood_list.php');
}

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'gamemood_create';

include (__DIR__ . '/../view/admin_main.php');