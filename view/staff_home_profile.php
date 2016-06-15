<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Персональные данные</p>
            <table class="striped w100">
                <tr>
                    <td>Команда</td>
                    <td>
                        <img
                            alt="<?= $staff_array[0]['team_name']; ?>"
                            class="img-12"
                            src="/img/team/12/<?= $staff_array[0]['team_id']; ?>.png"
                        />
                        <a href="team_team_review_profile.php?num=<?= $staff_array[0]['team_id']; ?>">
                            <?= $staff_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Национальность</td>
                    <td>
                        <img
                            alt="<?= $staff_array[0]['country_name']; ?>"
                            class="img-12"
                            src="/img/flag/12/<?= $staff_array[0]['country_id']; ?>.png"
                        />
                        <a href="national_team_review_profile.php?num=<?= $staff_array[0]['country_id']; ?>">
                            <?= $staff_array[0]['country_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Возраст</td>
                    <td><?= $staff_array[0]['staff_age']; ?></td>
                </tr>
                <tr>
                    <td>Репутация</td>
                    <td><?= f_igosja_five_star($staff_array[0]['staff_reputation'], 12); ?></td>
                </tr>
                <tr>
                    <td>Должность</td>
                    <td><?= $staff_array[0]['staffpost_name']; ?></td>
                </tr>
            </table>
        </td>
        <?php if (6 == $staff_array[0]['staffpost_id']) { ?>
            <td class="block-page">
                <p class="header">Уровень знания</p>
                <table class="striped w100">
                    <?php foreach ($scout_array as $item) { ?>
                        <tr>
                            <td class="w25">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    class="img-12"
                                    src="/img/flag/12/<?= $item['country_id']; ?>.png"
                                />
                                <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $item['count_scout']; ?>%"></div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        <?php } else { ?>
            <td class="block-page">
                <p class="header">Характеристики</p>
                <table class="w100">
                    <tr>
                        <?php for ($i=0; $i<$count_attribute; $i++) { ?>
                            <?php

                            if (!isset($attribute_array[$i-1]['attributechapterstaff_name']) ||
                                $attribute_array[$i-1]['attributechapterstaff_name'] != $attribute_array[$i]['attributechapterstaff_name'])
                            {

                            ?>
                                <td class="w50">
                                    <table class="striped w100">
                                        <tr>
                                            <th colspan="2"><?= $attribute_array[$i]['attributechapterstaff_name']; ?></th>
                                        </tr>
                            <?php } ?>
                                <tr>
                                    <td><?= $attribute_array[$i]['attributestaff_name']; ?></td>
                                    <td class="w50">
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?= $attribute_array[$i]['staffattribute_value']; ?>%"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php

                            if (!isset($attribute_array[$i+1]['attributechapterstaff_name']) ||
                                $attribute_array[$i+1]['attributechapterstaff_name'] != $attribute_array[$i]['attributechapterstaff_name'])
                            {

                            ?>
                                    </table>
                                </td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                </table>
            </td>
        <?php } ?>
    </tr>
    <?php if (6 == $staff_array[0]['staffpost_id']) { ?>
        <tr>
            <td class="block-page" colspan="2">
                <p class="header">Изученные игроки</p>
                <table class="w100">
                    <tr>
                        <td class="right">
                            <form method="GET" id="page-form">
                                <input type="hidden" name="num" value="<?= $num_get; ?>" />
                                Старница:
                                <select name="page" id="page-select">
                                    <?php for ($i=0; $i<$count_page; $i++) { ?>
                                        <option value="<?= $i + 1; ?>"
                                            <?php if (isset($_GET['page']) && $_GET['page'] == $i + 1) { ?>
                                                selected
                                            <?php } ?>
                                        ><?= $i + 1; ?></option>
                                    <?php } ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                </table>
                <table class="striped w100">
                    <tr>
                        <th>Имя</th>
                        <th class="w15">Команда</th>
                        <th class="w1">Нац</th>
                        <th class="w5">Поз</th>
                        <th class="w5">Воз</th>
                        <th class="w5">Вес</th>
                        <th class="w5">Рост</th>
                        <th class="w15">Настроение</th>
                        <th class="w10">Зарплата</th>
                    </tr>
                    <?php foreach ($player_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td>
                                <img
                                    alt="<?= $item['team_name']; ?>"
                                    class="img-12"
                                    src="/img/team/12/<?= $item['team_id']; ?>.png"
                                />
                                <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?>
                                </a>
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
                            <td class="right"><?= f_igosja_money($item['player_salary']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    <?php } ?>
</table>