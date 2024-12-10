#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php artisan migrate
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint
elif [ "$role" = "queue" ]; then
    echo "Waiting for the database to be available..."
    until nc -z -v -w30 database 3306; do
        echo "Waiting for MySQL to be available..."
        sleep 5
    done

    echo "Database is up. Running the queue..."
    php artisan queue:work --verbose --tries=3 --timeout=1
fi
