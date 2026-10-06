<?php
declare(strict_types=1);
namespace SLWC;
defined('ABSPATH')||exit;
final class Activator{
 public static function activate():void{
  if(version_compare(PHP_VERSION,'7.4','<')||version_compare(get_bloginfo('version'),'6.2','<'))wp_die(esc_html__('Searchline requires PHP 7.4+ and WordPress 6.2+.',SLWC_TEXT_DOMAIN));
  if(!class_exists('WooCommerce'))wp_die(esc_html__('WooCommerce must be active before activating Searchline.',SLWC_TEXT_DOMAIN));
  global$wpdb;require_once ABSPATH.'wp-admin/includes/upgrade.php';$t=$wpdb->prefix.'slwc_inquiries';$c=$wpdb->get_charset_collate();
  dbDelta("CREATE TABLE {$t} (id bigint(20) unsigned NOT NULL AUTO_INCREMENT,order_id bigint(20) unsigned NOT NULL DEFAULT 0,inquiry_type varchar(64) NOT NULL,request_hash char(64) NOT NULL,remote_id varchar(128) NOT NULL DEFAULT '',status varchar(20) NOT NULL DEFAULT 'queued',http_status smallint unsigned NOT NULL DEFAULT 0,error_code varchar(64) NOT NULL DEFAULT '',amount decimal(20,2) NOT NULL DEFAULT 0,requested_at datetime NULL,responded_at datetime NULL,duration_ms int unsigned NOT NULL DEFAULT 0,attempts smallint unsigned NOT NULL DEFAULT 0,result_json longtext NULL,created_at datetime NOT NULL,PRIMARY KEY(id),KEY order_status(order_id,status),KEY remote_id(remote_id),KEY request_hash(request_hash)) {$c};");
  update_option('slwc_db_version','1.0.0');if(!get_option('slwc_settings'))update_option('slwc_settings',Settings::defaults(),false);
 }
}