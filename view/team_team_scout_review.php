<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Знания</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Страна</th>
                    <th class="w33">Игроков изучено</th>
                </tr>
                <?php foreach ($knowledge_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['count_scout_player']; ?> (<?= $item['count_scout']; ?>%)</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w35">
            <p class="header">Скауты</p>
            <table class="striped w100">
                <tr>
                    <th class="w50">Скаут</th>
                    <th class="w50">Зарплата</th>
                </tr>
                <?php foreach ($scout_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="staff_home_profile.php?num=<?= $item['staff_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="right"><?= f_igosja_money($item['staff_salary']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>