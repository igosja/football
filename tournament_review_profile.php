<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `tournament_tournamenttype_id`
        FROM `tournament`
        WHERE `tournament_id`='$num_get'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(1);

$tournamenttype_id = $tournament_array[0]['tournament_tournamenttype_id'];

if (TOURNAMENT_TYPE_CHAMPIONSHIP == $tournamenttype_id)
{
    redirect('championship_review_profile.php?num=' . $num_get);
}
elseif (TOURNAMENT_TYPE_CUP == $tournamenttype_id)
{
    redirect('cup_review_profile.php?num=' . $num_get);
}
elseif (TOURNAMENT_TYPE_CHAMPIONS_LEAGUE == $tournamenttype_id)
{
    redirect('league_review_profile.php?num=' . $num_get);
}
elseif (TOURNAMENT_TYPE_WORLD_CUP == $tournamenttype_id)
{
    redirect('worldcup_review_profile.php?num=' . $num_get);
}
elseif (TOURNAMENT_TYPE_FRIENDLY == $tournamenttype_id)
{
    redirect('index.php');
}

include (__DIR__ . '/view/main.php');