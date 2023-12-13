#!/bin/bash

set -e

echo "Start Dep..."

git pull origin main

php8.2 artisan down

php8.2 composer.phar install --no-dev --optimize-autoloader

php8.2 artisan migrate 

php8.2 artisan up

echo "Done!"