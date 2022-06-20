SHELL = /bin/bash

composer-install:
	composer install

composer-up:
	composer update

migrate:
	 ./yii migrate

clear-sample-listen:
	 ./yii  tool/clearSample

init:
	composer install && ./yii migrate &&  ./yii rbac/init
