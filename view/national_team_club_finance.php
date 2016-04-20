<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Оценочная стоимость</p>
            <table class="striped w100">
                <tr>
                    <th class="w1">Ранг</th>
                    <th colspan="2">Название</th>
                    <th colspan="2">Страна</th>
                    <th class="w10">Всего</th>
                    <th class="w50"></th>
                </tr>
                <?php for ($i=0; $i<$count_team; $i++) { ?>
                    <tr>
                        <td class="center"><?= $i + 1; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $team_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $team_array[$i]['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?= $team_array[$i]['team_id']; ?>">
                                <?= $team_array[$i]['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $team_array[$i]['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $team_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="national_team_review_profile.php?num=<?= $team_array[$i]['country_id']; ?>">
                                <?= $team_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td class="right"><?= f_igosja_money($team_array[$i]['team_price']); ?></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?= round($team_array[$i]['team_price'] / $team_array[0]['team_price'] * 100); ?>%"></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>