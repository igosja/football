<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Оценки (<?= $game_array[0]['game_home_' . $team_country . '_name']; ?>)</p>
            <table class="striped w100">
                <tr>
                    <th class="w8">№</th>
                    <th class="w8">Зам</th>
                    <th>Игрок</th>
                    <th class="w8">Поз</th>
                    <th class="w8">Кон</th>
                    <th class="w8">Оцн</th>
                    <th class="w8">Гол</th>
                </tr>
                <?php foreach ($home_player_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['player_number' . $number]; ?></td>
                        <td class="center">
                            <?php if (0 != $item['lineup_in']) { ?>
                                <?= $item['lineup_in']; ?>
                            <?php } elseif (0 != $item['lineup_out']) { ?>
                                <?= $item['lineup_out']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['lineup_condition']; ?>%</td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                        <td class="center">
                            <?php if (0 < $item['lineup_goal']) { ?>
                                <?= $item['lineup_goal']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Оценки (<?= $game_array[0]['game_guest_' . $team_country . '_name']; ?>)</p>
            <table class="striped w100">
                <tr>
                    <th class="w8">№</th>
                    <th class="w8">Зам</th>
                    <th>Игрок</th>
                    <th class="w8">Поз</th>
                    <th class="w8">Кон</th>
                    <th class="w8">Оцн</th>
                    <th class="w8">Гол</th>
                </tr>
                <?php foreach ($guest_player_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['player_number' . $number]; ?></td>
                        <td class="center">
                            <?php if (0 != $item['lineup_in']) { ?>
                                <?= $item['lineup_in']; ?>
                            <?php } elseif (0 != $item['lineup_out']) { ?>
                                <?= $item['lineup_out']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['lineup_condition']; ?>%</td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                        <td class="center">
                            <?php if (0 < $item['lineup_goal']) { ?>
                                <?= $item['lineup_goal']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>