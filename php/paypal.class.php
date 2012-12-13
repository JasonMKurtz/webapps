<?php
	require_once("api.class.php"); 

        $paypal['username']   = "";
        $paypal['password']   = "";
        $paypal['signature']  = "";
	$paypal['api_url']    = "https://api-3t.sandbox.paypal.com/nvp"; 
	$paypal['successURL'] = ""; 
	$paypal['cancelURL']  = ""; 

	class PayPal { 
		private $info = array(); // an array to store API username, password and signature
		private $data, $api, $token; 
		
		function __construct() { 
			global $paypal; 
			$this->info = $paypal; 
			$this->Init(); 
		}

		private function Init() {
			$this->AddData("USERNAME",  $this->info['username']); 
			$this->AddData("PWD",       $this->info['password']); 
			$this->AddData("SIGNATURE", $this->info['signature']); 
			$this->AddData("VERSION", "86"); 
		}			

		function AddData($key, $value) { 
			if ($this->data == "") { 
				$this->data = $key . "=" . $value;
			} else { 
				$this->data .= "&" . $key . "=" . $value; 
			} 
		}

		function PaymentInfo($amount, $action = "SALE", $currency = "USD") { 
			$this->AddData("PAYMENTREQUEST_0_AMT", $amount);
			$this->AddData("PAYMENTREQUEST_0_PAYMENTACTION", $action); 
			$this->AddData("PAYMENTREQUEST_0_CURRENCYCODE", $currency); 
			$this->AddData("cancelURL", $this->info['cancelURL']); 
			$this->AddData("returnURL", $this->info['successURL']); 
			$this->AddData("METHOD", "SetExpressCheckout"); 
			return $this; 
		}

		function DebugData() { 
			return $this->data; 
		}

		function Send() { 
			$this->api   = new API($this->info['api_url'], $this->data); 
			$this->reply = $this->api->Send();
			die(var_dump($this->reply)); 
			return $this->reply; 
		}

		function FormatReply($reply) { 
			$bits = explode("&", $reply); 
			foreach ($bits as $bit) { 
				$da = explode("=", $bit); 
				$ret[$da[0]] = $ret[$da[1]]; 
			}
			return $ret; 
		}

		function Debug() { 
			$da = explode("&", $this->data); 
			foreach ($da as $d) { 
				$data = explode("=", $d); 
				$da[$data[0]] = $data[1]; 
			}

			foreach ($da as $key => $value) 
				echo $key . " = " . $value . "\n<br>"; 			

			echo "\n<br>"; 
			foreach ($this->reply as $key => $value)
				echo $key . " = " . $value . "\n<br>"; 
		}
	}
?>