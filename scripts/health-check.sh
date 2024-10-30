#!/bin/bash

# Check application health
curl -f "${APP_URL}/api/health" || exit 1

# Check Redis connection
php artisan redis:ping || exit 1

# Check database connection
php artisan db:monitor || exit 1

# Check queue processing
php artisan queue:monitor || exit 1

# Check storage permissions
test -w storage/logs || exit 1
test -w storage/framework/views || exit 1
test -w storage/framework/cache || exit 1

# Check SSL certificate (if applicable)
if [[ "${APP_URL}" == https* ]]; then
    curl -f --head "${APP_URL}" || exit 1
fi

echo "Health check passed successfully"
exit 0