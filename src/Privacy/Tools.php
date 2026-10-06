<?php
declare(strict_types=1);
namespace SLWC\Privacy;
defined('ABSPATH')||exit;
final class Tools{
 public function register():void{add_filter('wp_privacy_personal_data_exporters',[$this,'exporter']);add_filter('wp_privacy_personal_data_erasers',[$this,'eraser']);}
 public function exporter(array$e):array{$e['searchline']=['exporter_friendly_name'=>'Searchline for WooCommerce','callback'=>[$this,'export']];return$e;}
 public function eraser(array$e):array{$e['searchline']=['eraser_friendly_name'=>'Searchline for WooCommerce','callback'=>[$this,'erase']];return$e;}
 public function export(string$email):array{return['data'=>[],'done'=>true];}
 public function erase(string$email):array{return['items_removed'=>0,'items_retained'=>0,'messages'=>[],'done'=>true];}
}