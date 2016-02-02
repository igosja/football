<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Рейтинг</p>
            <table class="striped w100">
                <tr>
                    <th class="w1">Ранг</th>
                    <th colspan="2">Название</th>
                    <th colspan="2">Страна</th>
                    <th class="w50">Рейтинг</th>
                </tr>
                <?php for ($i=0; $i<$count_team; $i++) { ?>
                    <tr>
                        <td class="center"><?php print $i + 1; ?></td>
                        <td class="w1">
                            <img
                                alt="<?php print $team_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $team_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $team_array[$i]['team_id']; ?>">
                                <?php print $team_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $team_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $team_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="national_team_review_profile.php?num=<?php print $team_array[$i]['country_id']; ?>">
                                <?php print $team_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php print $team_array[$i]['team_reputation'] / $team_array[0]['team_reputation'] * 100; ?>%"></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>