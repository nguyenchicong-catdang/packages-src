#!/bin/bash
# Lấy tên nhánh hiện tại
CURRENT_BRANCH=$(cd "$ROOT_BASH" && git rev-parse --abbrev-ref HEAD)
echo "Đang ở nhánh: $CURRENT_BRANCH. Tự động cấu hình Composer..."

# Đảm bảo đường dẫn file chính xác
SOURCE_FILE="$ROOT_BASH/setup/laravel-app/composer.json"
DEST_FILE="$RUN_LARAVEL/composer.json"

# Kiểm tra file nguồn có tồn tại không trước khi copy
if [ ! -f "$SOURCE_FILE" ]; then
    echo "Lỗi: Không tìm thấy file nguồn tại $SOURCE_FILE"
    exit 1
fi

cp "$SOURCE_FILE" "$DEST_FILE"

# SỬA TẠI ĐÂY: Dùng dấu # thay cho / để tránh lỗi "p/g"
# Lệnh này sẽ tìm chuỗi "dev-*" và thay bằng "dev-tên_nhánh"
sed -i "s#dev-\*#dev-$CURRENT_BRANCH#g" "$DEST_FILE"

# 4. Chạy Composer
(
    cd "$RUN_LARAVEL" || exit
    rm -f composer.lock
    composer install
)