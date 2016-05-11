<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Континенты</h1>
        <button type="button" class="btn btn-default">
            <a href="continent_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Континент</th>
                        <th>Стран</th>
                        <th>Городов</th>
                        <th>Команд</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($continent_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/continent/<?= $item['continent_id']; ?>.png" />
                                <a href="continent.php?num=<?= $item['continent_id']; ?>">
                                    <?= $item['continent_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="country_list.php?continent_id=<?= $item['continent_id']; ?>">
                                    <?= $item['count_country']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="city_list.php?continent_id=<?= $item['continent_id']; ?>">
                                    <?= $item['count_city']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team_list.php?continent_id=<?= $item['continent_id']; ?>">
                                    <?= $item['count_team']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="continent_edit.php?num=<?= $item['continent_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>