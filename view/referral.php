<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Ваши подопечные</p>
            <p class="justify">Вместе играть веселее. Чем больше менеджеров играют в Лиге, тем интереснее и разнообразнее становится игра. Мы предлагам вам - нашим менеджерам: <strong>приглашайте в игру новых участников</strong>. Вы можете рассказать о нашей игре своим друзьям, знакомым, сотрудникам, одноклассникам и одногруппникам, посетителям вашего блога или сайта, на своем любимом форуме или чате, в социальной сети. Публикуйте статьи, обзоры, сообщения, объявления, рекламные баннеры, создайте тему на игровом форуме - всё то, что вам доступно, только не пользуйтесь запрещёнными законодательством методами (например, спам).</p>
            <br />
            <p class="justify">Используйте для приглашения вашу <strong>личную ссылку</strong> на наш сайт - вот она:</p>
            <br />
            <h1 class="center">http://<?= $_SERVER['HTTP_HOST']; ?>/?num=<?= $num; ?></h1>
            <br />
            <p class="justify">Все, кто зайдет на сайт по этой ссылке и зарегистрируется в игре, автоматически станут вашими подопечными.</p>
            <p class="justify">На ваш денежный счёт будут всегда зачисляться <strong>10%</strong> от всех единиц, купленных этими игроками!</p>
            <p class="justify">А в случае, если ваш подопечный сможет разобраться в игре, вас ждет дополнительное <strong>вознаграждение</strong> в виде <strong>5 ед.</strong> на денежный счет.</p>
            <br />
            <p class="justify">Условия получения дополнительного вознаграждения:</p>
            <ul>
                <li>Ваш подопечный смог на протяжении 30 дней управлять полученной командой.</li>
                <li>Вы не играли с подопечным на одном компьютере и ваши подопечные тоже между собой не пересекались.</li>
                <li>Администрация не считает, что ваш подопечный может являться подставным аккаунтом.</li>
            </ul>
            <br />
            <p class="justify red">Внимание!</p>
            <ul class="red">
                <li>Запрещено приглашать подопечных способами, которые нарушают законы Российской Федерации (например, рассылать спам).</li>
                <li>Запрещено просить кого-либо перерегистрироваться на сайте, указав вас старшим менеджером.</li>
            </ul>
            <br />
            <p class="justify">Любые средства на денежном счете менеджера являются игровыми и могут быть потрачены только для покупки игровых товаров на нашем сайте.</p>
            <table class="striped w100">
                <tr>
                    <th>Подопечный</th>
                    <th class="w35">Команда</th>
                    <th class="w15">Дата регистрации</th>
                    <th class="w15">Последнее посещение</th>
                </tr>
                <?php foreach ($referral_array as $item) { ?>
                    <tr>
                        <td><?= $item['user_login']; ?></td>
                        <td>
                            <?php if ($item['team_id']) { ?>
                                <img
                                    alt="<?= $item['team_name']; ?>"
                                    class="img-12"
                                    src="/img/team/12/<?= $item['team_id']; ?>.png"
                                />
                                <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="center"><?= f_igosja_ufu_date_time($item['user_registration_date']); ?></td>
                        <td class="center"><?= f_igosja_ufu_last_visit($item['user_last_visit']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>