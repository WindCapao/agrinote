#!/bin/bash

# Wait a moment for everything to initialize
sleep 2

# Generate application key if not set
if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache config
echo "Caching configuration..."
php artisan config:cache

# Clear and cache routes
echo "Caching routes..."
php artisan route:cache

# Clear and cache views
echo "Caching views..."
php artisan view:cache

# Start the application
echo "Starting Laravel server on port ${PORT}..."
php artisan serve --host=0.0.0.0 --port=${PORT}