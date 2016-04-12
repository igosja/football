<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Сделать предложение</p>
            <form method="POST">
                <table class="striped w100">
                    <?php if (isset($transfer[0]['team_id'])) { ?>
                        <tr>
                            <td class="center">
                                <h6>
                                    Игрок уже согласовал свой трансфер в команду
                                    <a href="team_team_review_profile.php?num=<?= $transfer[0]['team_id']; ?>">
                                        <?= $transfer[0]['team_name']; ?>
                                    </a>
                                </h6>
                            </td>
                        </tr>
                    <?php } elseif (3 == $player_array[0]['player_statustransfer_id']) { ?>
                        <tr>
                            <td class="center">
                                <h6>
                                    Этот игрок не продается
                                </h6>
                            </td>
                        </tr>
                    <?php } elseif (isset($authorization_team_id) &&
                                  $authorization_team_id == $player_array[0]['team_id']) { ?>
                        <tr>
                            <td class="center">
                                <h6>
                                    Нельзя купить своего игрока
                                </h6>
                            </td>
                        </tr>
                    <?php } elseif (!isset($authorization_team_id)) { ?>
                        <tr>
                            <td class="center">
                                <h6>
                                    Вы не можете предложить трансфер этому игроку
                                </h6>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td class="right">Вид предложения</td>
                            <td class="w50">
                                <select name="data[offer_type]">
                                    <?php foreach ($offertype_array as $item) { ?>
                                        <option value="<?= $item['offertype_id']; ?>">
                                            <?= $item['offertype_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="right">Выплата</td>
                            <td class="vcenter">
                                <input name="data[offer_price]" type="text" value="<?= $player_array[0]['player_transfer_price']; ?>"> $
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Сделать предложение">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </td>
        <td class="block-page w50">
            <p class="header">Информация</p>
            <table class="striped w100">
                <tr>
                    <td class="w50">Команда</td>
                    <td>
                        <img
                            alt="<?= $player_array[0]['team_name']; ?>"
                            class="img-12"
                            src="img/team/12/<?= $player_array[0]['team_id']; ?>.png"
                        />
                        <a href="team_team_review_profile.php?num=<?= $player_array[0]['team_id']; ?>">
                            <?= $player_array[0]['team_name']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Трансферный статус</td>
                    <td><?= $player_array[0]['statustransfer_name']; ?></td>
                </tr>
                <tr>
                    <td>Арендный статус</td>
                    <td><?= $player_array[0]['statusrent_name']; ?></td>
                </tr>
                <tr>
                    <td>Командный статус</td>
                    <td><?= $player_array[0]['statusteam_name']; ?></td>
                </tr>
                <tr>
                    <td>Запрашиваемая цена</td>
                    <td><?= f_igosja_money($player_array[0]['player_transfer_price']); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>