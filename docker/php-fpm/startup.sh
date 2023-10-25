#!/bin/bash

composer install

cd public
rm storage
cd ..
php artisan storage:link

php artisan config:cache

php artisan optimize:clear
php artisan cache:clear

chmod o+w ./storage/ -R

cd ..

php-fpm
