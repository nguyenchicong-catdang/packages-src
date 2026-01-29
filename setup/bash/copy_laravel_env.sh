#!/bin/bash
# setup/bash/copy_laravel_env.sh
SOURCE_FILE="$ROOT_BASH/setup/laravel-app/.env"
DEST_FILE="$ROOT_LARAVEL/laravel-app/.env"

# Copy
cp "$SOURCE_FILE" "$DEST_FILE"
# cd laravel-app
(
    cd "$RUN_LARAVEL" || exit
    php artisan migrate
    php artisan optimize:clear
)