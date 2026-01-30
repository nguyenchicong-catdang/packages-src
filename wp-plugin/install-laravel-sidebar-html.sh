#!bin/bash
# wp-plugin/install-laravel-sidebar-html.sh
echo "wp-plugin/install-laravel-sidebar-html.sh"
echo "ROOT_WP_PLUGIN:: $ROOT_WP_PLUGIN"
echo "ROOT_WP_APP_PLUGIN:: $ROOT_WP_APP_PLUGIN"
SOURCE_LINK="$ROOT_WP_PLUGIN/wp-plugin/laravel-sidebar-html"
echo "SOURCE_LINK:: $SOURCE_LINK"
TARGET_LINK="$ROOT_WP_APP_PLUGIN/laravel-sidebar-html"
echo "TARGET_LINK:: $TARGET_LINK"
# tạo link
(
    ln -s "$SOURCE_LINK" "$TARGET_LINK"
)
echo "Tao link: $SOURCE_LINK -> $TARGET_LINK"