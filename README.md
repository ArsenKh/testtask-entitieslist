Test task
========
Тестовое задание

Install
========

### Add github repository

```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/MiG-21/testtask-entitieslist.git"
        }
    ]
```
and then

```
php composer.phar require --prefer-dist "testtask/entitieslist" "*"
```

Migrate
========

``` sh
php yii migrate/up --migrationPath=@testtask/entitieslist/migrations
```

or

``` sh
php yii migrate/up --migrationPath=vendor/testtask/entitieslist/migrations
```