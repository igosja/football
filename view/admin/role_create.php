<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование роли</h1>
        <button type="button" class="btn btn-default">
            <a href="role_list.php">
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
                    <td>Роль</td>
                    <td>
                        <input
                            class="form-control"
                            name="role_name"
                            type="text"
                            value="<?php if (isset($role_array[0]['role_name'])) { print $role_array[0]['role_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Сокращение</td>
                    <td>
                        <input
                            class="form-control"
                            name="role_short"
                            type="text"
                            value="<?php if (isset($role_array[0]['role_short'])) { print $role_array[0]['role_short']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>
                        <textarea
                            class="form-control"
                            name="role_description"
                            rows="10"
                        /><?php if (isset($role_array[0]['role_description'])) { print $role_array[0]['role_description']; } ?></textarea>
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