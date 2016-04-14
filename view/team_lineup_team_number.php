<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Игроки</p>
            <form method="POST">
                <table class="striped w100">
                    <tr>
                        <th class="w1">№</th>
                        <th>Имя</th>
                        <th class="w5">Нац</th>
                        <th class="w5">Поз</th>
                        <th class="w5">Воз</th>
                        <th class="w5">Вес</th>
                        <th class="w5">Рост</th>
                        <th class="w15">Настроение</th>
                        <th class="w5">Конд</th>
                        <th class="w5">Фит</th>
                        <th class="w10">Зарплата</th>
                    </tr>
                    <?php foreach ($player_array as $item) { ?>
                        <tr>
                            <td class="center nopadding">
                                <input
                                    class="center"
                                    name="data[<?= $item['player_id']; ?>]"
                                    size="1"
                                    type="text"
                                    value="<?= $item['player_number']; ?>"
                                />
                            </td>
                            <td>
                                <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="center">
                                <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        class="img-12"
                                        src="img/flag/12/<?= $item['country_id']; ?>.png"
                                    />
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
                            <td class="right"><?= f_igosja_money($item['player_salary']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="center" colspan="11">
                            <input type="submit" value="Сохранить">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
