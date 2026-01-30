#!/bin/bash
echo "Bắt đầu wp-plugin/setup-wp-plugin.sh"

SCRIPT_DIR=$(
    dirname -- $BASH_SOURCE
)
# wp-plugin/laravel-sidebar-html
export ROOT_WP_PLUGIN=$(cd -- "$SCRIPT_DIR/.." && pwd)
# $HOME/git/packages-app/wp-app/wp-content/plugins
export ROOT_WP_APP_PLUGIN=$(cd -- "$HOME/git/packages-app/wp-app/wp-content/plugins" && pwd)
# run
bash "$ROOT_WP_PLUGIN/wp-plugin/install-laravel-sidebar-html.sh"
echo "SCRIPT_DIR: $SCRIPT_DIR"
echo "ROOT_WP_PLUGIN: $ROOT_WP_PLUGIN"
echo "ROOT_WP_APP_PLUGIN: $ROOT_WP_APP_PLUGIN"