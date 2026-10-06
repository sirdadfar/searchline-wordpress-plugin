<?php
declare(strict_types=1);
namespace SLWC\Rest;
use SLWC\Inquiries\Validators;
defined('ABSPATH')||exit;
final class Ajax{
 public function register():void{add_action('wp_ajax_slwc_test_connection',[$this,'test']);add_action('wp_ajax_nopriv_slwc_validate_field',[$this,'validate']);}
 public function test():void{check_ajax_referer('slwc_admin','nonce');if(!current_user_can('manage_woocommerce'))wp_send_json_error([],403);wp_send_json_success(['message'=>__('Configuration is ready for a live request.',SLWC_TEXT_DOMAIN)]);}
 public function validate():void{$n=sanitize_text_field(wp_unslash($_POST['nonce']??''));if(!wp_verify_nonce($n,'slwc_checkout'))wp_send_json_error([],403);$t=sanitize_key((string)($_POST['type']??''));$v=(string)($_POST['value']??'');$ok=true;switch($t){case'national_id':$ok=Validators::nationalId($v);break;case'mobile':$ok=Validators::mobile($v);break;case'card':$ok=Validators::card($v);break;case'sheba':$ok=Validators::sheba($v);break;case'postal':$ok=Validators::postal($v);break;case'imei':$ok=Validators::imei($v);break;}wp_send_json_success(['valid'=>$ok]);}
}