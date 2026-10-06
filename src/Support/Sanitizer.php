<?php
declare(strict_types=1);
namespace SLWC\Support;
defined('ABSPATH')||exit;
final class Sanitizer{
 public static function digits(string$v):string{return strtr(trim($v),['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9','٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9']);}
 public static function text(string$v):string{return sanitize_text_field(wp_unslash($v));}
 public static function mask(string$v,int$n=2):string{$l=strlen($v);return$l<=2*$n?str_repeat('•',$l):substr($v,0,$n).str_repeat('•',$l-2*$n).substr($v,-$n);}
}