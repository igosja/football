<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Пользователи</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-lg-6">Пользователь</th>
                        <th>Последний визит</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="user.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </td>
                            <td><?= f_igosja_ufu_last_visit($item['user_last_visit']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <nav class="text-center">
            <ul class="pagination">
                <?php for ($i=$start_pagination; $i<$end_pagination; $i++) { ?>
                    <li <?php if ($page == $i) { ?>class="active"<?php } ?>><a href="?page=<?=$i?>"><?=$i+1?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>