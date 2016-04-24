<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование правила</h1>
        <button type="button" class="btn btn-default">
            <a href="rule_list.php">
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
                            name="rule_name"
                            type="text"
                            value="<?php if (isset($rule_name)) { print $rule_name; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Текст</td>
                    <td>
                        <textarea name="rule_text" rows="10" cols="100">{if (isset($rule_text))}{$rule_text}{/if}</textarea>
                        <textarea
                            class="form-control"
                            name="rule_text"
                            rows="10"
                        ><?php if (isset($rule_text)) { print $rule_text; } ?></textarea>
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