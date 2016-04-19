<table class="block-table w100">
    <tr>
        <td class="block-page w100">
            <p class="header">Статистика (<?= $game_array[0]['game_guest_' . $team_country . '_name']; ?>)</p>
            <table class="striped w100">
                <tr>
                    <th class="w4">№</th>
                    <th>Игрок</th>
                    <th class="w4">Конд</th>
                    <th class="w8">Дист</th>
                    <th class="w4">Уд</th>
                    <th class="w4">УдЦ</th>
                    <th class="w4">Пер</th>
                    <th class="w4">ТПер</th>
                    <th class="w4">Оф</th>
                    <th class="w4">ФОн</th>
                    <th class="w4">ФНа</th>
                    <th class="w4">ЖК</th>
                    <th class="w4">КК</th>
                    <th class="w4">Гол</th>
                    <th class="w4">ГП</th>
                    <th class="w4">Оцн</th>
                </tr>
                <?php foreach ($game_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['player_number' . $number]; ?></td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['lineup_condition']; ?>%</td>
                        <td class="center"><?= $item['lineup_distance']; ?> м</td>
                        <td class="center"><?= $item['lineup_shot']; ?></td>
                        <td class="center"><?= $item['lineup_ontarget']; ?></td>
                        <td class="center"><?= $item['lineup_pass']; ?></td>
                        <td class="center"><?= $item['lineup_pass_accurate']; ?></td>
                        <td class="center"><?= $item['lineup_offside']; ?></td>
                        <td class="center"><?= $item['lineup_foul_made']; ?></td>
                        <td class="center"><?= $item['lineup_foul_recieve']; ?></td>
                        <td class="center"><?= $item['lineup_yellow']; ?></td>
                        <td class="center"><?= $item['lineup_red']; ?></td>
                        <td class="center"><?= $item['lineup_goal']; ?></td>
                        <td class="center"><?= $item['lineup_pass_scoring']; ?></td>
                        <td class="center"><?= $item['lineup_mark']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>