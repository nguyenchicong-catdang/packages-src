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
    composer dump-autoload
)
# link ảo
# ln -s ~/git/packages-app/laravel-app/vendor ~/git/packages-src/vendor
# 5. Tạo link ảo cho vendor (để VS Code hết báo đỏ)
echo "--- Đang tạo liên kết ảo cho vendor ---"
VENDOR_LINK="$ROOT_BASH/vendor"
TARGET_VENDOR="$RUN_LARAVEL/vendor"

if [ -L "$VENDOR_LINK" ]; then
    rm "$VENDOR_LINK" # Xóa link cũ nếu có để cập nhật mới
fi

if [ -d "$TARGET_VENDOR" ]; then
    ln -s "$TARGET_VENDOR" "$VENDOR_LINK"
    echo "Đã tạo link ảo: $VENDOR_LINK -> $TARGET_VENDOR"
else
    echo "Cảnh báo: Không tìm thấy thư mục vendor mục tiêu để tạo link."
fi