<?php
header("Content-type: text/html; charset=utf-8");
include dirname(__FILE__).'/lib/function.php';
global $_my_payment;
if(true === payment_tonglian_return($_my_payment['sign'])){
	echo '支付成功啦！';
	$pay = fen2yuan($_POST['orderAmount']);
	echo '您支付了 '.$pay.' 元';
}else{
	echo '不好意思，这样也能支付失败';
} 

print_r('<pre>');
print_r($_POST);