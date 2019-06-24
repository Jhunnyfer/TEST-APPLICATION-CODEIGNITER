<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testunit extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library("unit_test");
    } 

    public function index(){}

    public function login(){
    	$this->load->model('Usuario_model');
    	$user = 'jhumamc@gmail.com'; 
    	$pass = sha1('internet');
    	
    	$test = $this->Usuario_model->iniciar_sesion($user, $pass);
    	$expected_result = 1;
    	$test_name = "Ingreso de Usuario";
    	echo $this->unit->run($test, 'is_array', $test_name);

    }


    /*public function pago_basico(){

		$url = 'https://test.placetopay.com/redirection/';

		$reference = 'TEST_' . time();

		$nonce = null;
		if (function_exists('random_bytes')) {
		    $nonce = bin2hex(random_bytes(16));
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
		    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
		} else {
		    $nonce = mt_rand();
		}

		$nonceBase64 = base64_encode($nonce);

		$seed 	   =  date('c');
		$secretKey = "024h1IlD";
		$tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

		$request =array();

		$request['payment'] = array(
		    "reference" => $reference,
        	"description" => "Pago básico de prueba",
        	"amount" => array(
        		"currency" =>  "COP",
            	"total" => "100000"
        	) 
		);

		$request['expiration'] = date('c', strtotime('+4 minutes'));
    	$request['returnUrl'] = "https://dev.placetopay.com/redirection/sandbox/session/".$reference;
    	$request['ipAddress'] = "127.0.0.1";
    	$request['userAgent'] ="PlacetoPay Sandbox";
		
		
		$placetopay = new Dnetix\Redirection\PlacetoPay([
		    'login' 	=>  '6dd490faf9cb87a9862245da41170ff2',
		    'seed' => $seed ,
		    'nonce' => $nonce,
		    'tranKey' 	=> $tranKey,
		    'url' 		=> $url,
		]);
		try {
		    $response = $placetopay->request($request);
		    if ($response->isSuccessful()) {
		        echo $response->processUrl();
		    } else {
		         echo $response->status()->message();
		    }
		} catch (Exception $e) {
		    var_dump($e->getMessage());
		}
    }*/


    public function pago_basico()
	{
		$url = 'https://test.placetopay.com/redirection/';

		$reference = 'TEST_' . time();

		$nonce = null;
		if (function_exists('random_bytes')) {
			$nonce = bin2hex(random_bytes(16));
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
		    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
		} else {
		    $nonce = mt_rand();
		}

		$nonce = base64_encode($nonce);


		$seed 	   =  date('c');
		$secretKey = "024h1IlD";
		$tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

		$request['auth'] = array(
		    'login' => '6dd490faf9cb87a9862245da41170ff2',
		    'seed' => $seed ,
		    'nonce' => $nonce,
		    'tranKey' => $tranKey
		);

		$request['payment'] = array(
		    "reference" => $reference,
        	"description" => "Pago básico de prueba",
        	"amount" => array(
        		"currency" =>  "COP",
            	"total" => "100000"
        	) 
		);

		$request['expiration'] = date('c', strtotime('1 day'));
    	$request['returnUrl'] = "https://dev.placetopay.com/redirection/sandbox/session/".$reference;
    	$request['ipAddress'] = "127.0.0.1";
    	$request['userAgent'] ="PlacetoPay Sandbox";
		
		
		$placetopay = new Dnetix\Redirection\PlacetoPay([
		    'login' 	=>  '6dd490faf9cb87a9862245da41170ff2',
		    'tranKey' 	=> $secretKey,
		    'url' 		=> $url,
		]);

		try {
		    $response = $placetopay->request($request);
		    if ($response->isSuccessful()) {
		        echo $response->processUrl();
		    } else {
		        echo $response->status()->message();
		    }
		} catch (Exception $e) {
		    var_dump($e->getMessage());
		}

	}

	public function query_test(){

		$nonce = null;
		if (function_exists('random_bytes')) {
			$nonce = bin2hex(random_bytes(16));
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
		    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
		} else {
		    $nonce = mt_rand();
		}

		$nonce = base64_encode($nonce);

		$seed 	   =  date('c');
		$secretKey = "024h1IlD";
		$tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

		$placetopay = new Dnetix\Redirection\PlacetoPay([
		    'login' 	=>  '6dd490faf9cb87a9862245da41170ff2',
		    'tranKey' 	=> $secretKey,
		    'url' 		=> $this->config->item('endpoint'),
		]);
		$requestId =  '211641';

		try {
		    $response = $placetopay->query($requestId);
		    if ($response->isSuccessful()) {
		        // In order to use the functions please refer to the RedirectInformation class
		        if ($response->status()->isApproved()) {
		            // The payment has been approved
		            print_r($requestId . " PAYMENT APPROVED\n");
		            // This is additional information about it
		            print_r($response->toArray());
		        } else {
		            //print_r($requestId . ' ' . $response->status()->message() . "\n");

		            var_dump($response->status()->status());
		           
		        }
		        //print_r($response);
		    } else {
		        // There was some error with the connection so check the message
		        print_r($response->status()->message() . "\n");
		        print_r($response->status() . "\n");
		    }
		} catch (Exception $e) {
		    var_dump($e->getMessage());
		}
	}


}