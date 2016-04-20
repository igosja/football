<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Общий</p>
            <table class="w100">
                <tr>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <td class="w50">Страна</td>
                                <td>
                                    <img
                                        alt="<?= $team_array[0]['country_name']; ?>"
                                        class="img-12"
                                        src="/img/flag/12/<?= $team_array[0]['country_id']; ?>.png"
                                    />
                                    <a href="national_team_review_profile.php?num=<?= $team_array[0]['country_id']; ?>">
                                        <?= $team_array[0]['country_name']; ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Сезон основания</td>
                                <td><?= $team_array[0]['team_season_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Финансы</td>
                                <td><?= f_igosja_money($team_array[0]['team_finance']); ?></td>
                            </tr>
                            <tr>
                                <td>Средняя цена на билет</td>
                                <td><?= f_igosja_money($team_array[0]['team_price_ticket']); ?></td>
                            </tr>
                            <tr>
                                <td>Средняя цена на абонемент</td>
                                <td><?= f_igosja_money($team_array[0]['team_price_subscribe']); ?></td>
                            </tr>
                            <tr>
                                <td>Обладатели абонементов</td>
                                <td><?= $team_array[0]['team_subscriber']; ?></td>
                            </tr>
                            <tr>
                                <td>Оценочная стоимость</td>
                                <td><?= f_igosja_money($team_array[0]['team_price']); ?></td>
                            </tr>
                            <tr>
                                <td>Капитан</td>
                                <td>
                                    <a href="player_home_profile.php?num=<?= $team_array[0]['captain_id']; ?>">
                                        <?= $team_array[0]['captain_name']; ?> <?= $team_array[0]['captain_surname']; ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Вице-капитан</td>
                                <td>
                                    <a href="player_home_profile.php?num=<?= $team_array[0]['vicecaptain_id']; ?>">
                                        <?= $team_array[0]['vicecaptain_name']; ?> <?= $team_array[0]['vicecaptain_surname']; ?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>