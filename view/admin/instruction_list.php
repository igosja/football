<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Инструкции</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="instructionchapter_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
            <li>
                <a href="instruction_create.php" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
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