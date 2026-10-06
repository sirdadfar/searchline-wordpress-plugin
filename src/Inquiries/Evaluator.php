<?php
declare(strict_types=1);
namespace SLWC\Inquiries;
defined('ABSPATH')||exit;
final class Evaluator{
 public function evaluate(string$id,array$r,array$c=[]):array{$v=$this->find($r,'validation');$p=true;$detail='';if($id==='exitban'||$id==='blacklist')$p=!filter_var($this->find($r,'status'),FILTER_VALIDATE_BOOLEAN);elseif($id==='nationalcode'||$id==='shahkar'){$p=filter_var($v,FILTER_VALIDATE_BOOLEAN);$detail=(string)$this->find($r,'detail');}elseif($v!==null)$p=filter_var($v,FILTER_VALIDATE_BOOLEAN);foreach($c as$x)if(!$this->condition($r,(array)$x))$p=false;return['passed'=>$p,'detail'=>$detail];}
 private function find(array$d,string$n){foreach($d as$k=>$v)if(strtolower((string)$k)===strtolower($n))return$v;return null;}
 private function condition(array$d,array$c):bool{$v=$this->find($d,(string)($c['field']??''));$x=$c['value']??'';switch((string)($c['operator']??'equals')){case'not_equals':return$v!=$x;case'contains':return is_string($v)&&stripos($v,(string)$x)!==false;case'greater':return is_numeric($v)&&$v>$x;case'less':return is_numeric($v)&&$v<$x;case'in':return in_array($v,(array)$x,true);case'regex':return is_string($v)&&preg_match((string)$x,$v)===1;default:return$v==$x;}}
}