<?php
declare(strict_types=1);
namespace SLWC\Cron;
defined('ABSPATH')||exit;
final class Scheduler{
 public function register():void{add_action('slwc_process_inquiry',static function(int$id,string$q):void{$o=wc_get_order($id);if($o)(new\SLWC\Orders\InquiryService())->run($o,$q);},10,2);}
}