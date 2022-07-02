# ASMixeR Server

- mysql
- nginx
- php8.1
- redis

## API endpoints

| Url                           | Method | Params                                            | Example                                                                          |
|-------------------------------|--------|---------------------------------------------------|----------------------------------------------------------------------------------|
| /lib/categories               | GET    | -                                                 | https://api.asmixer.ru/lib/categories                                            |
| /sample/get-all               | GET    | -                                                 | https://api.asmixer.ru/sample/get-all                                            |
| /lib/sample-count-by-category | GET    | categoryId **INT** (optional)                     | https://api.asmixer.ru/lib/sample-count-by-category?categoryId=2                 |
| /lib/add-sample               | POST   | categoryIds **STRING**; sampleFile **Audio File** | https://api.asmixer.ru/lib/add-sample?categoryIds=1,3,25                         |
| /lib/categories-updates       | GET    |                                                   | https://api.asmixer.ru/lib/categories-updates                                    |
| /lib/sample-updates           | GET    |                                                   | https://api.asmixer.ru/lib/sample-updates                                        |
| /feedback                     | POST   | text **String**                                   | https://api.asmixer.ru/feedback?text=good_job                                    |
| /sample/get-file              | GET    | uuid **String**                                   | https://api.asmixer.ru/sample/get-file?uuid=07f64ad5-bcee-4eb3-b9a5-d19985809f11 |
| /sample/get                   | GET    | categoryId **INT**                                | https://api.asmixer.ru/sample/get?categoryId=1                                   |

## Building

### Install composer-asset-plugin

~~~
composer global require "fxp/composer-asset-plugin:^1.2.0"
~~~

### Create database

`CREATE DATABASE asmixer CHARACTER SET utf8 COLLATE utf8_general_ci;`

### Run commands

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

## License

[![GNU GPLv3 Image](https://www.gnu.org/graphics/gplv3-127x51.png)](https://www.gnu.org/licenses/gpl-3.0.en.html)  

ASMixeR is Free Software: You can use, study, share, and improve it at will. Specifically you can redistribute and/or modify it under the terms of the [GNU General Public License](https://www.gnu.org/licenses/gpl.html) as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
