<table class="block-table w100">
    <tr>
        <td class="block-page w100">
            <p class="header">Факты</p>
            <table class="striped w100">
                <tr>
                    <th class="w30">Факт</th>
                    <th class="w35"><?= $team_name; ?></th>
                    <th><?= $tournament_array[0]['tournament_name']; ?></th>
                </tr>
                <tr>
                    <td>Самый низкий игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['low_id']; ?>">
                            <?= $team_fact_array[0]['low_name']; ?>
                            <?= $team_fact_array[0]['low_surname']; ?>
                        </a>
                        (<?= $team_fact_array[0]['low_height']; ?> см)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['low_id']; ?>">
                            <?= $tournament_fact_array[0]['low_name']; ?>
                            <?= $tournament_fact_array[0]['low_surname']; ?>
                        </a>
                        (<?= $tournament_fact_array[0]['low_height']; ?> см)
                    </td>
                </tr>
                <tr>
                    <td>Самый высокий игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['tall_id']; ?>">
                            <?= $team_fact_array[0]['tall_name']; ?>
                            <?= $team_fact_array[0]['tall_surname']; ?>
                        </a>
                        (<?= $team_fact_array[0]['tall_height']; ?> см)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['tall_id']; ?>">
                            <?= $tournament_fact_array[0]['tall_name']; ?>
                            <?= $tournament_fact_array[0]['tall_surname']; ?>
                        </a>
                        (<?= $tournament_fact_array[0]['tall_height']; ?> см)
                    </td>
                </tr>
                <tr>
                    <td>Средний рост</td>
                    <td class="center"><?= $team_fact_array[0]['height_height']; ?> см</td>
                    <td class="center"><?= $tournament_fact_array[0]['height_height']; ?> см</td>
                </tr>
                <tr>
                    <td>Самый легкий игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['light_id']; ?>">
                            <?= $team_fact_array[0]['light_name']; ?>
                            <?= $team_fact_array[0]['light_surname']; ?>
                        </a>
                        (<?= $team_fact_array[0]['light_weight']; ?> кг)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['light_id']; ?>">
                            <?= $tournament_fact_array[0]['light_name']; ?>
                            <?= $tournament_fact_array[0]['light_surname']; ?>
                        </a>
                        (<?= $tournament_fact_array[0]['light_weight']; ?> кг)
                    </td>
                </tr>
                <tr>
                    <td>Самый тяжелый игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['heavy_id']; ?>">
                            <?= $team_fact_array[0]['heavy_name']; ?>
                            <?= $team_fact_array[0]['heavy_surname']; ?>
                        </a>
                        (<?= $team_fact_array[0]['heavy_weight']; ?> кг)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['heavy_id']; ?>">
                            <?= $tournament_fact_array[0]['heavy_name']; ?>
                            <?= $tournament_fact_array[0]['heavy_surname']; ?>
                        </a>
                        (<?= $tournament_fact_array[0]['heavy_weight']; ?> кг)
                    </td>
                </tr>
                <tr>
                    <td>Средний вес</td>
                    <td class="center"><?= $team_fact_array[0]['weight_weight']; ?> кг</td>
                    <td class="center"><?= $tournament_fact_array[0]['weight_weight']; ?> кг</td>
                </tr>
                <tr>
                    <td>Самый высокооплачиваемый игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['expensive_id']; ?>">
                            <?= $team_fact_array[0]['expensive_name']; ?>
                            <?= $team_fact_array[0]['expensive_surname']; ?>
                        </a>
                        (<?= f_igosja_money($team_fact_array[0]['expensive_salary']); ?>)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['expensive_id']; ?>">
                            <?= $tournament_fact_array[0]['expensive_name']; ?>
                            <?= $tournament_fact_array[0]['expensive_surname']; ?>
                        </a>
                        (<?= f_igosja_money($tournament_fact_array[0]['expensive_salary']); ?>)
                    </td>
                </tr>
                <tr>
                    <td>Самый низкооплачиваемый игрок</td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $team_fact_array[0]['cheap_id']; ?>">
                            <?= $team_fact_array[0]['cheap_name']; ?>
                            <?= $team_fact_array[0]['cheap_surname']; ?>
                        </a>
                        (<?= f_igosja_money($team_fact_array[0]['cheap_salary']); ?>)
                    </td>
                    <td class="center">
                        <a href="player_home_profile.php?num=<?= $tournament_fact_array[0]['cheap_id']; ?>">
                            <?= $tournament_fact_array[0]['cheap_name']; ?>
                            <?= $tournament_fact_array[0]['cheap_surname']; ?>
                        </a>
                        (<?= f_igosja_money($tournament_fact_array[0]['cheap_salary']); ?>)
                    </td>
                </tr>
                <tr>
                    <td>Средняя зарплата</td>
                    <td class="center"><?= f_igosja_money($team_fact_array[0]['salary_salary']); ?></td>
                    <td class="center"><?= f_igosja_money($tournament_fact_array[0]['salary_salary']); ?></td>
                </tr>
                <tr>
                    <td>Отечественных футболистов</td>
                    <td class="center"><?= $team_fact_array[0]['count_native']; ?></td>
                    <td class="center"><?= $tournament_fact_array[0]['count_native']; ?></td>
                </tr>
                <tr>
                    <td>Представленные национальности</td>
                    <td class="center"><?= $team_fact_array[0]['count_country']; ?></td>
                    <td class="center"><?= $tournament_fact_array[0]['count_country']; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>