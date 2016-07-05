<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование настроя</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="gamemood_list.php" class="btn btn-default">
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
                    <td>Настрой</td>
                    <td>
                        <input
                            class="form-control"
                            name="gamemood_name"
                            type="text"
                            value="<?php if (isset($gamemood_array[0]['gamemood_name'])) { print $gamemood_array[0]['gamemood_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>
                        <textarea
                            class="form-control"
                            name="gamemood_description"
                            rows="10"
                        /><?php if (isset($gamemood_array[0]['gamemood_description'])) { print $gamemood_array[0]['gamemood_description']; } ?></textarea>
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