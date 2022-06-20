#### asmixer server
---------

###    

- mysql
- nginx
- php8.1
- redis

### API endpoints
---------

| Url                           | READY | Method | Params                                            | Example                                                                          |
|-------------------------------|-------|--------|---------------------------------------------------|----------------------------------------------------------------------------------|
| /lib/categories               | +     | GET    | -                                                 | http://asmixer-api.loc/lib/categories                                            |
| /sample/get-all               | +     | GET    | -                                                 | http://asmixer-api.loc/sample/get-all                                            |
| /lib/sample-count-by-category | +     | GET    | categoryId **INT** (optional)                     | http://asmixer-api.loc/lib/sample-count-by-category?categoryId=2                 |
| /lib/add-sample               | +     | POST   | categoryIds **STRING**; sampleFile **Audio File** | http://asmixer-api.loc/lib/add-sample?categoryIds=1,3,25                         |
| /lib/categories-updates       |       | GET    |                                                   | http://asmixer-api.loc/lib/categories-updates                                    |
| /lib/sample-updates           |       | GET    |                                                   | http://asmixer-api.loc/lib/sample-updates                                        |
| /feedback                     | +     | POST   | text **String**                                   | http://asmixer-api.loc/feedback?text=good_job                                    |
| /sample/get-file              | +     | GET    | uuid **String**                                   | http://asmixer-api.loc/sample/get-file?uuid=07f64ad5-bcee-4eb3-b9a5-d19985809f11 |
| /sample/get                   | +     | GET    | categoryId **INT**                                | http://asmixer-api.loc/sample/get?categoryId=1                                   |

### For Developer
---------

### Install composer-asset-plugin

~~~
composer global require "fxp/composer-asset-plugin:^1.2.0"
~~~

### Create database

`CREATE DATABASE asmixer CHARACTER SET utf8 COLLATE utf8_general_ci;`

### run commands

```sh
 composer install
 ./yii migrate
 ./yii rbac/init
```

or
```sh
 make init
```

## Nginx Config

``look folder deploy/``
