<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Настрои на игру</h1>
        <button type="button" class="btn btn-default">
            <a href="gamemood_create.php">
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
                        <th>Настрой</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gamemood_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="gamemood.php?num=<?= $item['gamemood_id']; ?>">
                                    <?= $item['gamemood_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="gamemood_edit.php?num=<?= $item['gamemood_id']; ?>">
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