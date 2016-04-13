<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Турнирная таблица</p>
            <table class="striped w100">
                <tr>
                    <th class="w5">№</th>
                    <th colspan="2">Команда</th>
                    <th class="w5">И</th>
                    <th class="w5">В</th>
                    <th class="w5">Н</th>
                    <th class="w5">П</th>
                    <th class="w5">ГЗ</th>
                    <th class="w5">ГП</th>
                    <th class="w5">+/-</th>
                    <th class="w5">О</th>
                </tr>
                <?php foreach ($standing_array as $item) { ?>
                    <tr <?php if (isset($authorization_country_id) && $authorization_country_id == $item['country_id']) { ?>class="current"<?php } ?>>
                        <td class="center"><?= $item['worldcup_place']; ?></td>
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
                        <td class="center"><?= $item['worldcup_game']; ?></td>
                        <td class="center"><?= $item['worldcup_win']; ?></td>
                        <td class="center"><?= $item['worldcup_draw']; ?></td>
                        <td class="center"><?= $item['worldcup_loose']; ?></td>
                        <td class="center"><?= $item['worldcup_score']; ?></td>
                        <td class="center"><?= $item['worldcup_pass']; ?></td>
                        <td class="center"><?= $item['worldcup_difference']; ?></td>
                        <td class="center"><strong><?= $item['worldcup_point']; ?></strong></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>