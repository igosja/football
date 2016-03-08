<table class="block-table w100">
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
                            <a class="link-img link-ok" href="team_lineup_team_school.php?num=<?php print $num; ?>&ok=<?php print $item['school_id']; ?>"></a>
                        </td>
                        <td>
                            <?php print $item['name_name']; ?>
                            <?php print $item['surname_name']; ?>
                        </td>
                        <td class="center">
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <img
                                    alt="<?php print $item['country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?php print $item['country_id']; ?>.png"
                                />
                            </a>
                        </td>
                        <td class="center"><?php print $item['position_name']; ?></td>
                        <td class="center">17</td>
                        <td class="center"><?php print $item['school_weight']; ?> кг</td>
                        <td class="center"><?php print $item['school_height']; ?> см</td>
                        <td>
                            <img
                                alt="<?php print $item['mood_name']; ?>"
                                class="img-12"
                                src="/img/mood/<?php print $item['mood_id']; ?>.png"
                            />
                            <?php print $item['mood_name']; ?>
                        </td>
                        <td class="center"><?php print $item['school_condition']; ?> %</td>
                        <td class="center"><?php print $item['school_practice']; ?> %</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>
