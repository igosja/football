<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Группы характеристик</h1>
        <button type="button" class="btn btn-default">
            <a href="attributechapter_create.php">
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
                        <th>Характеристик</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chapter_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="attributechapter.php?num=<?= $item['attributechapter_id']; ?>">
                                    <?= $item['attributechapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attribute_list.php?chapter_id=<?= $item['attributechapter_id']; ?>">
                                    <?= $item['count_attribute']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attributechapter_edit.php?num=<?= $item['attributechapter_id']; ?>">
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