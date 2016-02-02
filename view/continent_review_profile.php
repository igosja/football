<table class="block-table w100">
    <tr>
        <td colspan="2" class="block-page">
            <p class="header">Обзор</p>
            <p class="center">
                <img
                    alt="Лига"
                    src="img/continent/<?php print $num; ?>.png"
                />
            </p>
            <table class="striped w100">
                <tr>
                    <td class="w50">Континент</td>
                    <td><?php print $continent_name; ?></td>
                </tr>
                <tr>
                    <td>Страны</td>
                    <td><?php print $count_country; ?></td>
                </tr>
                <tr>
                    <td>Команды</td>
                    <td><?php print $count_team; ?></td>
                </tr>
            </table>
        </td>
        <td class="block-page w33">
            <p class="header">Ведущие сборные</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Название</th>
                    <th class="w20">Рейтинг</th>
                </tr>
                <?php foreach ($country_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $item['country_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <?php print $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?php print $item['ratingcountry_position']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Лучшие клубы</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Название</th>
                    <th colspan="2">Страна</th>
                </tr>
                <?php foreach ($team_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $item['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w35">
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <?php print $item['country_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Ведущие игроки</p>
            <table class="striped w100">
                <tr>
                    <th class="w50">Имя</th>
                    <th colspan="2">Клуб</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['team_id']; ?>.png"
                            />
                        </td>
                        <td>
                            <a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>">
                                <?php print $item['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Главные трансферы</p>
            <table class="striped w100">
                <tr>
                    <th>Игрок</th>
                    <th colspan="2">Откуда</th>
                    <th colspan="2">Куда</th>
                </tr>
                <?php foreach ($transfer_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['seller_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['seller_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="team_team_review_profile.php?num=<?php print $item['seller_id']; ?>">
                                <?php print $item['seller_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['buyer_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?php print $item['buyer_id']; ?>.png"
                            />
                        </td>
                        <td class="w30">
                            <a href="team_team_review_profile.php?num=<?php print $item['buyer_id']; ?>">
                                <?php print $item['buyer_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>