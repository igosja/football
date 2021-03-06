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
                        <?php if (isset($authorization_user_id)) { ?>
                            <a href="forum_posting.php?group=<?= $head_array[0]['forumthemegroup_id']; ?>" class="button-link">
                                <button>
                                    Создать тему
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
                                <a href="forum_group.php?num=<?= $num; ?>&page=<?= $i; ?>" class="button-link">
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
                    <th>Темы</th>
                    <th class="w8">Ответы</th>
                    <th class="w20">Последнее</th>
                </tr>
                <?php foreach ($forum_array as $item) { ?>
                    <tr>
                        <td>
                            <a
                                href="forum_theme.php?num=<?= $item['forumtheme_id']; ?>"
                                class="forum_group_link
                                <?php
                                if (isset($forumread_array)) {
                                    foreach ($forumread_array as $read) {
                                        if ($read['forumread_forumtheme_id'] == $item['forumtheme_id'] &&
                                            $read['forumread_forumpost_id'] < $item['forumpost_id']) {
                                ?>
                                    strong
                                <?php
                                        }
                                    }
                                }
                                ?>"
                            >
                                <?= $item['forumtheme_name']; ?>
                            </a>
                            <br />
                            <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>"
                                <?php if (1 == $item['user_id']) { ?>class="red"<?php } ?>
                            >
                                <?= $item['user_login']; ?>
                            </a>,
                            <?= f_igosja_ufu_date_time($item['forumtheme_date']); ?>
                        </td>
                        <td class="center vcenter"><?= $item['count_post']; ?></td>
                        <td>
                            <a href="manager_home_profile.php?num=<?= $item['post_id']; ?>"
                                <?php if (1 == $item['post_id']) { ?>class="red"<?php } ?>
                            >
                                <?= $item['post_login']; ?>
                            </a>
                            <br />
                            <?= f_igosja_ufu_date_time($item['forumpost_date']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <table class="striped w100">
                <tr>
                    <td>
                        <?php if (isset($authorization_user_id)) { ?>
                            <a href="forum_posting.php?group=<?= $head_array[0]['forumthemegroup_id']; ?>" class="button-link">
                                <button>
                                    Создать тему
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
                                <a href="forum_group.php?num=<?= $num; ?>&page=<?= $i; ?>" class="button-link">
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