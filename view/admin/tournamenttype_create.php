<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование типа турнира</h1>
        <button type="button" class="btn btn-default">
            <a href="tournamenttype_list.php">
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
                    <td>Название</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournamenttype_name"
                            type="text"
                            value="<?php if (isset($tournamenttype_array[0]['tournamenttype_name'])) { print $tournamenttype_array[0]['tournamenttype_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Посещаемость</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournamenttype_visitor"
                            type="text"
                            value="<?php if (isset($tournamenttype_array[0]['tournamenttype_visitor'])) { print $tournamenttype_array[0]['tournamenttype_visitor']; } ?>"
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