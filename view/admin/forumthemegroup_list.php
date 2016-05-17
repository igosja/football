<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Группы тем</h1>
        <button type="button" class="btn btn-default">
            <a href="forumchapter_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="forumthemegroup_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Группа</th>
                        <th>Раздел</th>
                        <th>Страна</th>
                        <th>Тем</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chapter_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="forumthemegroup.php?num=<?= $item['forumthemegroup_id']; ?>">
                                    <?= $item['forumthemegroup_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="forumchapter.php?num=<?= $item['forumchapter_id']; ?>">
                                    <?= $item['forumchapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="country.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="forumtheme_list.php?chapter_id=<?= $item['forumthemegroup_id']; ?>">
                                    <?= $item['count_theme']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="forumthemegroup_edit.php?num=<?= $item['forumthemegroup_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>