<table class="block-table w100">
    <?php if (isset($school_id)) { ?>
        <tr>
            <td class="block-page">
                <p class="header">Спортшкола</p>
                <p class="center">
                    Вы собираетесь перевести игрока <?= $name; ?> <?= $surname; ?>, <?= $position; ?> из моложедной команды в основную.<br />
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>&school_id=<?= $school_id; ?>&ok=1">
                        <button>
                            Подтверить
                        </button>
                    </a>
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>">
                        <button>
                            Отказаться
                        </button>
                    </a>
                </p>
            </td>
        </tr>
    <?php } elseif (isset($ok)) { ?>
        <tr>
            <td class="block-page">
                <p class="header">Спортшкола</p>
                <p class="center">
                    Вы собираетесь перевести игрока <?= $name; ?> <?= $surname; ?>, <?= $position; ?> из молодежной команды в основную.<br />
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>&data[weight]=<?= $weight; ?>&data[height]=<?= $height; ?>&data[country_id]=<?= $country_id; ?>&data[name_id]=<?= $name_id; ?>&data[surname_id]=<?= $surname_id; ?>&data[position_id]=<?= $position_id; ?>&ok=1" class="button-link">
                        <button>
                            Подтверить
                        </button>
                    </a>
                    <a href="team_lineup_team_school.php?num=<?= $num; ?>" class="button-link">
                        <button>
                            Отказаться
                        </button>
                    </a>
                </p>
            </td>
        </tr>
    <?php } else { ?>
        <p class="center info">
            <?php if (0 == $school_use) { ?>
                Вы больше не можете подписывать юниоров в этом сезоне.
            <?php } else { ?>
                В этом сезоне вы можете перевести в основную команду
                <?php if (1 == $school_use) { ?>
                    <?= $school_use; ?>-го молодого игрока.
                <?php } else { ?>
                    <?= $school_use; ?>-х молодых игроков.
                <?php } ?>
            <?php } ?>
        </p>
        <tr>
            <td class="block-page">
                <p class="header">Созать игрока</p>
                <p class="center">В этом сезоне вы можете перевести в основную команду <?= $school_use; ?>-х молодых игроков</p>
                <form method="GET" id="form-school">
                    <table class="striped w100">
                        <tr>
                            <th class="w1"></th>
                            <th>Имя</th>
                            <th class="w5">Нац</th>
                            <th class="w5">Поз</th>
                            <th class="w5">Воз</th>
                            <th class="w10">Вес</th>
                            <th class="w10">Рост</th>
                            <th class="w15">Настроение</th>
                            <th class="w5">Конд</th>
                            <th class="w5">Фит</th>
                        </tr>
                        <tr>
                            <td class="nopadding">
                                <a class="link-img link-ok" href="javascript:;" id="form-school-link"></a>
                            </td>
                            <td>
                                <select name="data[name_id]">
                                    <?php foreach ($name_array as $item) { ?>
                                        <option value="<?= $item['name_id']; ?>">
                                            <?= $item['name_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <select name="data[surname_id]">
                                    <?php foreach ($surname_array as $item) { ?>
                                        <option value="<?= $item['surname_id']; ?>">
                                            <?= $item['surname_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="center">
                                <a href="national_team_review_profile.php?num=<?= $country_array[0]['country_id']; ?>">
                                    <img
                                        alt="<?= $country_array[0]['country_name']; ?>"
                                        class="img-12"
                                        src="/img/flag/12/<?= $country_array[0]['country_id']; ?>.png"
                                    />
                                </a>
                            </td>
                            <td class="center">
                                <select name="data[position_id]">
                                    <?php foreach ($position_array as $item) { ?>
                                        <option value="<?= $item['position_id']; ?>">
                                            <?= $item['position_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="center">17</td>
                            <td class="center">
                                <select name="data[weight]">
                                    <?php for ($i=65; $i<=105; $i++) { ?>
                                        <option name="<?= $i; ?>">
                                            <?= $i; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                кг
                            </td>
                            <td class="center">
                                <select name="data[height]">
                                    <?php for ($i=165; $i<=200; $i++) { ?>
                                        <option name="<?= $i; ?>">
                                            <?= $i; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                см
                            </td>
                            <td>
                                <img
                                    alt="<?= $mood_array[0]['mood_name']; ?>"
                                    class="img-12"
                                    src="/img/mood/<?= $mood_array[0]['mood_id']; ?>.png"
                                />
                                <?= $mood_array[0]['mood_name']; ?>
                            </td>
                            <td class="center">100 %</td>
                            <td class="center">50 %</td>
                        </tr>
                    </table>
                    <input type="hidden" name="ok" value="0" />
                    <input type="hidden" name="data[country_id]" value="<?= $country_array[0]['country_id']; ?>" />
                </form>
            </td>
        </tr>
        <tr>
            <td class="block-page">
                <p class="header">Игроки</p>
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
            </td>
        </tr>
    <?php } ?>
</table>
