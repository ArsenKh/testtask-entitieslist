Test task
========
Create Yii2 module/application ...

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

Configure
========
Add to web & console configs

``` php
$config['bootstrap'][] = 'entitieslist';
$config['modules']['entitieslist'] = [
    'class' => 'testtask\entitieslist\Module',
];
```

Usage
========
For generate random data

``` sh
php yii entitieslist/generate
```

For clean generated data

``` sh
php yii entitieslist/generate/delete
```