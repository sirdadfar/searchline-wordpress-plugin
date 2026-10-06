<?php
declare(strict_types=1);
namespace SLWC\Api;
defined('ABSPATH')||exit;
final class ResponseParser{
 public function parse($response):array{if(is_wp_error($response))return['ok'=>false,'error_code'=>'network_error','message'=>$response->get_error_message(),'information'=>[],'result'=>[],'raw'=>''];$raw=is_string($response)?$response:(string)wp_remote_retrieve_body($response);$j=json_decode($raw,true);if(!is_array($j))return['ok'=>false,'error_code'=>'invalid_response','message'=>'Invalid JSON response','information'=>[],'result'=>[],'raw'=>$raw];$n=$this->normalize($j);return['ok'=>true,'error_code'=>'','message'=>'','information'=>$this->find($n,'information')?:[],'result'=>$this->find($n,'result')?:$n,'raw'=>$raw];}
 private function normalize(array$v):array{$o=[];foreach($v as$k=>$x){$key=strtolower(preg_replace('/[^a-z0-9_]/','',(string)$k));$o[$key]=is_array($x)?$this->normalize($x):$x;}return$o;}
 private function find(array$d,string$k){foreach($d as$key=>$v)if(strtolower((string)$key)===strtolower($k))return$v;return null;}
}