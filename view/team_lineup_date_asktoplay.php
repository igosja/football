<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Матчи</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата</th>
                    <th colspan="2">Соперник</th>
                    <th colspan="2">Турнир</th>
                    <th class="w25">Доступность</th>
                </tr>
                <?php foreach ($shedule_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td class="w1">
                            <?php if ($item['team_id']) { ?>
                                <img
                                    alt="<?= $item['team_name']; ?>"
                                    class="img-12"
                                    src="/img/team/12/<?= $item['team_id']; ?>.png"
                                />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($item['team_id']) { ?>
                                <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <?php if ($item['team_id']) { ?>
                                <img
                                    alt="<?= $item['tournament_name']; ?>"
                                    class="img-12"
                                    src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                                />
                            <?php } ?>
                        </td>
                        <td class="w25">
                            <?php if ($item['team_id']) { ?>
                                <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                    <?= $item['tournament_name']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="center">
                            <?php if ($item['team_id'] ||
                                     (0 == $cupparticipant_array[0]['cupparticipant_out'] &&
                                     TOURNAMENT_TYPE_CUP == $item['shedule_tournamenttype_id'])) { ?>
                                Недоступен
                            <?php } else { ?>
                                <a href="javascript:;" class="asktoplay-link" data-shedule="<?= $item['shedule_id']; ?>">
                                    <?php if ($item['asktoplay_shedule_id']) { ?>
                                        Есть предложения
                                    <?php } else { ?>
                                        Доступен
                                    <?php } ?>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w35" id="asktoplay">
            <p class="header">Организовать товарищеский матч</p>
            <table class="striped w100" id="asktoplay-table" style="display:none;">
                <tr>
                    <td class="w50">
                        Дата
                    </td>
                    <td id="asktoplay-date"></td>
                </tr>
                <tr>
                    <td>
                        Место встречи
                    </td>
                    <td>
                        <select id="asktoplay-home">
                            <option value="1">Дома</option>
                            <option value="0">В гостях</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Соперник
                    </td>
                    <td>
                        <select id="astoplay-select-team"></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="center">
                        <button id="asktoplay-submit" data-shedule="">
                            Отправить приглашение
                        </button>
                    </td>
                </tr>
            </table>
            <span id="asktoplay-invitee"></span>
            <span id="asktoplay-inviter"></span>
        </td>
    </tr>
</table>