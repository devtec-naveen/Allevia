<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;



class PaypalProComponent extends Component
{
	
	public $paypal_username = null;
	public $paypal_password = null;
	public $paypal_signature = null;

	private $paypal_endpoint = 'https://api-3t.paypal.com/nvp';
	private $paypal_endpoint_test = 'https://api-3t.sandbox.paypal.com/nvp';

	public $amount = null;
	public $ipAddress = '';
	public $creditCardType = '';
	public $creditCardNumber = '';
	public $creditCardExpires = '';
	public $creditCardCvv = '';
	
	public $customerFirstName = '';
	public $customerLastName = '';
	public $customerEmail = '';

	public $billingAddress1 = '';
	public $billingAddress2 = '';
	public $billingCity = '';
	public $billingState = '';
	public $billingCountryCode = '';
	public $billingZip = '';

	protected $_controller = null;
	
	
	public function __construct() {
		$this->ipAddress = $_SERVER['REMOTE_ADDR'];
	}
	
	// Change TTD to USD 
	function convertCurrency($amount, $from, $to){
		$url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
		$data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
		return round($converted);
		//return number_format(round($converted, 3),2);
	}
	
	
	
	public function doDirectPayment($data,$shop) {
		//return $parsed die; 
		//return $shop ;die;
		$testmode=true ;    
		//if( Configure::read('App.PaypalAccountMode') == Configure::read('Paypal.mode.live') ){   
		//   $testmode = false ;       
		//}
		if($testmode) {
			$this->paypal_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
			$this->paypal_username = 'Civetta_seller0096_api1.gmail.com';
			$this->paypal_password = '83P335563GJBPLH2';
			$this->paypal_signature = 'AynhQMYujlpMv2uje13eUceDVO7IAV1MnXvd5RXuMbaJi05beuM-TePw';
		}
		else
		{
			$this->paypal_endpoint = 'https://api-3t.paypal.com/nvp';
			$this->paypal_username = 'info_api1.yink.com';
			$this->paypal_password = '6JVCUP4ZSXJDK54PA1';
			$this->paypal_signature = 'AFcWxV21C7fd0vA3bYYYRCp1SSRl31ABnSk-jS9EhksjEJS10ivO1hz6Mv';
		}
		
		//App::import("Model", "Country");  
		//$model = new Country();  
		//$Data = $model->find('first',array('conditions'=>array('Country.country'=>$shop->country']),'fields'=>array('Country.ccode')));
		//	if (!empty($Data)) {
		//		$countrycode =  $Data['Country']['ccode'];
		//	} 
		//return $shop; die ; 
		//$this->initialize();
		$doDirectPaymentNvp = array(
			'METHOD' => 'DoDirectPayment',
			'VERSION' => '57.0',
			'PAYMENTACTION' => 'Sale',
			'IPADDRESS' => $this->ipAddress,
			'RETURNFMFDETAILS' => 1,

			'ACCT' => $data['creditcard_number'],
			'EXPDATE' => $data['creditcard_month'].$data['creditcard_year'],
			'CVV2' => $data['creditcard_code'],
			'CREDITCARDTYPE' => 'Visa',

			'FIRSTNAME' => $shop->billing_firstname,
			'EMAIL' => $shop->billing_email,

			'STREET' => $shop->billing_address,
			'STREET2' => '',
			'CITY' => 'jaipur',
			'STATE' => 'Rajasthan',
			'COUNTRYCODE' => 'IN',
			'ZIP' => $shop->billing_zip,
			'AMT' => 20, //$shop->order_total,
			'ITEMAMT' => 20,//$shop->order_subtotal,
			'CURRENCYCODE' => 'USD',

			'USER' => $this->paypal_username,
			'PWD' => $this->paypal_password,
			'SIGNATURE' => $this->paypal_signature,
			'SHIPTONAME' => $shop->billing_firstname,
			'SHIPTOSTREET' => $shop->billing_address,
			'SHIPTOCITY' => 'jaipur',
			'SHIPTOSTATE' => 'Rajasthan',
			'SHIPTOCOUNTRY' => 'IN',
			'SHIPTOZIP' => $shop->billing_zip,
			'SHIPTOPHONENUM' => $shop->billing_phone
		);
		
		//pr($doDirectPaymentNvp); die; 
		
		// pr($shop);
		$i = 0;
		//foreach ($shop['OrderProduct as $ccitem) {
			
			$doDirectPaymentNvp['L_NAME0'] = 'Prdoct1'; //$ccitem['product_name'];
			$doDirectPaymentNvp['L_NUMBER0'] = 123 ; //$ccitem['id'];
			$doDirectPaymentNvp['L_AMT0'] = 20;//$ccitem['product_price'];
			$doDirectPaymentNvp['L_QTY0'] = 1;
			//$i++;
		//}
		
		
		
		//if(isset($shop->shipcharge))
		//{
		//	$doDirectPaymentNvp['SHIPPINGAMT = $shop->shipcharge;
		//}
		//if(isset($shop->discount))
		//{    
		//	$discount = $shop->discount;
		//	$sub_total = $shop->order_subtotal;
		//	$discountAmt = $sub_total*($discount/100);
		//	$doDirectPaymentNvp['SHIPDISCAMT'] = '-'.round($discountAmt);
		//}
		//pr($doDirectPaymentNvp);die;
		
		
		
		
		
		
		//App::uses('HttpSocket', 'Network/Http');
		//$httpSocket = new HttpSocket();
		$http = new Client();
		$response = $http->post($this->paypal_endpoint, $doDirectPaymentNvp);
		
		//return $response;
		
		$body = $response->body();
	
		

		parse_str($body , $parsed);
			// pr($parsed);die;
			return $parsed;
			 	


		 	


	}
}
?>