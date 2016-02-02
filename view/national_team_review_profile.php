<table class="block-table w100">
    <tr>
        <td class="block-page w33" rowspan="2">
            <p class="header">Профиль страны</p>
            <table class="center w100">
                <tr>
                    <td><img alt="" class="img-90" src="img/flag/90/<?php print $get_num; ?>.png" /></td>
                </tr>
                <tr>
                    <td>
                        <table class="left striped w100">
                            <tr>
                                <td class="w50">Стадион</td>
                                <td><?php print $country_array[0]['stadium_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Вместимость стадиона</td>
                                <td><?php print number_format($country_array[0]['stadium_capacity'], 0, ',', ' '); ?></td>
                            </tr>
                            <tr>
                                <td>Сезон основания<br />Футбольной ассоциации</td>
                                <td><?php print $country_array[0]['country_season_id']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page w33" rowspan="2">
            <p class="header">Профиль менеджера</p>
            <table class="left striped w100">
                <tr>
                    <td>Имя</td>
                    <td>
                        <?php print $country_array[0]['user_firstname']; ?> <?php print $country_array[0]['user_lastname']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Год рождения</td>
                    <td><?php print $country_array[0]['user_birth_year']; ?></td>
                </tr>
                <tr>
                    <td>Гражданство</td>
                    <td>
                        <img
                            alt="<?php print $country_array[0]['user_country_name']; ?>"
                            class="img-12"
                            src="img/flag/12/<?php print $country_array[0]['user_country_id']; ?>.png"
                        />
                        <?php print $country_array[0]['user_country_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Дата регистрации</td>
                    <td><?php print f_igosja_ufu_date($country_array[0]['user_registration_date']); ?></td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Следующий матч</p>
            <?php foreach ($nearest_game_array as $item) { ?>
                <table class="center w100">
                    <tr>
                        <td>
                            <a href="tournament_review_profile.php?num=<?php print $item['tournament_id']; ?>">
                                <?php print $item['tournament_name']; ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><?php print SPACE; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <img
                                alt="<?php print $item['country_name']; ?>"
                                class="img-50"
                                src="img/flag/50/<?php print $item['country_id']; ?>.png"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>">
                                <?php print $item['country_name']; ?>
                            </a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Мировой рейтинг</p>
            <table class="center w100">
                <tr>
                    <td><h1><?php print $rating_array[0]['ratingcountry_position']; ?></h1></td>
                </tr>
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
                        <td class="w1"><img alt="" class="img-12" src="img/team/12/<?php print $item['team_id']; ?>.png" /></td>
                        <td><a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>"><?php print $item['team_name']; ?></a></td>
                        <td class="w1"><img alt="" class="img-12" src="img/flag/12/<?php print $item['country_id']; ?>.png" /></td>
                        <td><a href="national_team_review_profile.php?num=<?php print $item['country_id']; ?>"><?php print $item['country_name']; ?></a></td>
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
                        <td><a href="player_home_profile.php?num=<?php print $item['player_id']; ?>"><?php print $item['name_name']; ?> <?php print $item['surname_name']; ?></a></td>
                        <td class="w1"><img alt="" class="img-12" src="img/team/12/<?php print $item['team_id']; ?>.png" /></td>
                        <td><a href="team_team_review_profile.php?num=<?php print $item['team_id']; ?>"><?php print $item['team_name']; ?></a></td>
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