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
                            <a href="team_lineup_tactic_review.php?num=<?= $num; ?>&game=<?= $item['game_id']; ?>">
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
        <td class="block-page center">
            <div id="field-icon" class="relative"></div>
            <img src="/img/field/tactic-player.png" />
        </td>
        <td class="block-page w50" rowspan="3">
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
                                data-id="<?= $item['player_id']; ?>"
                                <?php foreach ($lineup_array as $lineup) { ?>
                                    <?php if ($lineup['lineup_player_id'] == $item['player_id']) { ?>
                                        data-position="<?= $lineup['lineup_position_id']; ?>"
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
                                        data-role="<?= $lineup['lineup_role_id']; ?>"
                                    <?php } ?>
                                <?php } ?>
                            >
                            </select>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                            <?php if ($item['disqualification_player_id'] && $disqualification_show) { ?>
                                <img
                                    alt="Дисквалификация"
                                    class="img-12"
                                    src="/img/card/red.png"
                                    title="Дисквалификация"
                                />
                            <?php } ?>
                            <?= f_igosja_player_info_icon($item); ?>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['player_condition']; ?> %</td>
                        <td class="center"><?= $item['player_practice']; ?> %</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <form method="POST" id="lineup-save-form">
                <table class="w100">
                    <tr>
                        <td>
                            <p class="header">Тактика</p>
                            <select id="tactic-select" name="data[formation_id]" class="w100">
                                <?php foreach ($formation_array as $item) { ?>
                                    <option value="<?= $item['formation_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_formation_id'] == $item['formation_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['formation_name']; ?>
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
                                    <option value="<?= $item['gamemood_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_gamemood_id'] == $item['gamemood_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['gamemood_name']; ?>
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
                                    <option value="<?= $item['gamestyle_id']; ?>"
                                        <?php if (isset($lineupmain_array[0]['lineupmain_formation_id']) &&
                                                  $lineupmain_array[0]['lineupmain_gamestyle_id'] == $item['gamestyle_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['gamestyle_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?= SPACE; ?></td>
                    </tr>
                    <tr>
                        <td class="center">
                            <?php for ($i=1; $i<=18; $i++) { ?>
                                <input
                                    id="input-position-<?= $i; ?>"
                                    name="data[position_<?= $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    id="input-player-<?= $i; ?>"
                                    name="data[player_<?= $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    id="input-role-<?= $i; ?>"
                                    name="data[role_<?= $i; ?>]"
                                    type="hidden"
                                    value=""
                                />
                                <input
                                    name="data[lineup_<?= $i; ?>]"
                                    type="hidden"
                                    <?php for ($j=0; $j<$count_lineup; $j++) { ?>
                                        <?php if ($j + 1 == $i) { ?>
                                            value="<?= $lineup_array[$j]['lineup_id']; ?>"
                                        <?php } ?>
                                    <?php } ?>
                                />
                            <?php } ?>
                            <input type="hidden" name="data[save]" value="0" id="lineup-save-field-status" />
                            <input type="hidden" name="data[save_name]" value="" id="lineup-save-field-name" />
                            <input type="submit" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Сохраненные составы</p>
            <p class="center">
                <a href="javascript:;" id="lineup-save-open">
                    <button>
                        Сохранить текущую схему
                    </button>
                </a>
            </p>
            <table class="striped w100">
                <tr>
                    <th class="w50">Имя</th>
                    <th class="w25">Дата</th>
                    <th></th>
                </tr>
                <?php foreach ($lineupsave_array as $item) { ?>
                    <tr>
                        <td><?= $item['lineupsave_name']; ?></td>
                        <td class="center"><?= f_igosja_ufu_date($item['lineupsave_date']); ?></td>
                        <td>
                            <a href="team_lineup_tactic_review.php?num=<?= $num_get; ?>&game=<?= $game_id; ?>&lineupsave_load=<?= $item['lineupsave_id']; ?>">
                                <button>
                                    Зарузить
                                </button>
                            </a>
                            <a href="team_lineup_tactic_review.php?num=<?= $num_get; ?>&game=<?= $game_id; ?>&lineupsave_delete=<?= $item['lineupsave_id']; ?>">
                                <button>
                                    Удалить
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>

<div id="open-modal" class="modal">
    <div>
        <a href="javascript:;" title="Закрыть" class="close-modal">X</a>
        <table class="center bordered w100">
            <tr>
                <td>
                    <strong>Сохранение текущей расстановки игроков</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" id="lineup-save-name" placeholder="Название" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Сохранить" id="lineup-save" />
                </td>
            </tr>
        </table>
    </div>
</div>