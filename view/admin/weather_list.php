<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Погода</h1>
        <button type="button" class="btn btn-default">
            <a href="weather_create.php">
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
                    <th>Погода</th>
                    <th class="col-lg-1"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($weather_array as $item) { ?>
                    <tr>
                        <td><?= $item['weather_name']; ?></td>
                        <td>
                            <a href="weather_edit.php?num=<?= $item['weather_id']; ?>"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>