<?php
/**
 * Plugin Name: Searchline for WooCommerce
 * Plugin URI: https://github.com/sirdadfar/searchline-wordpress-plugin
 * Description: Production-ready Searchline identity and data inquiries for WooCommerce.
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * WC requires at least: 8.0
 * Requires Plugins: woocommerce
 * Text Domain: searchline-for-woocommerce
 * Domain Path: /languages
 * License: GPLv2 or later
 */
declare(strict_types=1);

defined('ABSPATH') || exit;

define('SLWC_VERSION', '1.0.0');
define('SLWC_FILE', __FILE__);
define('SLWC_PATH', plugin_dir_path(__FILE__));
define('SLWC_URL', plugin_dir_url(__FILE__));
define('SLWC_TEXT_DOMAIN', 'searchline-for-woocommerce');

if (file_exists(SLWC_PATH . 'vendor/autoload.php')) {
    require_once SLWC_PATH . 'vendor/autoload.php';
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'SLWC\\';
        if (strpos($class, $prefix) !== 0) return;
        $file = SLWC_PATH . 'src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (is_readable($file)) require_once $file;
    });
}

register_activation_hook(__FILE__, ['SLWC\\Activator', 'activate']);

add_action('plugins_loaded', static function (): void {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', static function (): void {
            if (!current_user_can('activate_plugins')) return;
            echo '<div class="notice notice-error"><p>' . esc_html__('Searchline for WooCommerce requires WooCommerce to be installed and active.', SLWC_TEXT_DOMAIN) . '</p></div>';
        });
        return;
    }
    (new SLWC\\Plugin())->boot();
});