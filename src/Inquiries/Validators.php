<?php
declare(strict_types=1);
namespace SLWC\Inquiries;
use SLWC\Support\Sanitizer;
defined('ABSPATH')||exit;
final class Validators{
 public static function nationalId(string$v):bool{$v=Sanitizer::digits($v);if(!preg_match('/^\d{10}$/',$v)||preg_match('/^(\d)\1{9}$/',$v))return false;$s=0;for($i=0;$i<9;$i++)$s+=(int)$v[$i]*(10-$i);$r=$s%11;return$r<2?(int)$v[9]===$r:(int)$v[9]===11-$r;}
 public static function mobile(string$v):bool{return(bool)preg_match('/^09\d{9}$/',Sanitizer::digits($v));}
 public static function luhn(string$v):bool{$v=Sanitizer::digits($v);if($v===''||!ctype_digit($v))return false;$s=0;$a=false;for($i=strlen($v)-1;$i>=0;$i--){$n=(int)$v[$i];if($a){$n*=2;if($n>9)$n-=9;}$s+=$n;$a=!$a;}return$s%10===0;}
 public static function card(string$v):bool{$v=Sanitizer::digits($v);return(bool)preg_match('/^\d{16}$/',$v)&&self::luhn($v);}
 public static function postal(string$v):bool{return(bool)preg_match('/^\d{10}$/',Sanitizer::digits($v));}
 public static function imei(string$v):bool{$v=Sanitizer::digits($v);return(bool)preg_match('/^\d{15}$/',$v)&&self::luhn($v);}
}