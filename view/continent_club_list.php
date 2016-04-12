<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Рейтинг</p>
            <table class="w100">
                <tr>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=0; $i<$count_page; $i++) { ?>
                                    <option value="<?= $i + 1; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i + 1) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $i + 1; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th class="w1">Ранг</th>
                    <th colspan="2">Название</th>
                    <th colspan="2">Страна</th>
                    <th class="w50">Рейтинг</th>
                </tr>
                <?php for ($i=0; $i<$count_team; $i++) { ?>
                    <tr>
                        <td class="center">
                            <?php

                            if (isset($_GET['page']))
                            {
                                print $i + 1 + ($_GET['page'] - 1) * 30;
                            }
                            else
                            {
                                print $i + 1;
                            }

                            ?>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?= $team_array[$i]['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $team_array[$i]['team_id']; ?>.png"
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
                                src="img/flag/12/<?= $team_array[$i]['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="national_team_review_profile.php?num=<?= $team_array[$i]['country_id']; ?>">
                                <?= $team_array[$i]['country_name']; ?>
                            </a>
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $team_array[$i]['team_reputation'] / $best_team_array[0]['team_reputation'] * 100; ?>%">
                                    <?= SPACE; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>