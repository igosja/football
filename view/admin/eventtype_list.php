<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Варианты событий</h1>
        <button type="button" class="btn btn-default">
            <a href="eventtype_create.php">
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
                    <?php foreach ($eventtype_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/eventtype/<?= $item['eventtype_id']; ?>.png" />
                                <?= $item['eventtype_name']; ?>
                            </td>
                            <td>
                                <a href="eventtype_edit.php?num=<?= $item['eventtype_id']; ?>">
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