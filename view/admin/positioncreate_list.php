<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Позиции при создании команд</h1>
        <button type="button" class="btn btn-default">
            <a href="positioncreate_create.php">
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
                        <th>Позиция</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($position_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="position.php?num=<?= $item['position_id']; ?>">
                                    <?= $item['position_description']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="positioncreate_edit.php?num=<?= $item['position_id']; ?>">
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