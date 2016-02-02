<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Достижения</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Сезон</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Турнир</th>
                    <th class="w10">Место</th>
                </tr>
                <?php foreach ($trophy_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print $item['trophyplayer_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w35">
                            <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                <?php print $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['trophyplayer_place']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>