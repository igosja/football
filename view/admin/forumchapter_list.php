<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Разделы форумов</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="forumchapter_create.php" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Раздел</th>
                        <th>Тем</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chapter_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="forumchapter.php?num=<?= $item['forumchapter_id']; ?>">
                                    <?= $item['forumchapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="forumthemegroup_list.php?chapter_id=<?= $item['forumchapter_id']; ?>">
                                    <?= $item['count_group']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="forumchapter_edit.php?num=<?= $item['forumchapter_id']; ?>">
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