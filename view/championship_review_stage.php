<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Турнирная таблица</p>
            <table class="striped w100">
                <tr>
                    <th class="w4">№</th>
                    <th colspan="2">Команда</th>
                    <th class="w25">Менеджер</th>
                    <th class="w4">И</th>
                    <th class="w4">В</th>
                    <th class="w4">Н</th>
                    <th class="w4">П</th>
                    <th class="w4">ГЗ</th>
                    <th class="w4">ГП</th>
                    <th class="w4">+/-</th>
                    <th class="w4">О</th>
                </tr>
                <?php foreach ($standing_array as $item) { ?>
                    <tr <?php if (isset($authorization_team_id) && $authorization_team_id == $item['team_id']) { ?>class="current"<?php } ?>>
                        <td class="center"><?= $item['standing_place']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['standing_game']; ?></td>
                        <td class="center"><?= $item['standing_win']; ?></td>
                        <td class="center"><?= $item['standing_draw']; ?></td>
                        <td class="center"><?= $item['standing_loose']; ?></td>
                        <td class="center"><?= $item['standing_score']; ?></td>
                        <td class="center"><?= $item['standing_pass']; ?></td>
                        <td class="center"><?= $item['standing_difference']; ?></td>
                        <td class="center"><strong><?= $item['standing_point']; ?></strong></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>