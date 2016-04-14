<table class="block-table w100">
    <tr>
        <tr>
            <td class="block-page" colspan="3">
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
                                    src="img/team/12/<?= $item['team_id']; ?>.png"
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
                                    src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
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
                                    src="img/weather/<?= $item['weather_id']; ?>.png"
                                />
                            </td>
                            <td>
                                <a href="team_lineup_tactic_player.php?num=<?= $num; ?>&game=<?= $item['game_id']; ?>">
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
        <td class="block-page w10">
            <p class="header">Схема</p>
            <div id="field-icon" class="relative"></div>
            <img src="img/field/tactic-player.png" />
            <input type="hidden" value="<?= $lineup_array[0]['lineupmain_formation_id']; ?>" id="tactic-player-formation">
            <input type="hidden" value="<?= $game_id; ?>" id="tactic-player-game">
        </td>
        <td class="block-page w45" rowspan="2">
            <p class="header">
                Позиция <span id="position-name"></span>
            </p>
            <form method="POST">
                <p id="role-name"></p>
                <br />
                <p id="role-description"></p>
                <input id="lineup-id" name="data[lineup_id]" type="hidden" value="" />
                <br />
                <p class="center" id="submit-role" style="display: none;">
                    <input type="submit" value="Сохранить" />
                </p>
            </form>
        </td>
        <td class="block-page">
            <p class="header">
                <span id="player-name"></span>
            </p>
            <table class="none striped w100" id="player-table">
                <tr>
                    <td>Игрок</td>
                    <td id="table-player-name"></td>
                </tr>
                <tr>
                    <td class="w50">Позиция</td>
                    <td id="table-player-position-name"></td>
                </tr>
                <tr>
                    <td>Количество игр на позиции</td>
                    <td id="table-player-position-game"></td>
                </tr>
                <tr>
                    <td>Средняя оценка</td>
                    <td id="table-player-mark"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>