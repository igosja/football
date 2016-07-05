<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование инструкции</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="instruction_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<form method="POST">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Инструкция</td>
                    <td>
                        <input
                            class="form-control"
                            name="instruction_name"
                            type="text"
                            value="<?php if (isset($instruction_array[0]['instruction_name'])) { print $instruction_array[0]['instruction_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Группа</td>
                    <td>
                        <select class="form-control" name="chapter_id">
                            <?php foreach ($chapter_array as $item) { ?>
                                <option value="<?= $item['instructionchapter_id']; ?>"
                                    <?php if (isset($instruction_array[0]['instruction_instructionchapter_id']) && $instruction_array[0]['instruction_instructionchapter_id'] == $item['instructionchapter_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['instructionchapter_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</form>