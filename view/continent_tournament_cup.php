<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Кубки стран</p>
            <table class="w100">
                <tr>
                    <?php for ($i=0; $i<3; $i++) { ?>
                        <td class="w33">
                            <table class="striped w100">
                                <tr>
                                    <td class="center">
                                        <img
                                            alt="<?= $tournament_array[$i]['tournament_name']; ?>"
                                            class="img-90"
                                            src="/img/tournament/90/<?= $tournament_array[$i]['tournament_id']; ?>.png"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        <img
                                            alt="<?= $tournament_array[$i]['country_name']; ?>"
                                            class="img-12"
                                            src="/img/flag/12/<?= $tournament_array[$i]['country_id']; ?>.png"
                                        />
                                        <?= $tournament_array[$i]['country_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        <img
                                            alt="<?= $tournament_array[$i]['tournament_name']; ?>"
                                            class="img-12"
                                            src="/img/tournament/12/<?= $tournament_array[$i]['tournament_id']; ?>.png"
                                        />
                                        <a href="tournament_review_profile.php?num=<?= $tournament_array[$i]['tournament_id']; ?>">
                                            <?= $tournament_array[$i]['tournament_name']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        Текущий обладатель титула:
                                        <?php if (isset($tournament_array[$i]['team_name'])) { ?>
                                        <img
                                            alt="<?= $tournament_array[$i]['team_name']; ?>"
                                            class="img-12"
                                            src="/img/team/12/<?= $tournament_array[$i]['team_id']; ?>.png"
                                        />
                                        <a href="team_team_review_profile.php?num=<?= $tournament_array[$i]['team_id']; ?>">
                                            <?= $tournament_array[$i]['team_name']; ?>
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        Рейтинг: <?= f_igosja_five_star($tournament_array[$i]['tournament_reputation'], 12); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    <?php } ?>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Название соревнования</th>
                    <th colspan="2">Победитель</th>
                    <th colspan="2">Страна</th>
                    <th class="w10">Рейтинг</th>
                </tr>
                <?php foreach ($tournament_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="/img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <?php if (isset($tournament_array[$i]['team_name'])) { ?>
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="/img/team/12/<?= $item['team_id']; ?>.png"
                            />
                            <?php } ?>
                        </td>
                        <td class="left w20">
                            <?php if (isset($tournament_array[$i]['team_name'])) { ?>
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                            <?php } ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="/img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td class="left w20">
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= f_igosja_five_star($item['tournament_reputation'], 12); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>