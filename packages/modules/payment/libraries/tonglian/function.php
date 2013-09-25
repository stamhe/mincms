<?php
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));	
include dirname(__FILE__).'/tonglian/php_rsa.php';
include dirname(__FILE__).'/tonglian/php_sax.php';
include dirname(__FILE__).'/xml2array.php';
include dirname(__FILE__).'/TongLian_Class.php';

function payment_tonglian($opt,$action="http://ceshi.allinpay.com/gateway/index.do"){ 
 	 return TongLian_Class::form($opt,$action);	 
}
 
function payment_tonglian_return($signMsg){
 return TongLian_Class::action($signMsg);	
}
function fen2yuan($fen){
	return  number_format($fen/100,2);
}