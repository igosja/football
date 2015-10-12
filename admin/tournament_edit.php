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

$sql = "SELECT `tournament_country_id`, `tournament_level`, `tournament_member`, `tournament_name`, `tournament_tournamenttype_id`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['tournamenttype_id']))
{
    $tournamenttype_id  = (int) $_POST['tournamenttype_id'];
    $tournament_name    = $_POST['tournament_name'];
    $tournament_level   = (int) $_POST['tournament_level'];
    $tournament_member  = (int) $_POST['tournament_member'];
    $country_id         = (int) $_POST['country_id'];

    $sql = "UPDATE `tournament`
            SET `tournament_name`=?,
                `tournament_tournamenttype_id`=?,
                `tournament_level`=?,
                `tournament_member`=?,
                `tournament_country_id`=?
            WHERE `tournament_id`='$get_num'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('siiii', $tournament_name, $tournamenttype_id, $tournament_level, $tournament_member, $country_id);
    $prepare->execute();
    $prepare->close();

    if ('image/png' == $_FILES['tournament_logo']['type'])
    {
        copy($_FILES['tournament_logo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_90']['type'])
    {
        copy($_FILES['tournament_logo_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/90/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_50']['type'])
    {
        copy($_FILES['tournament_logo_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/50/' . $get_num . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_12']['type'])
    {
        copy($_FILES['tournament_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/12/' . $get_num . '.png');
    }

    redirect('tournament_list.php');

    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name    = $tournament_array[0]['tournament_name'];
$tournament_level   = $tournament_array[0]['tournament_level'];
$tournament_member  = $tournament_array[0]['tournament_member'];
$tournamenttype_id  = $tournament_array[0]['tournament_tournamenttype_id'];
$country_id         = $tournament_array[0]['tournament_country_id'];

$sql = "SELECT `country_id`, `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `tournamenttype_id`, `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = $mysqli->query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('tournament_name', $tournament_name);
$smarty->assign('tournament_level', $tournament_level);
$smarty->assign('tournament_member', $tournament_member);
$smarty->assign('tournamenttype_id', $tournamenttype_id);
$smarty->assign('country_id', $country_id);
$smarty->assign('country_array', $country_array);
$smarty->assign('tournamenttype_array', $tournamenttype_array);
$smarty->assign('tpl', 'tournament_create');

$smarty->display('admin_main.html');