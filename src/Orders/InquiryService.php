<?php
declare(strict_types=1);
namespace SLWC\Orders;
use SLWC\Api\Client;
use SLWC\Inquiries\Evaluator;
use SLWC\Inquiries\Registry;
use SLWC\Support\Sanitizer;
defined('ABSPATH')||exit;
final class InquiryService{
 public function run(\WC_Order$o,string$id,bool$force=false):array{$d=Registry::get($id);if(!$d)return['status'=>'error','message'=>'Unknown inquiry'];if(!apply_filters('slwc_should_run_inquiry',true,$o,$d))return['status'=>'skipped'];global$wpdb;$t=$wpdb->prefix.'slwc_inquiries';$h=$this->hash($o,$d);if(!$force){$old=$wpdb->get_row($wpdb->prepare("SELECT * FROM {$t} WHERE order_id=%d AND inquiry_type=%s AND request_hash=%s ORDER BY id DESC LIMIT 1",$o->get_id(),$id,$h),ARRAY_A);if($old&&in_array($old['status'],['passed','failed','pending'],true))return$old;}$p=[];foreach((array)$d['inputs']as$k){$v=$o->get_meta('_slwc_field_'.$k,true);if($v!=='')$p[$k]=Sanitizer::digits((string)$v);}$start=microtime(true);$r=(new Client())->request((string)$d['group'],$p,(string)($d['op']??''));$result=(array)($r['result']??[]);$ev=(new Evaluator())->evaluate($id,$result,(array)($d['conditions']??[]));$st=!empty($r['ok'])?($ev['passed']?'passed':'failed'):'error';$wpdb->insert($t,['order_id'=>$o->get_id(),'inquiry_type'=>$id,'request_hash'=>$h,'remote_id'=>(string)($result['id']??''),'status'=>$st,'error_code'=>(string)($r['error_code']??''),'amount'=>isset($r['information']['amount'])?(float)$r['information']['amount']:0,'result_json'=>wp_json_encode($result),'requested_at'=>current_time('mysql',true),'responded_at'=>current_time('mysql',true),'duration_ms'=>(int)((microtime(true)-$start)*1000),'attempts'=>1,'created_at'=>current_time('mysql',true)]);$o->update_meta_data('_slwc_'.$id.'_status',$st);$o->update_meta_data('_slwc_'.$id.'_result',$this->safe($result,(bool)$d['sensitive']));$o->save();do_action($st==='failed'?'slwc_inquiry_failed':'slwc_inquiry_completed',$o,$id,$result);return['status'=>$st,'result'=>$result,'evaluation'=>$ev];}
 private function hash(\WC_Order$o,array$d):string{$x=[];foreach((array)$d['inputs']as$k)$x[$k]=$o->get_meta('_slwc_field_'.$k,true);return hash('sha256',wp_json_encode($x));}
 private function safe(array$r,bool$s):array{if(!$s)return$r;foreach($r as$k=>$v)if(is_string($v)&&in_array(strtolower((string)$k),['idcode','nationalid','cardnumber','sheba','mobile','photo'],true))$r[$k]=Sanitizer::mask($v);return$r;}
}