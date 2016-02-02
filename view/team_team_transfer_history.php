<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Пришли</p>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th class="w40">Игрок</th>
                    <th colspan="2">Клуб</th>
                    <th class="w15">Сделка</th>
                    <th class="w15">Сумма</th>
                </tr>
                <?php foreach ($transferhistory_buy_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print f_igosja_ufu_date($item['transferhistory_date']); ?></td>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
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
                        <td class="center"><?php print $item['offertype_name']; ?></td>
                        <td class="right"><?php print f_igosja_money($item['transferhistory_price']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="center">Всего</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="right"><?php print f_igosja_money($transferhistory_buy_summ[0]['transferhistory_total_price']); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Ушли</p>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th class="w40">Игрок</th>
                    <th colspan="2">Клуб</th>
                    <th class="w15">Сделка</th>
                    <th class="w15">Сумма</th>
                </tr>
                <?php foreach ($transferhistory_sell_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print f_igosja_ufu_date($item['transferhistory_date']); ?></td>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
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
                        <td class="center"><?php print $item['offertype_name']; ?></td>
                        <td class="right"><?php print f_igosja_money($item['transferhistory_price']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="center">Всего</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="right"><?php print f_igosja_money($transferhistory_sell_summ[0]['transferhistory_total_price']); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>