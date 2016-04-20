<table class="block-table w100">
    <tr>
        <td class="block-page w25">
            <p class="header">Голы</p>
            <table class="striped w100">
                <?php foreach ($goal_array as $item) { ?>
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
                        <td class="w15"><?= $item['statisticcountry_goal']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Пропущено</p>
            <table class="striped w100">
                <?php foreach ($pass_array as $item) { ?>
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
                        <td class="w15"><?= $item['statisticcountry_pass']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Красные карточки</p>
            <table class="striped w100">
                <?php foreach ($red_array as $item) { ?>
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
                        <td class="w15"><?= $item['statisticcountry_red']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Желтые карточки</p>
            <table class="striped w100">
                <?php foreach ($yellow_array as $item) { ?>
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
                        <td class="w15"><?= $item['statisticcountry_yellow']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page w25">
            <p class="header">Побед подряд</p>
            <table class="striped w100">
                <?php foreach ($win_array as $item) { ?>
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
                        <td class="w15"><?= $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Игр без поражений подряд</p>
            <table class="striped w100">
                <?php foreach ($no_loose_array as $item) { ?>
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
                        <td class="w15"><?= $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w25">
            <p class="header">Поражений подряд</p>
            <table class="striped w100">
                <?php foreach ($loose_array as $item) { ?>
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
                        <td class="w15"><?= $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Игры без пропущенных мячей</p>
            <table class="striped w100">
                <?php foreach ($nopass_array as $item) { ?>
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
                        <td class="w15"><?= $item['series_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>