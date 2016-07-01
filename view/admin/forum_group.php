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
        <a href="forum_posting.php?group=<?= $head_array[0]['forumthemegroup_id']; ?>" class="btn btn-default">
            Создать тему
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <th class="text-center">Темы</th>
                    <th class="col-lg-1 text-center">Ответы</th>
                    <th class="col-lg-3 text-center">Последнее</th>
                </tr>
                <?php foreach ($forum_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="forum_theme.php?num=<?= $item['forumtheme_id']; ?>">
                                <?= $item['forumtheme_name']; ?>
                            </a>
                            <br />
                            <a href="user.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>,
                            <?= f_igosja_ufu_date_time($item['forumtheme_date']); ?>
                        </td>
                        <td class="text-center"><?= $item['count_post']; ?></td>
                        <td>
                            <a href="user.php?num=<?= $item['post_id']; ?>"
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
                            <a href="forum_group.php?num=<?= $num; ?>&page=<?= $i; ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>