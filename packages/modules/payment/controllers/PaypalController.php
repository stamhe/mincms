<?php namespace application\modules\payment\controllers;   

use application\core\Str;
use Omnipay\PayPal;
use Omnipay\Common\GatewayFactory;
use Omnipay\Common\CreditCard;
/**
 * ## Paypal
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class PaypalController extends \application\core\FrontController
{ 
 	public $return_url;
 	public $notify_url;
 	public $cancel_url;
 	public $type='paypal';
	function init(){
		parent::init();  
		$this->return_url = $this->notify_url = host().url('payment/'.$this->type.'/notify');
		$this->cancel_url = $this->notify_url = host().url('payment/'.$this->type.'/cancel');     
	}
 	public function actionIndex()
	{  
	 	$gateway = GatewayFactory::create('PayPal_Express'); 
	 	$gateway->setUsername('sunkangchina_api1.163.com');
		$gateway->setPassword('8VUCQ76URMNMCQYW');
		$gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31AgEmcgvozz1FaeWoYv8VZzYP8Yp-'); 
	 
		try {
			$response = $gateway->purchase(
				array(
					'amount' => '0.01', 
					'currency' => 'USD', 
					'cancelUrl' =>$this->cancel_url,
					'returnUrl' => $this->return_url
				))->send();  
			if ($response->isSuccessful()) {
			    // payment was successful: update database
			    pr($response);
			} elseif ($response->isRedirect()) {
			    // redirect to offsite payment gateway
			    $response->redirect();
			} else {
			    // payment failed: display message to customer
			    echo $response->getMessage();
			}
		} catch (\Exception $e) { 
		    exit('Sorry, there was an error processing your payment. Please try again later.');
		}
	}
	function actionNotify(){   
	 	

	}
	
 

 
}
