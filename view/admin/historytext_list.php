<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Варианты действий</h1>
        <button type="button" class="btn btn-default">
            <a href="historytext_create.php">
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
                        <th>Вариант</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historytext_array as $item) { ?>
                        <tr>
                            <td><?= $item['historytext_name']; ?></td>
                            <td>
                                <a href="historytext_edit.php?num=<?= $item['historytext_id']; ?>">
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