<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Активные предложения</p>
            <table class="striped w100">
                <tr>
                    <th colspan="8">Сделки, которые будут оформлены в ближайшее трансферное окно</th>
                </tr>
                <tr>
                    <th class="w1"></th>
                    <th>Имя игрока</th>
                    <th colspan="2">Клуб</th>
                    <th colspan="2">Лига</th>
                    <th class="w10">Тип сделки</th>
                    <th class="w10">Сумма</th>
                </tr>
                <?php foreach ($transfer_array as $item) { ?>
                    <tr>
                        <td class="center">
                            <img
                                class="img-12"
                                src="/img/arrow/<?php if ($num == $item['transfer_buyer_id']) { ?>red<?php } else { ?>green<?php } ?>.png"
                            />
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
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
                        <td class="w20">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <?= $item['offertype_name']; ?>
                        </td>
                        <td class="right"><?= f_igosja_money($item['transfer_price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="8">Отправленные предложения</th>
                </tr>
                <tr>
                    <th>Имя игрока</th>
                    <th colspan="2">Клуб</th>
                    <th colspan="2">Лига</th>
                    <th class="w10">Тип сделки</th>
                    <th class="w10">Сумма</th>
                    <th class="w10">Действия</th>
                </tr>
                <?php foreach ($offer_from_me_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
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
                        <td class="w20">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <?= $item['offertype_name']; ?>
                        </td>
                        <td class="right"><?= f_igosja_money($item['playeroffer_price']); ?></td>
                        <td class="center">
                            <a href="team_team_transfer_center.php?num=<?= $num; ?>&from_del=<?= $item['playeroffer_id']; ?>" class="link-img link-delete"></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="8">Полученные предложения</th>
                </tr>
                <tr>
                    <th>Имя игрока</th>
                    <th colspan="2">Клуб</th>
                    <th colspan="2">Лига</th>
                    <th class="w10">Тип сделки</th>
                    <th class="w10">Сумма</th>
                    <th class="w10">Действия</th>
                </tr>
                <?php foreach ($offer_to_me_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
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
                        <td class="w20">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <?= $item['offertype_name']; ?>
                        </td>
                        <td class="right"><?= f_igosja_money($item['playeroffer_price']); ?></td>
                        <td class="center">
                            <a href="team_team_transfer_center.php?num=<?= $num; ?>&to_ok=<?= $item['playeroffer_id']; ?>" class="link-img link-ok"></a>
                            <a href="team_team_transfer_center.php?num=<?= $num; ?>&to_del=<?= $item['playeroffer_id']; ?>" class="link-img link-delete"></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>