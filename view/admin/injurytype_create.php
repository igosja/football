<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование типа травмы</h1>
        <button type="button" class="btn btn-default">
            <a href="injurytype_list.php">
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
                    <td>Травма</td>
                    <td>
                        <input
                            class="form-control"
                            name="injurytype_name"
                            type="text"
                            value="<?php if (isset($injurytype_name)) { print $injurytype_name; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Длительность, дней</td>
                    <td>
                        <input
                            class="form-control"
                            name="injurytype_day"
                            type="text"
                            value="<?php if (isset($injurytype_day)) { print $injurytype_day; } ?>"
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