<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование настроя</h1>
        <button type="button" class="btn btn-default">
            <a href="gamestyle_list.php">
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
                    <td>Настрой</td>
                    <td>
                        <input
                            class="form-control"
                            name="gamestyle_name"
                            type="text"
                            value="<?php if (isset($gamestyle_array[0]['gamestyle_name'])) { print $gamestyle_array[0]['gamestyle_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>
                        <textarea
                            class="form-control"
                            name="gamestyle_description"
                            rows="10"
                        ><?php if (isset($gamestyle_array[0]['gamestyle_description'])) { print $gamestyle_array[0]['gamestyle_description']; } ?></textarea>
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