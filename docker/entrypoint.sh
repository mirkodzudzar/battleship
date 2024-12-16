#!/bin/bash
set -e  # Exit immediately if a command exits with a non-zero status

# Composer install
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

# Environment file
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Determine container role
role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    # Application server tasks
    php artisan migrate --force
    php artisan key:generate
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint
elif [ "$role" = "queue" ]; then
    # Queue worker tasks
    echo "Waiting for the database to be available..."
    # Use -z for zero-IO mode, -v for verbose, -w for timeout
    until nc -z -v -w30 database 3306; do
        echo "Waiting for MySQL to be available..."
        sleep 5
    done

    echo "Database is up. Running the queue..."
    php artisan queue:work --verbose --tries=3 --timeout=90
fi
