<?php
header("Content-type: text/html; charset=utf-8");
include dirname(__FILE__).'/lib/function.php';
global $_my_payment;
/*
* 以下参数必须，更多参数请查看手册 第二个参数是URL，在上线时请加个正式环境的URL，默认为测试URL
*/
$arr = payment_tonglian(array(
	'merchantId'=>'100020091218001',
	'key'=>'1234567890',//商户MD5值，在后台设置的
	'pickupUrl'=>'http://mincms.com/cutephp/tonglian/back.php',//以这个URL为第一个返回。
//	'receiveUrl'=>'http://mincms.com/payment/admin/do.html',//如不存在pickupUrl 则返回到该URL
	'orderAmount'=>50,//单位元 
	'productName'=>'IPhone',//商品名
	'productNum'=>1,//商品数量 
	'payerName'=>'nuno',//商品数量 
));  
$_my_payment = $arr;
echo $arr['form'];
?>