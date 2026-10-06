<?php
declare(strict_types=1);
namespace SLWC\Checkout;
defined('ABSPATH')||exit;
final class Blocks{
 public function register():void{add_action('woocommerce_init',[$this,'fields']);}
 public function fields():void{if(!function_exists('woocommerce_register_additional_checkout_field'))return;foreach((new Fields())->definitions()as$k=>$v)woocommerce_register_additional_checkout_field(['id'=>'slwc/'.$k,'label'=>(string)$v['label'],'location'=>'address','type'=>'text','required'=>!empty($v['required'])]);}
}