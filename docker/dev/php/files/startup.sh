#!/bin/bash
set -e

echo "Starting PHP built-in server on port 9001..."
cd /var/www/html
php -S 0.0.0.0:9001 -t public