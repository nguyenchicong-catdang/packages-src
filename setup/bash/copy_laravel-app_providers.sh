#!/bin/bash
# Lấy tên nhánh hiện tại
CURRENT_BRANCH=$(cd "$ROOT_BASH" && git rev-parse --abbrev-ref HEAD)
echo "Đang ở nhánh: $CURRENT_BRANCH. Tự động cấu hình Composer..."

# Đảm bảo đường dẫn file chính xác
SOURCE_FILE="$ROOT_BASH/setup/laravel-app/providers.php"
DEST_FILE="$ROOT_LARAVEL/laravel-app/bootstrap/providers.php"

# Kiểm tra file nguồn có tồn tại không trước khi copy
if [ ! -f "$SOURCE_FILE" ]; then
    echo "Lỗi: Không tìm thấy file nguồn tại $SOURCE_FILE"
    exit 1
fi

cp "$SOURCE_FILE" "$DEST_FILE"
