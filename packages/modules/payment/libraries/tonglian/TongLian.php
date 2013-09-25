<?php

class TongLian_Class{
	function form($opt,$action="http://ceshi.allinpay.com/gateway/index.do"){ 
		$options['inputCharset'] = 1;//字符集 1代表UTF-8
		$options['pickupUrl'] = $opt['pickupUrl']; //取货地址
		$options['receiveUrl'] = $opt['receiveUrl']; //支付结果URL
		$options['version'] = 'v1.0';//固定值
		$options['language'] = 1;//固定值
		$options['signType'] = 1;//固定值  	
		$options['merchantId'] = $opt['merchantId']; 
		$options['payerName'] = $opt['payerName']; 
		$options['payerEmail'] = $opt['payerEmail']; 
		$options['payerTelephone'] = $opt['payerTelephone']; 
		$options['payerIDCard'] = $opt['payerIDCard']; 
		$options['pid'] = $opt['pid']; 
		$options['orderNo'] = 'NO_'.date('YmdHis',time());//商户订单号
		$options['orderAmount'] = $opt['orderAmount']*100; 
		$options['orderCurrency'] =  $opt['orderCurrency']?$opt['orderCurrency']:0; 
		$options['orderDatetime'] = date('YmdHis',time());//提交订单时间 
		$options['orderExpireDatetime'] = $opt['orderExpireDatetime']; 
		$options['productName'] = $opt['productName']; 
		$options['productPrice'] = $opt['productPrice']; 
		$options['productNum'] = $opt['productNum']; 
		$options['productId'] = $opt['productId']; 
		$options['productDescription'] = $opt['productDescription']; 
		$options['ext1'] = $opt['ext1']; 
		$options['ext2'] = $opt['ext2']; 
		$options['payType'] = 0;//支付方式 
		$options['issuerId'] = $opt['issuerId']; 
		$options['pan'] = $opt['pan']; 
		$options['key'] = $opt['key']; //商户MD5值，在后台设置的   
		foreach($options as $k=>$v){
			if(isset($v))
				$out .= $k."=".$v."&";
		} 
		$out = substr($out,0,-1); 
		//签名，设为signMsg字段值。
		$signMsg = strtoupper(md5($out));
		$form = '<form name="form2" action="'.$action.'" method="post">';
		foreach($options as $k=>$v){
			if($k!='key')
				$form .= '<input type="hidden" name="'.$k.'"  value="'.$v.'" />'; 
		}
		$form .= '<input type="hidden" name="signMsg"  value="'.$signMsg.'" />'; 

		$form .= '<a href="/order/" class="btn buy2">全部订单&gt;&gt;</a><input type="submit" class="btn input_btn" value="去付款"/>'; 
		$form .= '</form>';
		return array('options'=>$options,'sign'=>$signMsg,'form'=>$form);		

	}

	function action($signMsg){ 
		$path =  file_get_contents(dirname(__FILE__).'/tonglian/publickey.xml'); 
		$obj = xml2array::run($path); 
		$publickey = $obj['publickeys']['publickey']['exponent'];
		$modulus = $obj['publickeys']['publickey']['modulus']; 	  
		$keylength = 1024;

		$merchantId=$_POST["merchantId"];
		$version=$_POST['version'];
		$language=$_POST['language'];
		$signType=$_POST['signType'];
		$payType=$_POST['payType'];
		$issuerId=$_POST['issuerId'];
		$paymentOrderId=$_POST['paymentOrderId'];
		$orderNo=$_POST['orderNo'];
		$orderDatetime=$_POST['orderDatetime'];
		$orderAmount=$_POST['orderAmount'];
		$payDatetime=$_POST['payDatetime'];
		$payAmount=$_POST['payAmount'];
		$ext1=$_POST['ext1'];
		$ext2=$_POST['ext2'];
		$payResult=$_POST['payResult'];
		$errorCode=$_POST['errorCode'];
		$returnDatetime=$_POST['returnDatetime'];
		$signMsg=$_POST["signMsg"]; 
		$bufSignSrc="";
		if($merchantId != "")
		$bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";		
		if($version != "")
		$bufSignSrc=$bufSignSrc."version=".$version."&";		
		if($language != "")
		$bufSignSrc=$bufSignSrc."language=".$language."&";		
		if($signType != "")
		$bufSignSrc=$bufSignSrc."signType=".$signType."&";		
		if($payType != "")
		$bufSignSrc=$bufSignSrc."payType=".$payType."&";
		if($issuerId != "")
		$bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
		if($paymentOrderId != "")
		$bufSignSrc=$bufSignSrc."paymentOrderId=".$paymentOrderId."&";
		if($orderNo != "")
		$bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
		if($orderDatetime != "")
		$bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
		if($orderAmount != "")
		$bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
		if($payDatetime != "")
		$bufSignSrc=$bufSignSrc."payDatetime=".$payDatetime."&";
		if($payAmount != "")
		$bufSignSrc=$bufSignSrc."payAmount=".$payAmount."&";
		if($ext1 != "")
		$bufSignSrc=$bufSignSrc."ext1=".$ext1."&";
		if($ext2 != "")
		$bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
		if($payResult != "")
		$bufSignSrc=$bufSignSrc."payResult=".$payResult."&";
		if($errorCode != "")
		$bufSignSrc=$bufSignSrc."errorCode=".$errorCode."&";
		if($returnDatetime != "")
		$bufSignSrc=$bufSignSrc."returnDatetime=".$returnDatetime; 

		//验签结果
		$verify_result = rsa_verify($bufSignSrc,$signMsg, $publickey, $modulus, $keylength,"sha1");
		if($verify_result){
		$value = true;
		}
		else{
		$value = false;
		}
		return $value;
	}


}