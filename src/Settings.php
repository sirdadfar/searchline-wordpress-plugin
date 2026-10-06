<?php
declare(strict_types=1);
namespace SLWC;
use SLWC\Support\Crypto;
defined('ABSPATH')||exit;
final class Settings{
 public static function defaults():array{return['connection'=>['token'=>'','url_80'=>'https://inquery.ir/:80','url_70'=>'https://inquery.ir/:70','url_60'=>'https://inquery.ir/:60','timeout'=>20,'verify_ssl'=>true,'demo'=>false],'general'=>['cache_ttl'=>3600,'max_runs'=>3],'privacy'=>['delete_on_uninstall'=>false,'retention_days'=>90],'style'=>['preset'=>'default','inherit'=>false,'font_size'=>'14px','radius'=>'6px','input_height'=>'42px'],'inquiries'=>[],'fields'=>[],'rules'=>[]];}
 public static function all():array{return wp_parse_args((array)get_option('slwc_settings',[]),self::defaults());}
 public static function get(string$key,$default=null){$s=self::all();return isset($s[$key])?$s[$key]:$default;}
 public static function token():string{if(defined('SLWC_TOKEN')&&SLWC_TOKEN)return(string)SLWC_TOKEN;$c=(array)self::get('connection',[]);return Crypto::decrypt(isset($c['token'])?(string)$c['token']:'');}
}