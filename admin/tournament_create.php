<?php

include ('../include/include.php');

if (isset($_POST['tournamenttype_id']))
{
    $tournamenttype_id  = (int) $_POST['tournamenttype_id'];
    $tournament_name    = $_POST['tournament_name'];
    $tournament_level   = (int) $_POST['tournament_level'];
    $tournament_visitor  = (float) $_POST['tournament_visitor'];
    $country_id         = (int) $_POST['country_id'];

    $sql = "INSERT INTO `tournament`
            SET `tournament_name`=?,
                `tournament_tournamenttype_id`=?,
                `tournament_level`=?,
                `tournament_visitor`=?,
                `tournament_country_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('siidi', $tournament_name, $tournamenttype_id, $tournament_level, $tournament_visitor, $country_id);
    $prepare->execute();
    $prepare->close();

    $tournament_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['tournament_logo']['type'])
    {
        copy($_FILES['tournament_logo']['tmp_name'], '../img/tournament/' . $tournament_id . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_90']['type'])
    {
        copy($_FILES['tournament_logo_90']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/90/' . $tournament_id . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_50']['type'])
    {
        copy($_FILES['tournament_logo_50']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/50/' . $tournament_id . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_12']['type'])
    {
        copy($_FILES['tournament_logo_12']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/tournament/12/' . $tournament_id . '.png');
    }

    redirect('tournament_list.php');

    exit;
}

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

$smarty->assign('country_array', $country_array);
$smarty->assign('tournamenttype_array', $tournamenttype_array);

$smarty->display('admin_main.html');