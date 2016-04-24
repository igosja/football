<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование группы тем</h1>
        <button type="button" class="btn btn-default">
            <a href="forumthemegroup_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Группа</td>
                    <td>
                        <input
                            class="form-control"
                            name="chapter_name"
                            type="text"
                            value="<?php if (isset($chapter_name)) { print $chapter_name; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>
                        <input
                            class="form-control"
                            name="chapter_description"
                            type="text"
                            value="<?php if (isset($chapter_description)) { print $chapter_description; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Раздел</td>
                    <td>
                        <select class="form-control" name="chapter_id">
                            <?php foreach ($forumchapter_array as $item) { ?>
                                <option value="<?= $item['forumchapter_id']; ?>"
                                    <?php if (isset($chapter_id) && $chapter_id == $item['forumchapter_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['forumchapter_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</form>