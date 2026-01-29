#!/bin/bash
# run-adminer.sh
# 1. Đổi tên biến tránh trùng hệ thống, dùng $HOME thay cho ~
ADMINER_PATH="$HOME/git/packages-app/adminer"
(
    cd "$ADMINER_PATH" || exit
    php -S 127.0.0.1:9000
    echo "Adminer đang chạy tại http://127.0.0.1:9000"
)