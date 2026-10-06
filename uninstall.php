<?php
defined('WP_UNINSTALL_PLUGIN')||exit;
if(!(bool)get_option('slwc_delete_on_uninstall',false))return;
global$wpdb;$t=$wpdb->prefix.'slwc_inquiries';$wpdb->query("DROP TABLE IF EXISTS {$t}");
delete_option('slwc_settings');delete_option('slwc_db_version');delete_option('slwc_callback_secret');
