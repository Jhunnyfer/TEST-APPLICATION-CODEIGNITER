<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->model('Producto_model');
        $this->load->model('Usuario_model');
        $this->load->model('Pedido_model');
        $this->load->model('PedidoDetalle_model');
        $this->load->model('Pago_model');

    }

    public function index()
    {
        $data['products'] = $this->Producto_model->get_productos_activos();
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/inicio', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function ingreso()
    {
        $data = null;
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/ingreso', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function registro()
    {
        $data = null;
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/registro', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function preguntas()
    {
        $data = null;
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/preguntas', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function pedidos()
    {
        $data['pedidos'] = $this->Pedido_model->get_pedidos_user($this->session->userdata('id_usuario'));
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/pedidos', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function detalle_pedido($idDetalle)
    {
        $data['pedido']  = $this->Pedido_model->get_pedido($idDetalle);
        $data['detalle'] = $this->PedidoDetalle_model->get_detail($data['pedido'][0]['id_pedido']);
        $data['pagos']   = $this->Pago_model->get_pagos_pedido($idDetalle);
        $data['ultimo']  = $this->Pago_model->get_pago($idDetalle);
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/detalle_pedido', $data);
        $this->load->view('sitio/layout/footer');
    }


    public function cart()
    {
        $data['products'] = $this->Producto_model->get_productos_activos_cart();
        $this->load->view('sitio/layout/header');
        $this->load->view('sitio/cart', $data);
        $this->load->view('sitio/layout/footer');
    }

    public function login()
    {
        $email      = $this->input->post('email');
        $password   = sha1($this->input->post('password'));
        $check_user = $this->Usuario_model->iniciar_sesion($email, $password);
        if ($check_user['status'] == 1) {
            $data = array(
                'logueado'   => true,
                'id_usuario' => $check_user['user']->id,
                'perfil'     => $check_user['user']->perfil_id,
                'correo'     => $check_user['user']->email,
                'name'       => $check_user['user']->nombre,
                'usuario'    => $check_user['user']->usuario,
            );
            $this->session->set_userdata($data);
            redirect(base_url() . 'index.php');
        } else {
            redirect(base_url() . 'index.php/inicio/ingreso');
        }
    }

    public function register()
    {
        $nombre      = $this->input->post('nombre');

        $direccion   = $this->input->post('direccion');

        $telefono    = $this->input->post('telefono');

        $email       = $this->input->post('correo');

        $password    = sha1($this->input->post('password'));

        $data = array(

                'nombre'                              => $nombre,

                'password'                            => $password,

                'direccion'                           => $direccion,

                'email'                               => $email,

                'telefono'                            => $telefono,

                'perfil_id'                           => 1,

                'status'                              => 1,

            );

        $user = $this->Usuario_model->registro($data);

        $this->session->set_flashdata('msg', 'Registro Completado Correctamente!!'); 

        header('Location: /index.php/inicio/ingreso ');
    }

    public function cerrarsesion()
    {
        $this->session->sess_destroy();
        
        redirect(base_url() . 'index.php');
    }

    public function save_order()
    {

        $codigoPedido = md5(uniqid(rand(), true));

        $total = 0;

        foreach ($this->input->post('products') as $product) {

            $iProduct =  $this->Producto_model->findByPk($product);

             $total +=  $iProduct[0]['precio'];

        }

        $data         = array(

            'user_id'  => $this->session->userdata('id_usuario'),

            'fecha_pedido'  => date("Y-m-d H:i:s"),

            'total_pedido' =>  $total,

            'flete_pedido' =>  0,

            'referencia'   =>  $codigoPedido

        );

        $idPedido  = $this->Pedido_model->guardar_pedido($data);

        
        foreach ($this->input->post('products') as $product) {

            $iProduct =  $this->Producto_model->findByPk($product);

            $dataDetail = array(

                'pedido_id'   => $idPedido,

                'producto_id' => $product,

                'precio'      => $iProduct[0]['precio'],

                'cantidad'    => 1,

            );

            $this->PedidoDetalle_model->guardar_pedido_detalle($dataDetail);
        }

        header('Location: /index.php/inicio/detalle_pedido/'.$codigoPedido);
    }

}
