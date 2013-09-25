<?php namespace application\modules\payment\controllers;  
use application\core\Load;
/**
 * ## 支付宝 双功能
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class AlipayController extends \application\core\FrontController
{ 
 	public $return_url;
 	public $notify_url;
	function init(){
		parent::init();  
		$this->return_url = $this->notify_url = host().url('payment/'.$this->type.'/notify'); 
        $files = array(
        	__DIR.'/../libraries/alipay/alipay_core.function.php',
        	__DIR.'/../libraries/alipay/alipay_md5.function.php',
        	__DIR.'/../libraries/alipay/alipay_notify.class.php',
        	__DIR.'/../libraries/alipay/alipay_submit.class.php',
        );
        Load::file($files);
		$alipay_config['partner']		= $this->application_key; 
		//安全检验码，以数字和字母组成的32位字符
		$alipay_config['key']			= $this->application_secret;   
		$alipay_config['sign_type']    = strtoupper('MD5'); 
		//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['input_charset']= strtolower('utf-8'); 
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$alipay_config['cacert']    = base_path().'modules/oauth/libraries/alipay/cacert.pem'; 
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipay_config['transport']    = 'http'; 
		$this->alipay_config = $alipay_config;
	}
 	public function actionIndex()
	{
	 	//支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = $this->notify_url;
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = $this->return_url;
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户
        $seller_email = $_POST['WIDseller_email'];
        //必填

        //商户订单号
        $out_trade_no = $_POST['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = 'test_'.time();
        //必填

        //付款金额
        $price = 0.01;
        //必填

        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        //物流费用
        $logistics_fee = "0.00";
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = "SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述

        $body = $_POST['WIDbody'];
        //商品展示地址
        $show_url = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，如：http://www.xxx.com/myorder.html

        //收货人姓名
        $receive_name = $_POST['WIDreceive_name'];
        //如：张三

        //收货人地址
        $receive_address = $_POST['WIDreceive_address'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

        //收货人邮编
        $receive_zip = $_POST['WIDreceive_zip'];
        //如：123456

        //收货人电话号码
        $receive_phone = $_POST['WIDreceive_phone'];
        //如：0571-88158090

        //收货人手机号码
        $receive_mobile = $_POST['WIDreceive_mobile'];
        //如：13312341234


		/************************************************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "trade_create_by_buyer",
				"partner" => trim($this->alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"price"	=> $price,
				"quantity"	=> $quantity,
				"logistics_fee"	=> $logistics_fee,
				"logistics_type"	=> $logistics_type,
				"logistics_payment"	=> $logistics_payment,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"receive_name"	=> $receive_name,
				"receive_address"	=> $receive_address,
				"receive_zip"	=> $receive_zip,
				"receive_phone"	=> $receive_phone,
				"receive_mobile"	=> $receive_mobile,
				"_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new \AlipaySubmit($this->alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
 		exit;
	}
	function actionNotify(){   
	 	

	}
	
 

 
}
