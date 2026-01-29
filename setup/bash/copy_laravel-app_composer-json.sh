#!/bin/bash
# setup/bash/copy_laravel-app_composer-json.sh
# ~/git/packages-src/setup/bash/copy_laravel-app_composer-json.sh

#echo "copy_laravel-app_composer-json: $ROOT_BASH"
#echo "copy_laravel-app_composer-json: $ROOT_LARAVEL"

SOURCE_FILE="$ROOT_BASH/setup/laravel-app/composer.json"
DEST_FILE="$ROOT_LARAVEL/laravel-app/composer.json"

# Copy
cp "$SOURCE_FILE" "$DEST_FILE"
#echo "$SOURCE_FILE && $DEST_FILE & $RUN_LARAVEL"

# cd laravel-app
(
    cd "$RUN_LARAVEL" || exit
    composer update vendor-path/package-src
    composer dump-autoload
)
# run composer
# composer dump-autoload
# /home/cong/git/packages-app/laravel-app/composer.json
# laravel-app/package.json
# Bây giờ bạn dùng biến SCRIPT_DIR để xây dựng đường dẫn
#SOURCE_FILE="$SCRIPT_DIR/file_goc.txt"
#DEST_FILE="$SCRIPT_DIR/file_copy.txt"

# Copy
#cp "$SOURCE_FILE" "$DEST_FILE"