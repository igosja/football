<table class="block-table w100">
    <tr>
        <td class="block-page" id="application-block">
            <p class="header">Голосование за тренера национальной сборной</p>
            <form method="POST">
                <table class="striped w100">
                    <tr>
                        <th class="w10">Голоса</th>
                        <th class="w20">Кандидат</th>
                        <th class="w20">Команда</th>
                        <th>Текст заявки</th>
                    </tr>
                    <?php foreach ($application_array as $item) { ?>
                        <tr>
                            <td class="center">
                                <?php if (0 == $coachvote_array[0]['count']) { ?>
                                    <input type="radio" name="application_id" value="<?=$item['coachapplication_id']?>" />
                                <?php } else { ?>
                                    <?=$item['count']?>
                                <?php } ?>
                            </td>
                            <td>
                                <strong>
                                    <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>">
                                        <?= $item['user_login']; ?>
                                    </a>
                                </strong>
                                <br />
                                Дата регистрации - <?=f_igosja_ufu_date($item['user_registration_date'])?>
                                <br />
                                Клубных постов в карьере - <?=$item['user_team']?>
                                Сборных постов в карьере - <?=$item['user_national']?>
                            </td>
                            <td>
                                <a href="team_team_review_profile.php?num=<?=nl2br($item['team_id'])?>">
                                    <?=nl2br($item['team_name'])?>
                                </a>
                            </td>
                            <td><?=nl2br($item['coachapplication_text'])?></td>
                        </tr>
                    <?php } ?>
                    <?php if (0 == $coachvote_array[0]['count']) { ?>
                        <tr>
                            <td class="center" colspan="4">
                                <input type="submit" value="Голосовать" />
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </td>
    </tr>
</table>