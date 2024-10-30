#!/bin/bash

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize the application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
php artisan migrate --force

# Restart queue workers
php artisan queue:restart

# Clear response cache
php artisan cache:clear-responses

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Warm up the cache
php artisan optimize
php artisan route:cache
php artisan config:cache
php artisan view:cache

echo "Post-deployment tasks completed successfully"