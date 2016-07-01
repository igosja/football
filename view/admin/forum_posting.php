<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">
            <?php if (isset($forum_array[0]['forumthemegroup_name'])) { ?>
                <?= $forum_array[0]['forumthemegroup_name']; ?>
            <?php } else { ?>
                <?= $forum_array[0]['forumtheme_name']; ?>
            <?php } ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form method="POST">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Заголовок" name="name"
                    <?php if (isset($forum_array[0]['forumtheme_name'])) { ?>
                        value="RE: <?= $forum_array[0]['forumtheme_name']; ?>"
                    <?php } ?>
                />
            </div>
            <div class="form-group">
                <textarea rows="10" class="form-control" placeholder="Сообщение" name="text"><?php
                    if (isset($answer_array[0]['forumpost_text'])) { ?>[quote]<?= $answer_array[0]['forumpost_text']; ?>[/quote]<?php }
                ?></textarea>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-default" value="Добавить сообщение" />
            </div>
        </form>
    </div>
</div>