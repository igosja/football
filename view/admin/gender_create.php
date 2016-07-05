<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование пола</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="gender_list.php" class="btn btn-default">
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
                    <td>Пол</td>
                    <td>
                        <input
                            class="form-control"
                            name="gender_name"
                            type="text"
                            value="<?php if (isset($gender_array[0]['gender_name'])) { print $gender_array[0]['gender_name']; } ?>"
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