<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование расстановки</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="formation_list.php" class="btn btn-default">
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
                    <td>Формация</td>
                    <td>
                        <input
                            class="form-control"
                            name="formation_name"
                            type="text"
                            value="<?php if (isset($formation_array[0]['formation_name'])) { print $formation_array[0]['formation_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Игроки</td>
                    <td>
                        <table class="table table-striped">
                            <?php foreach ($position_array as $position) { $number = ''; ?>
                                <tr>
                                    <td>
                                        <input 
                                            name="position_id[]" 
                                            type="checkbox" 
                                            value="<?= $position['position_id']; ?>"
                                            <?php foreach ($formation_position as $formation) { ?>
                                                <?php if ($formation == $position['position_id']) { ?>
                                                    checked
                                                <?php } ?>
                                            <?php } ?>
                                        /> <?= $position['position_name']; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($formation_position as $formation) { ?>
                                            <?php if ($formation == $position['position_id']) { $number++; } ?>
                                        <?php } ?>
                                        <input
                                            class="form-control"
                                            name="position_number[]"
                                            type="text"
                                            value="<?= $number; ?>"
                                        />
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
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