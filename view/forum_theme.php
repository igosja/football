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
                            <button>
                                <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>">
                                    Ответить
                                </a>
                            </button>
                        <?php } ?>
                    </td>
                    <td class="right">
                        Страницы:
                        <?php for ($i=1; $i<=$count_forum; $i++) { ?>
                            <?php if ($i == 1 ||
                                      $i == $count_forum ||
                                     ($i >= $page - 2 &&
                                      $i <= $page + 2)) { ?>
                                <button
                                    <?php if ($i == $page) { ?>
                                        class="button-active"
                                    <?php } ?>
                                >
                                    <a href="forum_theme.php?num=<?= $num; ?>&page=<?= $i; ?>">
                                        <?= $i; ?>
                                    </a>
                                </button>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="forum-group w100">
                <tr>
                    <td class="w25">
                        <strong><?= $head_array[0]['user_login']; ?></strong>
                        <br/>
                        <a href="team_team_review_profile.php?num=<?= $head_array[0]['team_id']; ?>">
                            <?= $head_array[0]['team_name']; ?>
                            (<?= $head_array[0]['city_name']; ?>, <?= $head_array[0]['country_name']; ?>)
                        </a>
                        <br/>
                        <?php if (isset($authorization_id) && $authorization_id != $head_array[0]['user_id']) { ?>
                            <button>
                                <a href="profile_news_outbox.php?answer=<?= $head_array[0]['user_id']; ?>">
                                    ЛC
                                </a>
                            </button>
                        <?php } ?>
                    </td>
                    <td>
                        <p class="justify"><?= nl2br($head_array[0]['forumtheme_text']); ?></p>
                    </td>
                </tr>
                <?php for ($i=0; $i<$count; $i++) { ?>
                    <tr>
                        <td class="w25">
                            <strong><?= $forum_array[$i]['user_login']; ?></strong>
                            <br/>
                            <a href="team_team_review_profile.php?num=<?= $forum_array[$i]['team_id']; ?>">
                                <?= $forum_array[$i]['team_name']; ?>
                                (<?= $forum_array[$i]['city_name']; ?>, <?= $forum_array[$i]['country_name']; ?>)
                            </a>
                            <br/>
                            <?php if (isset($authorization_id) && $authorization_id != $forum_array[$i]['user_id']) { ?>
                                <button>
                                    <a href="profile_news_outbox.php?answer=<?= $forum_array[$i]['user_id']; ?>">
                                        ЛC
                                    </a>
                                </button>
                            <?php } ?>
                        </td>
                        <td>
                            <p class="justify w100">
                                <?= f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?>
                                <?php if (isset($authorization_id) && $authorization_id == $forum_array[$i]['user_id']) { ?>
                                    <button class="fright">
                                        <a href="forum_post_delete.php?num=<?= $forum_array[$i]['forumpost_id']; ?>">
                                            Удалить
                                        </a>
                                    </button>
                                <?php }?>
                            </p>
                            <p class="justify"><?= nl2br($forum_array[$i]['forumpost_text']); ?></p>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_id)) { ?>
                            <button>
                                <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>">
                                    Ответить
                                </a>
                            </button>
                        <?php } ?>
                    </td>
                    <td class="right">
                        Страницы:
                        <?php for ($i=1; $i<=$count_forum; $i++) { ?>
                            <?php if ($i == 1 ||
                                      $i == $count_forum ||
                                     ($i >= $page - 2 &&
                                      $i <= $page + 2)) { ?>
                                <button
                                    <?php if ($i == $page) { ?>
                                        class="button-active"
                                    <?php } ?>
                                >
                                    <a href="forum_theme.php?num=<?= $num; ?>&page=<?= $i; ?>">
                                        <?= $i; ?>
                                    </a>
                                </button>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>