<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">В аренде</p>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th class="w5">Поз</th>
                    <th colspan="2">Клуб</th>
                    <th class="w5">Окончание</th>
                    <th class="w5">Игры</th>
                    <th class="w5">Гол</th>
                    <th class="w5">Гпас</th>
                    <th class="w5">СрО</th>
                    <th class="w5">Цена</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center">В</td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w10">
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= f_igosja_ufu_date($item['rent_end_date']); ?></td>
                        <td class="center"><?= $item['count_game']; ?></td>
                        <td class="center"><?= $item['count_goal']; ?></td>
                        <td class="center"><?= $item['count_pass']; ?></td>
                        <td class="center"><?= $item['average_mark']; ?></td>
                        <td class="right"><?= f_igosja_money($item['rent_price']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>