#!/bin/sh
set -e

if [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force --no-interaction
php artisan config:clear

until php artisan migrate --force --no-interaction; do
    echo "Database is not ready, retrying migration in 2 seconds..."
    sleep 2
done

php artisan db:seed --force --no-interaction
php artisan l5-swagger:generate --no-interaction || true

exec php artisan serve --host=0.0.0.0 --port=8000
