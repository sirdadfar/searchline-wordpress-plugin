<?php
declare(strict_types=1);
namespace SLWC\Orders;
defined('ABSPATH')||exit;
final class Statuses{public function register():void{add_action('init',static function():void{register_post_status('wc-slwc-verification',['label'=>_x('Pending verification','Order status',SLWC_TEXT_DOMAIN),'public'=>false,'show_in_admin_status_list'=>true,'show_in_admin_all_list'=>true]);});}}
