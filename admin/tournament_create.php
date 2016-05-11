<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['tournamenttype_id']))
{
    $tournamenttype_id  = (int) $_POST['tournamenttype_id'];
    $tournament_name    = $_POST['tournament_name'];
    $tournament_level   = (int) $_POST['tournament_level'];
    $country_id         = (int) $_POST['country_id'];

    $sql = "INSERT INTO `tournament`
            SET `tournament_name`=?,
                `tournament_tournamenttype_id`=?,
                `tournament_level`=?,
                `tournament_country_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('siii', $tournament_name, $tournamenttype_id, $tournament_level, $country_id);
    $prepare->execute();
    $prepare->close();

    $tournament_id = $mysqli->insert_id;

    if ('image/png' == $_FILES['tournament_logo_90']['type'])
    {
        copy($_FILES['tournament_logo_90']['tmp_name'], __DIR__ . '/../img/tournament/90/' . $tournament_id . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_50']['type'])
    {
        copy($_FILES['tournament_logo_50']['tmp_name'], __DIR__ . '/../img/tournament/50/' . $tournament_id . '.png');
    }

    if ('image/png' == $_FILES['tournament_logo_12']['type'])
    {
        copy($_FILES['tournament_logo_12']['tmp_name'], __DIR__ . '/../img/tournament/12/' . $tournament_id . '.png');
    }

    redirect('tournament_list.php');
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `tournamenttype_id`,
               `tournamenttype_name`
        FROM `tournamenttype`
        ORDER BY `tournamenttype_id` ASC";
$tournamenttype_sql = $mysqli->query($sql);

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');