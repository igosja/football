<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Первая строка меню</h1>
        <button type="button" class="btn btn-default">
            <a href="horizontalmenu_create.php">
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
                    <th>Меню</th>
                    <th>Раздел</th>
                    <th class="col-lg-1"></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu_array as $item) { ?>
                        <tr>
                            <td><?= $item['horizontalmenu_name']; ?></td>
                            <td><?= $item['horizontalmenuchapter_name']; ?></td>
                            <td>
                                <a href="horizontalmenu_edit.php?num=<?= $item['horizontalmenu_id']; ?>">
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