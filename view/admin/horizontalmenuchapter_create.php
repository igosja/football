<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование раздела</h1>
        <button type="button" class="btn btn-default">
            <a href="horizontalmenuchapter_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Раздел</td>
                        <td>
                            <input
                                class="form-control"
                                name="horizontalmenuchapter_name"
                                type="text"
                                value="<?php if (isset($horizontalmenuchapter_array[0]['horizontalmenuchapter_name'])) { print $horizontalmenuchapter_array[0]['horizontalmenuchapter_name']; } ?>"
                            />
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