#!/bin/bash
# setup/setup.sh
# ~/git/packages-src/setup/setup.sh

echo "Bắt đầu tiến trình tổng..."
# 1. Thư mục chứa file script (ví dụ: /home/user/project/setup)
SCRIPT_DIR=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &> /dev/null && pwd)
# root bash
export ROOT_BASH=$(cd -- "$SCRIPT_DIR/.." && pwd)
# /home/cong/git/packages-app/laravel-app/composer.json
# root laravel
export ROOT_LARAVEL=$(cd -- "$SCRIPT_DIR/../../packages-app" && pwd)
# run laravel-app
export RUN_LARAVEL=$(cd -- "$ROOT_LARAVEL/laravel-app" && pwd)
# run bash
bash "$ROOT_BASH/setup/bash/copy_laravel-app_composer-json.sh"
echo "ROOT_BASH: $ROOT_BASH"
echo "ROOT_LARAVEL: $ROOT_LARAVEL"
echo "RUN_LARAVEL: $RUN_LARAVEL"

echo "Tất cả hoàn tất!"
# tro lai dong lenh
cd $ROOT_BASH