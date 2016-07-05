<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Группы инструкций</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="instructionchapter_create.php" class="btn btn-default">
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
                        <th>Группа</th>
                        <th>Инструкций</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chapter_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="instructionchapter.php?num=<?= $item['instructionchapter_id']; ?>">
                                    <?= $item['instructionchapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="instruction_list.php?chapter_id=<?= $item['instructionchapter_id']; ?>">
                                    <?= $item['count_instruction']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="instructionchapter_edit.php?num=<?= $item['instructionchapter_id']; ?>">
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