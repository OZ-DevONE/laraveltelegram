#!/bin/bash

set -e

echo "Start Dep..."

git pull origin main

php8.2 artisan down

php8.2 composer.phar install --no-dev --optimaze-autoloader

php8.2 artisan migrate 

php8.2 artisan config:cache 

php8.2 artisan event:cache 

php8.2 artisan route:cache 

php8.2 artisan view:cache 

php8.2 artisan up

echo "Done!"