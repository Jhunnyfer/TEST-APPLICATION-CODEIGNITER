<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pago extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Pedido_model');
        $this->load->model('Pago_model');
    }

    public function index()
    {

    }

    public function pago_basico()
    {
        $this->form_validation->set_rules("reference", "name", "required");

        if($this->form_validation->run() == false) {

            $message['is_redirect'] = false;
            $err                    = validation_errors();
            $data                   = $err;
            $count                  = count($this->form_validation->error_array());
            $message['error_count'] = $count;

        } else {

            $reference = $this->input->post('reference');

            $pedido = $this->Pedido_model->get_pedido($reference);

            $nonce = get_nonce();

            $seed      = date('c');
            $secretKey = $this->config->item('secretKey');
            $tranKey   = base64_encode(sha1($nonce . $seed . $secretKey, true));

            $request['auth'] = array(
                'login'   => '6dd490faf9cb87a9862245da41170ff2',
                'seed'    => $seed,
                'nonce'   => $nonce,
                'tranKey' => $tranKey,
            );

            $request['payment'] = array(
                "reference"   => $reference,
                "description" => "Pago básico de prueba",
                "amount"      => array(
                    "currency" => "COP",
                    "total"    => $pedido[0]["total_pedido"],
                ),
            );

            $request['expiration'] = date('c', strtotime('20 minutes'));
            $request['returnUrl']  = "http://127.0.0.1/index.php/pago/session/" . $reference;
            $request['ipAddress']  = "127.0.0.1";
            $request['userAgent']  = "PlacetoPay Sandbox";

            $placetopay = new Dnetix\Redirection\PlacetoPay([
                'login'   => $this->config->item('login'),
                'tranKey' => $this->config->item('secretKey'),
                'url'     => $this->config->item('endpoint'),
            ]);

            try {
                $response = $placetopay->request($request);
                if ($response->isSuccessful()) {
                	
                	$data_inser_array    = array(
		                'referencia'                        => $reference,
		                'total'								=> $pedido[0]["total_pedido"],
		                'moneda'							=> "COP",
		                'fecha'								=> date("Y-m-d H:i:s"),
		                'requestId'                         => $response->requestId,
		                'Url'								=> $response->processUrl(),
		            );
    				$insert= $this->db->insert('tbl_pago', $data_inser_array);

                    header('Location: ' . $response->processUrl());
                } else {
                    echo $response->status()->message();
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
        }

    }

    public function session($reference){

            $pago = $this->Pago_model->get_pago($reference);

            $requestId = $pago[0]["requestId"];

            $idPago =  $pago[0]["id"];

            $nonce = get_nonce();

            $seed      = date('c');
            $secretKey = $this->config->item('secretKey');
            $tranKey   = base64_encode(sha1($nonce . $seed . $secretKey, true));


            $placetopay = new Dnetix\Redirection\PlacetoPay([
                'login'   => $this->config->item('login'),
                'tranKey' => $this->config->item('secretKey'),
                'url'     => $this->config->item('endpoint'),
            ]);
    	

            try {
			    $response = $placetopay->query($requestId);
			    if ($response->isSuccessful()) {
			        // In order to use the functions please refer to the RedirectInformation class
			        if ($response->status()->isApproved()) {
			            // The payment has been approved
			            //print_r($requestId . " PAYMENT APPROVED\n");
			            // This is additional information about it
			            //print_r($response->toArray());
			        } else {
			            //print_r($requestId . ' ' . $response->status()->message() . "\n");

			            //var_dump($response->status()->status());
			           
			        }
			        
			        $data_inser_array    = array(
		               'estado' => $response->status()->status(),
		            );

		            $condition = array("id" => $idPago);
                	
                	$insert = $this->db->update('tbl_pago', $data_inser_array, $condition);

                	header('Location: /index.php/inicio/detalle_pedido/'.$reference);

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
