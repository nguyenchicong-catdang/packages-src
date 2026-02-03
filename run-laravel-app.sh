#!/bin/bash
# run-adminer.sh
# 1. Đổi tên biến tránh trùng hệ thống, dùng $HOME thay cho ~
LARAVEL_APP_PATH="$HOME/git/packages-app/laravel-app"
(
    cd "$LARAVEL_APP_PATH" || exit
    killall php
    php artisan serve
    echo "Laravel App đang chạy tại http://127.0.0.1:8000"
)