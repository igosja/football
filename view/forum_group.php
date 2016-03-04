<table class="block-table w100">
    <tr>
        <td class="block-page">
            <table class="w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_id)) { ?>
                            <button>
                                <a href="forum_posting.php?group=<?php print $head_array[0]['forumthemegroup_id']; ?>">
                                    Создать тему
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
                                    <a href="forum_group.php?num=<?php print $num; ?>&page=<?php print $i; ?>">
                                        <?php print $i; ?>
                                    </a>
                                </button>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <table class="forum-group w100">
                <tr>
                    <th colspan="2">Темы</th>
                    <th class="w8">Ответы</th>
                    <th class="w20">Последнее</th>
                </tr>
                <?php foreach ($forum_array as $item) { ?>
                    <tr>
                        <td class="w1">
                            Picture
                        </td>
                        <td>
                            <a href="forum_theme.php?num=<?php print $item['forumtheme_id']; ?>">
                                <?php print $item['forumtheme_name']; ?>
                            </a>
                            <br />
                            <?php print $item['user_login']; ?>,
                            <?php print f_igosja_ufu_date_time($item['forumtheme_date']); ?>
                        </td>
                        <td class="center vcenter"><?php print $item['count_post']; ?></td>
                        <td>
                            <?php print $item['post_login']; ?>
                            <br />
                            <?php print f_igosja_ufu_date_time($item['forumpost_date']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <table class="w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_id)) { ?>
                            <button>
                                <a href="forum_posting.php?group=<?php print $head_array[0]['forumthemegroup_id']; ?>">
                                    Создать тему
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
                                <a href="forum_group.php?num=<?php print $num; ?>&page=<?php print $i; ?>">
                                    <?php print $i; ?>
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