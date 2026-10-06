<?php
declare(strict_types=1);
namespace SLWC\Support;
defined('ABSPATH')||exit;
final class Crypto{
 public static function encrypt(string$v):string{if($v==='')return'';$k=hash('sha256',wp_salt('auth'),true);$iv=random_bytes(16);$x=openssl_encrypt($v,'AES-256-CBC',$k,OPENSSL_RAW_DATA,$iv);return$x===false?'':base64_encode($iv.$x);}
 public static function decrypt(string$v):string{if($v==='')return'';$x=base64_decode($v,true);if($x===false||strlen($x)<17)return'';$k=hash('sha256',wp_salt('auth'),true);$p=openssl_decrypt(substr($x,16),'AES-256-CBC',$k,OPENSSL_RAW_DATA,substr($x,0,16));return is_string($p)?$p:'';}
}