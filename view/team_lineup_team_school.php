<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Игроки</p>
            <?php if (isset($school_id)) { ?>
                <p class="center info">
                    Вы собираетесь перевести игрока <?= $name; ?> <?= $surname; ?>, <?= $position; ?> из моложедной команды в основную.<br />
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>&school_id=<?= $school_id; ?>&ok=1">Подтверить</a> |
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>">Отказаться</a>
                </p>
            <?php } else { ?>
                <table class="striped w100">
                    <tr>
                        <th class="w1"></th>
                        <th>Имя</th>
                        <th class="w5">Нац</th>
                        <th class="w5">Поз</th>
                        <th class="w5">Воз</th>
                        <th class="w5">Вес</th>
                        <th class="w5">Рост</th>
                        <th class="w15">Настроение</th>
                        <th class="w5">Конд</th>
                        <th class="w5">Фит</th>
                    </tr>
                    <?php foreach ($school_array as $item) { ?>
                        <tr>
                            <td class="nopadding">
                                <a class="link-img link-ok" href="team_lineup_team_school.php?num=<?= $num; ?>&school_id=<?= $item['school_id']; ?>&ok=0"></a>
                            </td>
                            <td>
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </td>
                            <td class="center">
                                <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        class="img-12"
                                        src="/img/flag/12/<?= $item['country_id']; ?>.png"
                                    />
                                </a>
                            </td>
                            <td class="center"><?= $item['position_name']; ?></td>
                            <td class="center">17</td>
                            <td class="center"><?= $item['school_weight']; ?> кг</td>
                            <td class="center"><?= $item['school_height']; ?> см</td>
                            <td>
                                <img
                                    alt="<?= $item['mood_name']; ?>"
                                    class="img-12"
                                    src="/img/mood/<?= $item['mood_id']; ?>.png"
                                />
                                <?= $item['mood_name']; ?>
                            </td>
                            <td class="center"><?= $item['school_condition']; ?> %</td>
                            <td class="center"><?= $item['school_practice']; ?> %</td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>
