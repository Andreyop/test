#Form

Установка
------------
Клонируйте репозиторий

```
git clone https://github.com/Andreyop/form.git
```

Выполните команду

```
composer install
```

и

```
php init  //вибрать Dev
```

В "common/config/main-local"

> Настраиваем подключение к БД
> 
>
> ```
>    'db' => [
>            'class' => 'yii\db\Connection',
>            'dsn' => 'mysql:host=localhost;dbname=test',
>            'username' => 'root',
>            'password' => '',
>            'charset' => 'utf8',
> ```

Выполните команду

```
php yii migrate
```
Затем в  "console/config/main" раскомментируйте:


```php
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'common\fixtures',
                'yii\queue\db\migrations',
            ],
        ],
```

и снова выполните команду

```
php yii migrate
```
----------------
Нужно зарегистрироваться и подтвердить совой e-mail в папке frontend/runtime/mail убрав из ссылки 3D, и все переносы.

Приложение доступно по ссылке "/admin"...