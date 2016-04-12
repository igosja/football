<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Турнирная история</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Сезон</th>
                    <th colspan="2">Турнир</th>
                    <th class="w10">Место</th>
                </tr>
                <?php foreach ($tournament_array as $item) { ?>
                    <tr>
                        <td class="center"><?= $item['standing_season_id']; ?></td>
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
                        <td class="center"><?= $item['standing_place']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">История менеджеров</p>
            <table class="striped w100">
                <tr>
                    <th>Дата прихода</th>
                    <th>Дата отставки</th>
                    <th>Менеджер</th>
                </tr>
                <?php foreach ($manager_array as $item) { ?>
                    <tr>
                        <td class="center w25"><?= f_igosja_ufu_date($item['history_date']); ?></td>
                        <td class="center w25"></td>
                        <td><?= $item['user_login']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>