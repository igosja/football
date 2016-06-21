<table class="block-table w100">
    <tr>
        <td class="block-page block-page-forum">
            <table class="forum-group w100">
                <tr>
                    <th>
                        <?php foreach ($bread_array as $item) { ?>
                            <a href="<?= $item['url'] ?>"><?= $item['text'] ?></a> / 
                        <?php } ?>
                        <?= $bread_last ?>
                    </th>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_id)) { ?>
                            <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>" class="button-link">
                                <button>
                                    Ответить
                                </button>
                            </a>
                        <?php } ?>
                    </td>
                    <td class="right">
                        Страницы:
                        <?php for ($i=1; $i<=$count_forum; $i++) { ?>
                            <?php if ($i == 1 ||
                                      $i == $count_forum ||
                                     ($i >= $page - 2 &&
                                      $i <= $page + 2)) { ?>
                                <a href="forum_theme.php?num=<?= $num; ?>&page=<?= $i; ?>" class="button-link">
                                    <button
                                        <?php if ($i == $page) { ?>
                                            class="button-active"
                                        <?php } ?>
                                    >
                                        <?= $i; ?>
                                    </button>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="forum-group w100">
                <tr>
                    <td class="w25">
                        <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/img/user/90/' . $head_array[0]['user_id'] . '.png')) { ?>
                            <img
                                alt="<?= $head_array[0]['user_login']; ?>"
                                class="img-90"
                                src="/img/user/90/<?= $head_array[0]['user_id']; ?>.png"
                            />
                            <br />
                        <?php } ?>
                        <strong>
                            <a href="manager_home_profile.php?num=<?= $head_array[0]['user_id']; ?>"
                                <?php if (1 == $head_array[0]['user_id']) { ?>class="red"<?php } ?>
                            >
                                <?= $head_array[0]['user_login']; ?>
                            </a>
                        </strong>
                        <br />
                        <?php if ($head_array[0]['team_id']) { ?>
                            <a href="team_team_review_profile.php?num=<?= $head_array[0]['team_id']; ?>">
                                <?= $head_array[0]['team_name']; ?>
                                (<?= $head_array[0]['city_name']; ?>, <?= $head_array[0]['country_name']; ?>)
                            </a>
                            <br />
                        <?php } ?>
                        <p class="grey">Сообщений: <?= $head_array[0]['user_count_message']; ?></p>
                        <p class="grey">Регистрация: <?= f_igosja_ufu_date($head_array[0]['user_registration_date']); ?></p>
                        <?= f_igosja_ufu_last_visit_forum($head_array[0]['user_last_visit']); ?>
                        <?php if (isset($authorization_id) && $authorization_id != $head_array[0]['user_id']) { ?>
                            <a href="profile_news_outbox.php?answer=<?= $head_array[0]['user_id']; ?>" class="button-link">
                                <button>
                                    ЛC
                                </button>
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <p class="justify w100">
                            <span class="grey"><?= f_igosja_ufu_date_time($head_array[0]['forumtheme_date']); ?></span>
                        </p>
                        <p class="justify"><?= nl2br($head_array[0]['forumtheme_text']); ?></p>
                    </td>
                </tr>
                <?php for ($i=0; $i<$count; $i++) { ?>
                    <tr>
                        <td class="w25">
                            <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/img/user/90/' . $forum_array[$i]['user_id'] . '.png')) { ?>
                                <img
                                    alt="<?= $forum_array[$i]['user_login']; ?>"
                                    class="img-90"
                                    src="/img/user/90/<?= $forum_array[$i]['user_id']; ?>.png"
                                />
                                <br />
                            <?php } ?>
                            <strong>
                                <a href="manager_home_profile.php?num=<?= $forum_array[$i]['user_id']; ?>"
                                    <?php if (1 == $forum_array[$i]['user_id']) { ?>class="red"<?php } ?>
                                >
                                    <?= $forum_array[$i]['user_login']; ?>
                                </a>
                            </strong>
                            <br />
                            <?php if ($forum_array[$i]['team_id']) { ?>
                                <a href="team_team_review_profile.php?num=<?= $forum_array[$i]['team_id']; ?>">
                                    <?= $forum_array[$i]['team_name']; ?>
                                    (<?= $forum_array[$i]['city_name']; ?>, <?= $forum_array[$i]['country_name']; ?>)
                                </a>
                                <br />
                            <?php } ?>
                            <p class="grey">Сообщений: <?= $forum_array[$i]['user_count_message']; ?></p>
                            <p class="grey">Рагистрация: <?= f_igosja_ufu_date($forum_array[$i]['user_registration_date']); ?></p>
                            <?= f_igosja_ufu_last_visit_forum($forum_array[$i]['user_last_visit']); ?>
                            <?php if (isset($authorization_id) && $authorization_id != $forum_array[$i]['user_id']) { ?>
                                <a href="profile_news_outbox.php?answer=<?= $forum_array[$i]['user_id']; ?>" class="button-link">
                                    <button>
                                        ЛC
                                    </button>
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <p class="justify w100">
                                <span class="grey"><?= f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?></span>
                                <?php if (isset($authorization_id) && $authorization_id == $forum_array[$i]['user_id']) { ?>
                                    <a href="forum_post_delete.php?num=<?= $forum_array[$i]['forumpost_id']; ?>" class="button-link">
                                        <button class="fright">
                                            Удалить
                                        </button>
                                    </a>
                                <?php }?>
                                <?php if (isset($authorization_id) && $authorization_id != $forum_array[$i]['user_id']) { ?>
                                    <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>&answer=<?= $forum_array[$i]['forumpost_id']; ?>" class="button-link">
                                        <button class="fright">
                                            Цитата
                                        </button>
                                    </a>
                                <?php } ?>
                            </p>
                            <p class="justify"><?= nl2br(str_replace('[/quote]', '</q>', str_replace('[quote]', '<q>', $forum_array[$i]['forumpost_text']))); ?></p>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_id)) { ?>
                            <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>" class="button-link">
                                <button>
                                    Ответить
                                </button>
                            </a>
                        <?php } ?>
                    </td>
                    <td class="right">
                        Страницы:
                        <?php for ($i=1; $i<=$count_forum; $i++) { ?>
                            <?php if ($i == 1 ||
                                      $i == $count_forum ||
                                     ($i >= $page - 2 &&
                                      $i <= $page + 2)) { ?>
                                <a href="forum_theme.php?num=<?= $num; ?>&page=<?= $i; ?>" class="button-link">
                                    <button
                                        <?php if ($i == $page) { ?>
                                            class="button-active"
                                        <?php } ?>
                                    >
                                        <?= $i; ?>
                                    </button>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>