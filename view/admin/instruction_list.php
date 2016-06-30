<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Инструкции</h1>
        <button type="button" class="btn btn-default">
            <a href="instructionchapter_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="instruction_create.php">
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
                        <th>Инструкция</th>
                        <th>Группа</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instruction_array as $item) { ?>
                        <tr>
                            <td><?= $item['instruction_name']; ?></td>
                            <td><?= $item['instructionchapter_name']; ?></td>
                            <td>
                                <a href="instruction_edit.php?num=<?= $item['instruction_id']; ?>">
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