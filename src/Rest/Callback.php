<?php
declare(strict_types=1);
namespace SLWC\Rest;
defined('ABSPATH')||exit;
final class Callback{
 public function register():void{add_action('rest_api_init',[$this,'route']);}
 private function secret():string{$s=(string)get_option('slwc_callback_secret','');if($s===''){$s=wp_generate_password(40,false,false);update_option('slwc_callback_secret',$s,false);}return$s;}
 public function route():void{register_rest_route('searchline/v1','/callback/(?P<secret>[A-Za-z0-9_-]+)',['methods'=>'GET','permission_callback'=>function(\WP_REST_Request$r){return hash_equals($this->secret(),(string)$r['secret']);},'callback'=>[$this,'handle']]);}
 public function handle(\WP_REST_Request$r):\WP_REST_Response{$id=sanitize_text_field((string)$r->get_param('ID'));if($id==='')return new\WP_REST_Response(['ok'=>false],400);global$wpdb;$t=$wpdb->prefix.'slwc_inquiries';$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM {$t} WHERE remote_id=%s LIMIT 1",$id),ARRAY_A);if(!$row)return new\WP_REST_Response(['ok'=>true,'ignored'=>true]);if(in_array($row['status'],['passed','failed'],true))return new\WP_REST_Response(['ok'=>true,'duplicate'=>true]);$wpdb->update($t,['status'=>'passed','responded_at'=>current_time('mysql',true),'result_json'=>wp_json_encode($r->get_params())],['id'=>(int)$row['id']]);return new\WP_REST_Response(['ok'=>true]);}
}