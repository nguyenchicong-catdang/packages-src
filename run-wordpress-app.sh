#!/bin/bash
# run-adminer.sh
# 1. Đổi tên biến tránh trùng hệ thống, dùng $HOME thay cho ~
WP_APP_PATH="$HOME/git/packages-app/wp-app"
(
    cd "$WP_APP_PATH" || exit
    wp server
    echo "WordPress đang chạy tại http://127.0.0.1:8080"
)