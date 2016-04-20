<table class="block-table w100">
    <tr>
        <td rowspan="2" class="block-page w30">
            <p class="header">Таблица травм</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Команда</th>
                    <th class="w25">Игрок</th>
                    <th class="w20">Травма</th>
                    <th class="w20">Дней до выздоровления</th>
                </tr>
                <?php foreach ($injury_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td><?= $item['injurytype_name']; ?></td>
                        <td class="center"><?= $item['day']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    <tr>
</table>