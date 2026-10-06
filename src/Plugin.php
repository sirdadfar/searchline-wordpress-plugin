<?php
declare(strict_types=1);
namespace SLWC;
defined('ABSPATH')||exit;
final class Plugin{
 public function boot():void{$this->compatibility();(new Admin\SettingsPage())->register();(new Admin\OrderMetaBox())->register();(new Admin\Assets())->register();(new Checkout\Classic())->register();(new Checkout\Blocks())->register();(new Rest\Callback())->register();(new Rest\Ajax())->register();(new Privacy\Tools())->register();(new Cron\Scheduler())->register();}
 private function compatibility():void{add_action('before_woocommerce_init',static function():void{if(class_exists('Automattic\\WooCommerce\\Utilities\\FeaturesUtil')){Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables',SLWC_FILE,true);Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks',SLWC_FILE,true);}});}
}