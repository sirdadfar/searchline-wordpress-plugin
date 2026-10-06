<?php
declare(strict_types=1);
namespace SLWC\Admin;
use SLWC\Inquiries\Registry;
use SLWC\Orders\InquiryService;
defined('ABSPATH')||exit;
final class OrderMetaBox{
 public function register():void{add_action('add_meta_boxes',[$this,'add']);add_action('admin_post_slwc_run_inquiry',[$this,'run']);}
 public function add():void{add_meta_box('slwc-inquiries',__('Searchline inquiries',SLWC_TEXT_DOMAIN),[$this,'render'],'shop_order','normal','high');}
 public function render($post):void{$o=$post instanceof\WC_Order?$post:wc_get_order($post->ID);if(!$o)return;$s=(array)get_option('slwc_settings',[]);$m=isset($s['inquiries'])?(array)$s['inquiries']:[];foreach(Registry::all()as$id=>$d){if(isset($m[$id]['mode'])&&$m[$id]['mode']!=='off'){$st=$o->get_meta('_slwc_'.$id.'_status',true)?:'not_run';$u=wp_nonce_url(admin_url('admin-post.php?action=slwc_run_inquiry&order_id='.$o->get_id().'&inquiry='.$id),'slwc_run_'.$o->get_id());echo'<p><strong>'.esc_html($d['label']).'</strong> — '.esc_html($st).' <a class="button" href="'.esc_url($u).'">'.esc_html__('Run now',SLWC_TEXT_DOMAIN).'</a></p>';}}}
 public function run():void{if(!current_user_can('manage_woocommerce'))wp_die(esc_html__('Permission denied.',SLWC_TEXT_DOMAIN));$id=absint($_GET['order_id']??0);$q=sanitize_key(wp_unslash($_GET['inquiry']??''));check_admin_referer('slwc_run_'.$id);$o=wc_get_order($id);if($o&&$q)(new InquiryService())->run($o,$q,true);wp_safe_redirect(wp_get_referer()?:admin_url());exit;}
}