<form method="POST">
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
                                <a href="team_lineup_tactic_team.php?num=<?php print $num; ?>&game=<?php print $item['game_id']; ?>">
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
            <td class="block-page w50">
                <p class="header">Общие</p>
                <table class="w100">
                    <tr>
                        <td class="w50">Стиль игры</td>
                        <td>
                            <select class="w100" id="gamestyle-select" name="data[gamestyle]">
                                <?php foreach ($gamestyle_array as $item) { ?>
                                    <option value="<?php print $item['gamestyle_id']; ?>"
                                        <?php if (isset($lineup_array[0]['lineupmain_gamestyle_id']) &&
                                                  $item['gamestyle_id'] == $lineup_array[0]['lineupmain_gamestyle_id']) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $item['gamestyle_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Настрой на игру</td>
                        <td>
                            <select class="w100" id="gamemood-select" name="data[gamemood]">
                                <?php foreach ($gamemood_array as $item) { ?>
                                    <option value="<?php print $item['gamemood_id']; ?>"
                                        <?php if (isset($lineup_array[0]['lineupmain_gamemood_id']) &&
                                                  $item['gamemood_id'] == $lineup_array[0]['lineupmain_gamemood_id']) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $item['gamemood_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="w100">
                    <?php foreach ($gamestyle_array as $item) { ?>
                        <tr>
                            <td
                                class="gamestyle-td"
                                id="gamestyle-<?php print $item['gamestyle_id']; ?>"
                                <?php if (!isset($lineup_array[0]['lineupmain_gamestyle_id']) ||
                                          $item['gamestyle_id'] != $lineup_array[0]['lineupmain_gamestyle_id']) { ?>
                                    style="display: none;"
                                <?php } ?>
                            >
                                <h6><?php print $item['gamestyle_name']; ?></h6>
                                <?php print $item['gamestyle_description']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <br />
                <table class="w100">
                    <?php foreach ($gamemood_array as $item) { ?>
                        <tr>
                            <td
                                class="gamemood-td"
                                id="gamemood-<?php print $item['gamemood_id']; ?>"
                                <?php if (!isset($lineup_array[0]['lineupmain_gamemood_id']) ||
                                          $item['gamemood_id'] != $lineup_array[0]['lineupmain_gamemood_id']) { ?>
                                    style="display: none;"
                                <?php } ?>
                            >
                                <h6><?php print $item['gamemood_name']; ?></h6>
                                <?php print $item['gamemood_description']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <br />
                <p class="center">
                    <input type="submit" value="Сохранить" />
                </p>
            </td>
            <td class="block-page">
                <p class="header">Инструкции</p>
                <table class="w100">
                    <tr>
                        <td>
                            <?php for ($i=0; $i<$count_instruction; $i++) { ?>
                                <?php if (!isset($instruction_array[$i-1]['instructionchapter_id']) ||
                                          $instruction_array[$i-1]['instructionchapter_id'] != $instruction_array[$i]['instructionchapter_id']) { ?>
                                    <?php if (2 == $instruction_array[$i]['instructionchapter_id'] ||
                                         4 == $instruction_array[$i]['instructionchapter_id']) { ?>
                                    </td><td class="w33">
                                    <?php } ?>
                                    <table class="striped w100">
                                        <tr>
                                            <th colspan="2"><?php print $instruction_array[$i]['instructionchapter_name']; ?></th>
                                        </tr>
                                <?php } ?>
                                <tr>
                                    <td class="nopadding w1">
                                        <input
                                            name="data[instruction][]"
                                            type="checkbox"
                                            value="<?php print $instruction_array[$i]['instruction_id']; ?>"
                                            <?php foreach ($teaminstruction_array as $item) { ?>
                                                <?php if ($item['teaminstruction_instruction_id'] == $instruction_array[$i]['instruction_id']) { ?>
                                                    checked
                                                <?php } ?>
                                            <?php } ?>
                                        />
                                    </td>
                                    <td>
                                        <?php print $instruction_array[$i]['instruction_name']; ?>
                                    </td>
                                </tr>
                                <?php if (!isset($instruction_array[$i+1]['instructionchapter_id']) ||
                                          $instruction_array[$i+1]['instructionchapter_id'] != $instruction_array[$i]['instructionchapter_id']) { ?>
                                    </table>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <br />
                <p class="center">
                    <input type="submit" value="Сохранить" />
                </p>
            </td>
        </tr>
    </table>
</form>