<?php
declare(strict_types=1);
namespace SLWC\Checkout;
use SLWC\Inquiries\Registry;
use SLWC\Settings;
use SLWC\Support\Sanitizer;
defined('ABSPATH')||exit;
final class Fields{
 public function definitions():array{$saved=(array)Settings::get('fields',[]);$out=[];foreach(Registry::all()as$d){if(($d['mode']??'off')==='off')continue;foreach((array)$d['inputs']as$k)$out[$k]=['label'=>$k,'type'=>in_array($k,['Mobile','Tel'],true)?'tel':'text','required'=>true];}foreach($saved as$k=>$v)$out[$k]=wp_parse_args((array)$v,$out[$k]??['label'=>$k,'type'=>'text','required'=>false]);return apply_filters('slwc_checkout_fields',$out);}
 public function sanitize(array$p):array{$o=[];foreach($this->definitions()as$k=>$v)if(isset($p[$k]))$o[$k]=Sanitizer::text((string)$p[$k]);return$o;}
}