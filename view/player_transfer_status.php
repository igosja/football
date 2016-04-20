<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Общая информация</p>
            <table class="center w100">
                <tr>
                    <td class="w50"><h5><?= f_igosja_money($player_array[0]['player_price']); ?></h5></td>
                    <td class="vcenter" rowspan="3">
                        <img
                            alt="<?= $player_array[0]['team_name']; ?>"
                            class="img-50"
                            src="/img/team/50/<?= $player_array[0]['team_id']; ?>.png"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Цена</td>
                </tr>
                <tr>
                    <td><h5><?= f_igosja_money($player_array[0]['player_salary']); ?></h5></td>
                </tr>
                <tr>
                    <td>Зарплата</td>
                    <td>
                        <a href="team_team_review_profile.php?num=<?= $player_array[0]['team_id']; ?>">
                            <?= $player_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page" rowspan="2">
            <p class="header">Интерес</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Недавние предложения</th>
                    <th class="w25">Дата</th>
                    <th class="w25">Сумма</th>
                </tr>
                <?php foreach ($playeroffer_array as $item) { ?>
                    <tr>
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
                        <td class="center"><?= f_igosja_ufu_date($item['playeroffer_date']); ?></td>
                        <td class="right"><?= f_igosja_money($item['playeroffer_price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Трансферная информация</p>
            <form method="POST">
                <table class="center w100">
                    <tr>
                        <td class="w50">
                            <?php if (isset($authorization_team_id) &&
                                      $authorization_team_id == $player_array[0]['team_id']) { ?>
                                <select class="w100" name="data[statustransfer]">
                                    <?php foreach ($statustransfer_array as $item) { ?>
                                        <option value="<?= $item['statustransfer_id']; ?>"
                                            <?php if ($item['statustransfer_id'] == $player_array[0]['player_statustransfer_id']) { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['statustransfer_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <h5><?= $player_array[0]['statustransfer_name']; ?></h5>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (isset($authorization_team_id) &&
                                      $authorization_team_id == $player_array[0]['team_id']) { ?>
                                <select class="w100" name="data[statusrent]">
                                    <?php foreach ($statusrent_array as $item) { ?>
                                        <option value="<?= $item['statusrent_id']; ?>"
                                            <?php if ($item['statusrent_id'] == $player_array[0]['player_statusrent_id']) { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['statusrent_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <h5><?= $player_array[0]['statusrent_name']; ?></h5>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Трасферный статус</td>
                        <td>Арендный статус</td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= SPACE; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php if (isset($authorization_team_id) &&
                                      $authorization_team_id == $player_array[0]['team_id']) { ?>
                                <select class="w100" name="data[statusteam]">
                                    <?php foreach ($statusteam_array as $item) { ?>
                                        <option value="<?= $item['statusteam_id']; ?>"
                                            <?php if ($item['statusteam_id'] == $player_array[0]['player_statusteam_id']) { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['statusteam_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <h5><?= $player_array[0]['statusteam_name']; ?></h5>
                            <?php } ?>
                        </td>
                        <td class="vcenter">
                            <?php if (isset($authorization_team_id) &&
                                      $authorization_team_id == $player_array[0]['team_id']) { ?>
                                <input name="data[transfer_price]" type="text" value="<?= $player_array[0]['player_transfer_price']; ?>" /> $
                            <?php } else { ?>
                                <h5><?= $player_array[0]['player_transfer_price']; ?> $</h5>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Командный статус</td>
                        <td>Запрашиваемая цена трансфера</td>
                    </tr>
                    <?php if (isset($authorization_team_id) &&
                              $authorization_team_id == $player_array[0]['team_id']) { ?>
                        <tr>
                            <td colspan="2"><?= SPACE; ?></td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2">
                                <input type="submit" value="Сохранить">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </td>
    </tr>
</table>