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
                            src="img/team/12/<?= $staff_array[0]['team_id']; ?>.png"
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
                            src="img/flag/12/<?= $staff_array[0]['country_id']; ?>.png"
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
                                    src="img/flag/12/<?= $item['country_id']; ?>.png"
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
</table>