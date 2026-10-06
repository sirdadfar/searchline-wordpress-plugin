<?php
declare(strict_types=1);
namespace SLWC\Api;
use SLWC\Settings;
defined('ABSPATH')||exit;
final class Client{
 private ResponseParser$parser;
 public function __construct(){ $this->parser=new ResponseParser();}
 public function request(string$group,array$params,string$op=''):array{$c=(array)Settings::get('connection',[]);$map=['80'=>'url_80','70'=>'url_70','60'=>'url_60'];$url=isset($c[$map[$group]])?(string)$c[$map[$group]]:'';if($url==='')return['ok'=>false,'error_code'=>'missing_endpoint','message'=>'Endpoint is not configured','information'=>[],'result'=>[],'raw'=>''];$params=apply_filters('slwc_before_request',$params,$group,$op);$params=apply_filters('slwc_inquiry_params',$params,$group,$op);$params[$group==='80'?'token':'Token']=Settings::token();if($group==='80')$params['op']=$op;$res=wp_remote_post($url,['timeout'=>max(5,min(120,(int)($c['timeout']??20))),'sslverify'=>!isset($c['verify_ssl'])||!empty($c['verify_ssl']),'body'=>$params,'headers'=>['Accept'=>'application/json','User-Agent'=>'Searchline-for-WooCommerce/'.SLWC_VERSION]]);return apply_filters('slwc_after_response',$this->parser->parse($res),$group,$op);}
}