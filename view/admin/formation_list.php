<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Расстановки команд</h1>
        <button type="button" class="btn btn-default">
            <a href="formation_create.php">
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
                        <th>Расстановка</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formation_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="formation.php?num=<?= $item['formation_id']; ?>">
                                    <?= $item['formation_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="formation_edit.php?num=<?= $item['formation_id']; ?>">
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