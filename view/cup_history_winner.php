<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Прошлые победители</p>
            <table class="striped w100">
                <tr>
                    <th>Сезон</th>
                    <th colspan="2">Победитель</th>
                    <th colspan="2">Второй призер</th>
                </tr>
                <?php foreach ($winner_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print $item['shedule_season_id']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['winner_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['winner_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?php print $item['winner_id']; ?>">
                                <?php print $item['winner_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['looser_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['looser_id']; ?>.png"
                            />
                        </td>
                        <td class="w40">
                            <a href="team_team_review_profile.php?num=<?php print $item['looser_id']; ?>">
                                <?php print $item['looser_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>