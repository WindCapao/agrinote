#!/bin/bash

# Wait for environment variables to be set
sleep 5

# Check if MySQL variables are set
if [ -z "${MYSQLHOST}" ] || [ "${MYSQLHOST}" = "\${MYSQLHOST}" ]; then
    echo "WARNING: MySQL database not configured. Skipping migrations."
    NO_DB=true
fi

# Generate application key if not set
if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Only run migrations if database is configured
if [ -z "$NO_DB" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
else
    echo "Skipping database migrations (no database configured)"
fi

# Start the application
echo "Starting Laravel server on port ${PORT}..."
php artisan serve --host=0.0.0.0 --port=${PORT}