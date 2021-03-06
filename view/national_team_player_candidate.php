<table class="block-table w100">
    <tr>
        <td class="block-page" id="player-block">
            <p class="header">Игроки</p>
            <table class="w100">
                <tr>
                    <td>
                        <form method="GET">
                            <select name="position">
                                <option value="0">Позиция</option>
                                <?php foreach ($position_array as $item) { ?>
                                    <option value="<?= $item['position_id']; ?>"
                                        <?php if (isset($_GET['position']) && $_GET['position'] == $item['position_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['position_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="submit" value="Поиск">
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th class="w1"></th>
                    <th>Имя</th>
                    <th colspan="2">Команда</th>
                    <th class="w5">Позиция</th>
                    <th class="w5">Воз</th>
                    <th class="w5">Вес</th>
                    <th class="w5">Рост</th>
                    <th class="w15">Настроение</th>
                    <th class="w5">Конд</th>
                    <th class="w5">Фит</th>
                    <th class="w7">Стоимость</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td class="center nopadding">
                            <input
                                class="player-national-include"
                                data-player="<?= $item['player_id']; ?>"
                                type="checkbox"
                                <?php if (0 != $item['player_national_id']) { ?>
                                    checked
                                <?php } ?>
                            />
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['player_age']; ?></td>
                        <td class="center"><?= $item['player_weight']; ?> кг</td>
                        <td class="center"><?= $item['player_height']; ?> см</td>
                        <td>
                            <img
                                alt="<?= $item['mood_name']; ?>"
                                class="img-12"
                                src="/img/mood/<?= $item['mood_id']; ?>.png"
                            />
                            <?= $item['mood_name']; ?>
                        </td>
                        <td class="center"><?= $item['player_condition']; ?> %</td>
                        <td class="center"><?= $item['player_practice']; ?> %</td>
                        <td class="right"><?= f_igosja_money($item['player_price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>