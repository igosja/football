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
                            <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                            <td class="center">
                                <?php if ($item['game_home_team_id'] == $authorization_team_id) { ?>
                                    Д
                                <?php } else { ?>
                                    Г
                                <?php } ?>
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
                            <td class="w1">
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            </td>
                            <td class="center">
                                <?= $item['game_temperature']; ?>
                                <img
                                    alt="<?= $item['weather_name']; ?>"
                                    class="img-12"
                                    title="<?= $item['weather_name']; ?>"
                                    src="/img/weather/<?= $item['weather_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_lineup_tactic_team.php?num=<?= $num; ?>&game=<?= $item['game_id']; ?>">
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
                                    <option value="<?= $item['gamestyle_id']; ?>"
                                        <?php if (isset($lineup_array[0]['lineupmain_gamestyle_id']) &&
                                                  $item['gamestyle_id'] == $lineup_array[0]['lineupmain_gamestyle_id']) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $item['gamestyle_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Настрой на игру</td>
                        <td>
                            <select class="w100" id="gamemood-select" name="data[gamemood]">
                                <?php foreach ($gamemood_array as $item) { ?>
                                    <option value="<?= $item['gamemood_id']; ?>"
                                        <?php if (isset($lineup_array[0]['lineupmain_gamemood_id']) &&
                                                  $item['gamemood_id'] == $lineup_array[0]['lineupmain_gamemood_id']) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $item['gamemood_name']; ?></option>
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
                                id="gamestyle-<?= $item['gamestyle_id']; ?>"
                                <?php if (!isset($lineup_array[0]['lineupmain_gamestyle_id']) ||
                                          $item['gamestyle_id'] != $lineup_array[0]['lineupmain_gamestyle_id']) { ?>
                                    style="display: none;"
                                <?php } ?>
                            >
                                <h6><?= $item['gamestyle_name']; ?></h6>
                                <?= $item['gamestyle_description']; ?>
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
                                id="gamemood-<?= $item['gamemood_id']; ?>"
                                <?php if (!isset($lineup_array[0]['lineupmain_gamemood_id']) ||
                                          $item['gamemood_id'] != $lineup_array[0]['lineupmain_gamemood_id']) { ?>
                                    style="display: none;"
                                <?php } ?>
                            >
                                <h6><?= $item['gamemood_name']; ?></h6>
                                <?= $item['gamemood_description']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
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
                        </td>
                        <td class="w33">
                                    <?php } ?>
                            <table class="striped w100">
                                <tr>
                                    <th colspan="2"><?= $instruction_array[$i]['instructionchapter_name']; ?></th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td class="nopadding w1">
                                        <input
                                            name="data[instruction][]"
                                            type="checkbox"
                                            value="<?= $instruction_array[$i]['instruction_id']; ?>"
                                            <?php foreach ($teaminstruction_array as $item) { ?>
                                                <?php if ($item['teaminstruction_instruction_id'] == $instruction_array[$i]['instruction_id']) { ?>
                                                    checked
                                                <?php } ?>
                                            <?php } ?>
                                        />
                                    </td>
                                    <td>
                                        <?= $instruction_array[$i]['instruction_name']; ?>
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
            </td>
        </tr>
        <tr>
            <td class="block-page">
                <p class="header">Замены (пока не работает)</p>
                <table class="striped w100">
                    <tr>
                        <th class="w10">C мин</th>
                        <th>Условие</th>
                        <th class="w30">Уходит</th>
                        <th class="w30">Выходит</th>
                    </tr>
                    <?php for ($i=0; $i<5; $i++) { ?>
                        <?php if (0 < count($lineupsubstitution_array)) { $substitution_item = array_shift($lineupsubstitution_array); }?>
                        <tr>
                            <td class="center">
                                <input
                                    name="data[substitution][<?= $i; ?>][minute]"
                                    size="1"
                                    type="text"
                                    value="<?php
                                    if (isset($substitution_item['lineupsubstitution_minute']))
                                    {
                                        print $substitution_item['lineupsubstitution_minute'];
                                    }
                                    else
                                    {
                                        print '0';
                                    }
                                    ?>"
                                />
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[substitution][<?= $i; ?>][condition]">
                                    <?php foreach ($lineupcondition_array as $condition) { ?>
                                        <option value="<?= $condition['lineupcondition_id']; ?>"
                                            <?php
                                            if (isset($substitution_item['lineupsubstitution_lineupcondition_id']) &&
                                                $substitution_item['lineupsubstitution_lineupcondition_id'] == $condition['lineupcondition_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $condition['lineupcondition_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[substitution][<?= $i; ?>][out]">
                                    <option value="0"></option>
                                    <?php foreach ($player_array as $item) { ?>
                                        <option value="<?= $item['lineup_id']; ?>"
                                            <?php
                                            if (isset($substitution_item['lineupsubstitution_out']) &&
                                                $substitution_item['lineupsubstitution_out'] == $item['lineup_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['surname_name']; ?> (<?= $item['position_name']; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[substitution][<?= $i; ?>][in]">
                                    <option value="0"></option>
                                    <?php foreach ($reserve_array as $item) { ?>
                                        <option value="<?= $item['lineup_id']; ?>"
                                            <?php
                                            if (isset($substitution_item['lineupsubstitution_in']) &&
                                                $substitution_item['lineupsubstitution_in'] == $item['lineup_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['surname_name']; ?> (<?= $item['position_name']; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php unset($substitution_item); ?>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page">
                <p class="header">Стиль игры</p>
                <table class="striped w100">
                    <tr>
                        <th class="w10">С мин</th>
                        <th>Условие</th>
                        <th class="w50">Действие</th>
                    </tr>
                    <?php for ($i=0; $i<5; $i++) { ?>
                        <?php if (0 < count($lineuptactic_array)) { $tactic_item = array_shift($lineuptactic_array); }?>
                        <tr>
                            <td class="center">
                                <input
                                    name="data[tactic][<?= $i; ?>][minute]"
                                    size="1"
                                    type="text"
                                    value="<?php
                                    if (isset($tactic_item['lineuptactic_minute']))
                                    {
                                        print $tactic_item['lineuptactic_minute'];
                                    }
                                    else
                                    {
                                        print '0';
                                    }
                                    ?>"
                                />
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[tactic][<?= $i; ?>][condition]">
                                    <?php foreach ($lineupcondition_array as $condition) { ?>
                                        <option value="<?= $condition['lineupcondition_id']; ?>"
                                            <?php
                                            if (isset($tactic_item['lineuptactic_lineupcondition_id']) &&
                                                $tactic_item['lineuptactic_lineupcondition_id'] == $condition['lineupcondition_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $condition['lineupcondition_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[tactic][<?= $i; ?>][tactic]">
                                    <option value="0"></option>
                                    <?php foreach ($gamemood_array as $item) { ?>
                                        <option value="1;<?= $item['gamemood_id']; ?>"
                                            <?php
                                            if (isset($tactic_item['lineuptactic_gamemood_id']) &&
                                                $tactic_item['lineuptactic_gamemood_id'] == $item['gamemood_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            Настрой - <?= $item['gamemood_name']; ?>
                                        </option>
                                    <?php } ?>
                                    <?php foreach ($gamestyle_array as $item) { ?>
                                        <option value="2;<?= $item['gamestyle_id']; ?>"
                                            <?php
                                            if (isset($tactic_item['lineuptactic_gamestyle_id']) &&
                                                $tactic_item['lineuptactic_gamestyle_id'] == $item['gamestyle_id'])
                                            { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            Стиль - <?= $item['gamestyle_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php unset($tactic_item); ?>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td class="block-page" colspan="2">
                <p class="center">
                    <input type="submit" value="Сохранить" />
                </p>
            </td>
        </tr>
    </table>
</form>