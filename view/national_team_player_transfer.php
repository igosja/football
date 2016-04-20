<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Трансферы</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата</th>
                    <th>Игрок</th>
                    <th colspan="2">Продавец</th>
                    <th colspan="2">Покупатель</th>
                    <th class="w15">Сумма</th>
                </tr>
                <?php foreach ($transfer_array as $item) { ?>
                    <tr>
                        <td class="center">
                            <?= f_igosja_ufu_date($item['transferhistory_date']); ?>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['seller_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['seller_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?= $item['seller_id']; ?>">
                                <?= $item['seller_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['buyer_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['buyer_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?= $item['buyer_id']; ?>">
                                <?= $item['buyer_name']; ?>
                            </a>
                        </td>
                        <td class="right">
                            <?= f_igosja_money($item['transferhistory_price']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>