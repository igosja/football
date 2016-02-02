<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Турнирная таблица</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">№</th>
                    <th colspan="2">Команда</th>
                    <th class="w5">И</th>
                    <th class="w5">В</th>
                    <th class="w5">Н</th>
                    <th class="w5">П</th>
                    <th class="w5">ГЗ</th>
                    <th class="w5">ГП</th>
                    <th class="w5">+/-</th>
                    <th class="w5">О</th>
                </tr>
                <?php foreach ($standing_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print $item['standing_place']; ?></td>
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
                        <td class="center"><?php print $item['standing_game']; ?></td>
                        <td class="center"><?php print $item['standing_win']; ?></td>
                        <td class="center"><?php print $item['standing_draw']; ?></td>
                        <td class="center"><?php print $item['standing_loose']; ?></td>
                        <td class="center"><?php print $item['standing_score']; ?></td>
                        <td class="center"><?php print $item['standing_pass']; ?></td>
                        <td class="center"><?php print $item['standing_difference']; ?></td>
                        <td class="center"><strong><?php print $item['standing_point']; ?></strong></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>