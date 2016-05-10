<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Трансферный статус</h1>
        <button type="button" class="btn btn-default">
            <a href="statustransfer_create.php">
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
                        <th>Название</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statustransfer_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="statustransfer.php?num=<?= $item['statustransfer_id']; ?>">
                                    <?= $item['statustransfer_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="statustransfer_edit.php?num=<?= $item['statustransfer_id']; ?>">
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