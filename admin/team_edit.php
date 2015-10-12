<?php

include ('../include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `stadium_name`, `team_city_id`, `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `stadium_team_id`=`team_id`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['city_id']))
{
    $city_id        = (int) $_POST['city_id'];
    $team_name      = $_POST['team_name'];
    $stadium_name   = $_POST['stadium_name'];

    $sql = "UPDATE `team` 
            SET `team_name`=?, 
                `team_city_id`=?
            WHERE `team_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $team_name, $city_id);
    $prepare->execute();
    $prepare->close();

    $sql = "UPDATE `stadium`
            SET `stadium_name`=?
            WHERE `stadium_team_id`='$get_num'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stadium_name);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['team_logo']['type'])
    {
        copy($_FILES['team_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['team_logo_120']['type'])
    {
        copy($_FILES['team_logo_120']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/120/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['team_logo_90']['type'])
    {
        copy($_FILES['team_logo_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/90/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['team_logo_50']['type'])
    {
        copy($_FILES['team_logo_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/50/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['team_logo_12']['type'])
    {
        copy($_FILES['team_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/team/12/' . $get_num . '.png');
    }

    redirect('team_list.php');

    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name      = $team_array[0]['team_name'];
$stadium_name   = $team_array[0]['stadium_name'];
$city_id        = $team_array[0]['team_city_id'];

$sql = "SELECT `city_id`, `city_name`
        FROM `city`
        ORDER BY `city_name` ASC";
$city_sql = $mysqli->query($sql);

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('team_name', $team_name);
$smarty->assign('stadium_name', $stadium_name);
$smarty->assign('city_id', $city_id);
$smarty->assign('city_array', $city_array);
$smarty->assign('tpl', 'team_create');

$smarty->display('admin_main.html');