<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Ситуация на рынке труда</p>
            <table class="w100">
                <tr>
                    <td>
                        <form method="GET">
                            <select name="country">
                                <option value="0">Страна</option>
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?= $item['country_id']; ?>"
                                        <?php if (isset($_GET['country']) && $_GET['country'] == $item['country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="submit" value="Поиск">
                        </form>
                    </td>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=1; $i<=$count_page; $i++) { ?>
                                    <option value="<?= $i; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $i; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th>Менеджер</th>
                    <th colspan="2">Команда</th>
                    <th colspan="2">Страна</th>
                    <th colspan="2">Турнир</th>
                    <th class="w10">Финансы</th>
                </tr>
                <?php foreach ($team_array as $item) { ?>
                    <tr>
                        <td><?= $item['user_login']; ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?= $item['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w20">
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $item['tournament_name']; ?>"
                                class="img-12"
                                src="img/tournament/12/<?= $item['tournament_id']; ?>.png"
                            />
                        </td>
                        <td class="w25">
                            <a href="tournament_review_profile.php?num=<?= $item['tournament_id']; ?>">
                                <?= $item['tournament_name']; ?>
                            </a>
                        </td>
                        <td class="right"><?= f_igosja_money($item['team_finance']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>