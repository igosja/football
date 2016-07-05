<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование позиции</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="position_list.php" class="btn btn-default">
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
                    <td>Позиция</td>
                    <td>
                        <input
                            class="form-control"
                            name="position_name"
                            type="text"
                            value="<?php if (isset($position_array[0]['position_name'])) { print $position_array[0]['position_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>
                        <input
                            class="form-control"
                            name="position_description"
                            type="text"
                            value="<?php if (isset($position_array[0]['position_description'])) { print $position_array[0]['position_description']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Координата "x" по сетке 5x7</td>
                    <td>
                        <input
                            class="form-control"
                            name="position_coordinate_x"
                            type="text"
                            value="<?php if (isset($position_array[0]['position_coordinate_x'])) { print $position_array[0]['position_coordinate_x']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Координата "y" по сетке 5x7</td>
                    <td>
                        <input
                            class="form-control"
                            name="position_coordinate_y"
                            type="text"
                            value="<?php if (isset($position_array[0]['position_coordinate_y'])) { print $position_array[0]['position_coordinate_y']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <td>
                        <select name="position_available" class="form-control">
                            <option value="1">
                                Открытая
                            </option>
                            <option value="0"
                                <?php if (isset($position_array[0]['position_available']) && 0 == $position_array[0]['position_available']) { ?>selected<?php } ?>
                            >
                                Служебная
                            </option>
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