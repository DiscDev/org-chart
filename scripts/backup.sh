#!/bin/bash

# Set timestamp
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backups"

# Database backup
php artisan db:backup

# Files backup
tar -czf "${BACKUP_DIR}/files_${TIMESTAMP}.tar.gz" \
    ./storage/app \
    ./storage/framework \
    ./public/uploads

# Cleanup old backups (keep last 7 days)
find "${BACKUP_DIR}" -type f -mtime +7 -delete

echo "Backup completed successfully"