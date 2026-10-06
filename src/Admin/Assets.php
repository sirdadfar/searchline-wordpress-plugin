<?php
declare(strict_types=1);
namespace SLWC\Admin;
defined('ABSPATH')||exit;
final class Assets{public function register():void{add_action('admin_enqueue_scripts',static function($hook):void{if(strpos((string)$hook,'slwc')===false)return;wp_enqueue_style('slwc-admin',SLWC_URL.'assets/admin.css',[],SLWC_VERSION);wp_enqueue_script('slwc-admin',SLWC_URL.'assets/admin.js',['jquery'],SLWC_VERSION,true);});}}
