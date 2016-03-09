<table class="block-table w100">
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Ближайшие матчи</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата</th>
                    <th class="w1"></th>
                    <th colspan="2">Соперник</th>
                    <th colspan="2">Турнир</th>
                    <th class="w5">Погода</th>
                    <th class="w1"></th>
                </tr>
                <?php foreach ($nearest_array as $item) { ?>
                    <tr
                        <?php if ($game_id == $item['game_id']) { ?>
                            class="current"
                        <?php } ?>
                    >
                        <td class="center"><?php print f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="center">
                            <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                Д
                            <?php } else { ?>
                                Г
                            <?php } ?>
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
                        <td class="w1">
                            <img
                                alt="<?php print $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?php print $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                <?php print $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <?php print $item['game_temperature']; ?>
                            <img
                                alt=""
                                class="img-12"
                                src="img/weather/<?php print $item['game_weather_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_lineup_tactic_review.php?num=<?php print $num; ?>&game=<?php print $item['game_id']; ?>">
                                <?php if ($item['lineupmain_id']) { ?>
                                    Редактировать
                                <?php } else { ?>
                                    Отправить
                                <?php } ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page w50" rowspan="2">
            <p class="header">Игроки</p>
            <table class="striped w100">
                <tr>
                    <th class="w13"></th>
                    <th class="w13"></th>
                    <th>Имя</th>
                    <th class="w15">Позиция</th>
                    <th class="w15">Кондиции</th>
                    <th class="w15">Фитнес</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td class="nopadding">
                            <select
                                class="position-select w100"
                                data-id="<?php print $item['player_id']; ?>"
                                <?php foreach ($lineup_array as $lineup) { ?>
                                    <?php if ($lineup['lineup_player_id'] == $item['player_id']) { ?>
                                        data-position="<?php print $lineup['lineup_position_id']; ?>"
                                    <?php } ?>
                                <?php } ?>
                            >
                            </select>
                        </td>
                        <td class="nopadding">
                            <select
                                class="role-select w100"
                                <?php foreach ($lineup_array as $lineup) { ?>
                                    <?php if ($lineup['lineup_player_id'] == $item['player_id']) { ?>
                                        data-role="<?php print $lineup['lineup_role_id']; ?>"
                                    <?php } ?>
                                <?php } ?>
                            >
                            </select>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['position_name']; ?></td>
                        <td class="center"><?php print $item['player_condition']; ?> %</td>
                        <td class="center"><?php print $item['player_practice']; ?> %</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page center">
            <div id="field-icon" class="relative"></div>
            <img src="img/field/tactic-player.png" />
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <form method="POST">
                <table class="w100">
                    <tr>
                        <td>
                            <p class="header">Тактика</p>
                            <select id="tactic-select" name="data[formation_id]" class="w100">
                                <?php foreach ($formation_array as $item) { ?>
                                    <option value="<?php print $item['formation_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_formation_id'] == $item['formation_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['formation_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="header">Настрой</p>
                            <select name="data[gamemood_id]" class="w100">
                                <?php foreach ($gamemood_array as $item) { ?>
                                    <option value="<?php print $item['gamemood_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_gamemood_id'] == $item['gamemood_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['gamemood_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="header">Стиль игры</p>
                            <select name="data[gamestyle_id]" class="w100">
                                <?php foreach ($gamestyle_array as $item) { ?>
                                    <option value="<?php print $item['gamestyle_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_gamestyle_id'] == $item['gamestyle_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['gamestyle_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php print SPACE; ?></td>
                    </tr>
                    <tr>
                        <td class="center">
                            <?php for ($i=1; $i<=18; $i++) { ?>
                                <input
                                    id="input-position-<?php print $i; ?>"
                                    name="data[position_<?php print $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    id="input-player-<?php print $i; ?>"
                                    name="data[player_<?php print $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    id="input-role-<?php print $i; ?>"
                                    name="data[role_<?php print $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    name="data[lineup_<?php print $i; ?>]"
                                    type="hidden"
                                    <?php for ($j=0; $j<$count_lineup; $j++) { ?>
                                        <?php if ($j + 1 == $i) { ?>
                                            value="<?php print $lineup_array[$j]['lineup_id']; ?>"
                                        <?php } ?>
                                    <?php } ?>
                                />
                            <?php } ?>
                            <input type="submit" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>