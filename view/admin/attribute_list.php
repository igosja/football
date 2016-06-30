<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Характеристики</h1>
        <button type="button" class="btn btn-default">
            <a href="attributechapter_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="attribute_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Характеристика</th>
                        <th>Группа</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attribute_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="attribute_list.php?chapter_id=<?= $item['attribute_id']; ?>">
                                    <?= $item['attribute_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attribute.php?chapter_id=<?= $item['attributechapter_id']; ?>">
                                    <?= $item['attributechapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attribute_edit.php?num=<?= $item['attribute_id']; ?>">
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