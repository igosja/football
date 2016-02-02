<table class="block-table w100">
    <tr>
        <td class="block-page" id="player-block">
            <p class="header">Игроки</p>
            <table class="striped w100">
                <tr>
                    <th class="w1"></th>
                    <th>Имя</th>
                    <th colspan="2">Команда</th>
                    <th class="w5">Позиция</th>
                    <th class="w5">Воз</th>
                    <th class="w5">Вес</th>
                    <th class="w5">Рост</th>
                    <th class="w5">Настроение</th>
                    <th class="w5">Конд</th>
                    <th class="w5">Фит</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td class="center">
                            <input
                                class="player-national-include"
                                data-player="<?php print $item['player_id']; ?>"
                                type="checkbox"
                                <?php if (0 != $item['player_national_id']) { ?>
                                    checked
                                <?php } ?>
                            />
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?>
                                <?php print $item['surname_name']; ?>
                            </a>
                        </td>
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
                        <td class="center"><?php print $item['position_name']; ?></td>
                        <td class="center"><?php print $item['player_age']; ?></td>
                        <td class="center"><?php print $item['player_weight']; ?> кг</td>
                        <td class="center"><?php print $item['player_height']; ?> см</td>
                        <td class="center">
                            <img
                                alt="<?php print $item['mood_name']; ?>"
                                class="img-12"
                                src="/img/mood/<?php print $item['mood_id']; ?>.png"
                            />
                            <?php print $item['mood_name']; ?>
                        </td>
                        <td class="center"><?php print $item['player_condition']; ?> %</td>
                        <td class="center"><?php print $item['player_practice']; ?> %</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>