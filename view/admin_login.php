<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Вход в административный раздел">
    <title>Вход в административный раздел</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Авторизация</h3>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($alert_message)) { ?>
                            <div class="alert alert-danger text-center">
                                <?php print $alert_message['text']; ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Логин" name="data[login]" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Пароль" name="data[password]" type="password">
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Войти" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>