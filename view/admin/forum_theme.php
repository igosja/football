<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header"><?= $header_title; ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <?php foreach ($bread_array as $item) { ?>
                <li><a href="<?= $item['url'] ?>"><?= $item['text'] ?></a></li>
            <?php } ?>
            <li class="active"><?= $bread_last ?></li>
        </ol>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>" class="btn btn-default">
            Ответить
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="col-lg-3">
                        <a href="user.php?num=<?= $head_array[0]['user_id']; ?>"
                            <?php if (1 == $head_array[0]['user_id']) { ?>class="red"<?php } ?>
                        >
                            <?= $head_array[0]['user_login']; ?>
                        </a>
                        <br />
                        <?php if ($head_array[0]['team_id']) { ?>
                            <a href="team.php?num=<?= $head_array[0]['team_id']; ?>">
                                <?= $head_array[0]['team_name']; ?>
                                (<?= $head_array[0]['city_name']; ?>, <?= $head_array[0]['country_name']; ?>)
                            </a>
                            <br />
                        <?php } ?>
                        <?= f_igosja_ufu_date_time($head_array[0]['forumtheme_date']); ?>
                        <br/>
                        <?php if (isset($authorization_id) && $authorization_id != $head_array[0]['user_id']) { ?>
                            <a href="/profile_news_outbox.php?answer=<?= $head_array[0]['user_id']; ?>" class="btn btn-default">
                                ЛC
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="forum_theme_delete.php?num=<?= $num_get; ?>">
                            Удалить
                        </a>
                        <br/>
                        <?= nl2br($head_array[0]['forumtheme_text']); ?>
                    </td>
                </tr>
                <?php for ($i=0; $i<$count; $i++) { ?>
                    <tr>
                        <td>
                            <a href="user.php?num=<?= $forum_array[$i]['user_id']; ?>"
                                <?php if (1 == $forum_array[$i]['user_id']) { ?>class="red"<?php } ?>
                            >
                                <?= $forum_array[$i]['user_login']; ?>
                            </a>
                            <br />
                            <?php if ($forum_array[$i]['team_id']) { ?>
                                <a href="team.php?num=<?= $forum_array[$i]['team_id']; ?>">
                                    <?= $forum_array[$i]['team_name']; ?>
                                    (<?= $forum_array[$i]['city_name']; ?>, <?= $forum_array[$i]['country_name']; ?>)
                                </a>
                                <br />
                            <?php } ?>
                            <?= f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?>
                            <br />
                            <?php if (isset($authorization_id) && $authorization_id != $forum_array[$i]['user_id']) { ?>
                                <a href="/profile_news_outbox.php?answer=<?= $forum_array[$i]['user_id']; ?>" class="btn btn-default">
                                    ЛC
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="forum_post_delete.php?num=<?= $forum_array[$i]['forumpost_id']; ?>">
                                Удалить
                            </a>
                            |
                            <a href="forum_posting.php?theme=<?= $head_array[0]['forumtheme_id']; ?>&answer=<?= $forum_array[$i]['forumpost_id']; ?>">
                                Цитата
                            </a>
                            <br/>
                            <?= nl2br(str_replace('[/quote]', '</code>', str_replace('[quote]', '<code>', $forum_array[$i]['forumpost_text']))); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 text-center">
        <nav>
            <ul class="pagination pagination-sm">
                <?php for ($i=1; $i<=$count_forum; $i++) { ?>
                    <?php if ($i == 1 ||
                        $i == $count_forum ||
                        ($i >= $page - 2 &&
                            $i <= $page + 2)) { ?>
                        <li <?php if ($i == $page) { ?>class="active"<?php } ?>>
                            <a href="forum_theme.php?num=<?= $num_get; ?>&page=<?= $i; ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>