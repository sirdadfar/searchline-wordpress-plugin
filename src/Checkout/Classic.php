<?php
declare(strict_types=1);
namespace SLWC\Checkout;
use SLWC\Support\Sanitizer;
defined('ABSPATH')||exit;
final class Classic{
 private Fields$fields;
 public function register():void{$this->fields=new Fields();add_filter('woocommerce_checkout_fields',[$this,'fields']);add_action('woocommerce_after_checkout_validation',[$this,'validate'],10,2);add_action('woocommerce_checkout_create_order',[$this,'save'],10,2);add_action('wp_enqueue_scripts',[$this,'assets']);}
 public function fields(array$f):array{foreach($this->fields->definitions()as$k=>$v)$f['billing']['slwc_'.$k]=['type'=>$v['type'],'label'=>$v['label'],'required'=>!empty($v['required']),'priority'=>900];return$f;}
 public function validate(array$d,\WP_Error$e):void{foreach($this->fields->definitions()as$k=>$v){$x=isset($d['slwc_'.$k])?trim((string)$d['slwc_'.$k]):'';if(!empty($v['required'])&&$x==='')$e->add('slwc_'.$k,sprintf(__('Please enter %s.',SLWC_TEXT_DOMAIN),$v['label']));}}
 public function save(\WC_Order$o,array$d):void{foreach($this->fields->definitions()as$k=>$v)if(isset($d['slwc_'.$k])&&$d['slwc_'.$k]!=='')$o->update_meta_data('_slwc_field_'.$k,Sanitizer::text((string)$d['slwc_'.$k]));}
 public function assets():void{if(function_exists('is_checkout')&&!is_checkout())return;wp_enqueue_style('slwc-checkout',SLWC_URL.'assets/checkout.css',[],SLWC_VERSION);wp_enqueue_style('slwc-rtl',SLWC_URL.'assets/rtl.css',['slwc-checkout'],SLWC_VERSION);}
}