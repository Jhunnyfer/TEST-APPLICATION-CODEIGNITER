<?php

if (!defined("BASEPATH")) {
    exit('No direct script access allowed');
}

class Pago_model extends CI_Model
{
    private $_table            = 'tbl_pago';

    private $_pk_field         = 'id';

    private $list_colums       = array('referencia', 'total', 'moneda', 'fecha', 'estado', 'requestId');

    private $sort_colums_order = array('referencia', 'total', 'moneda', 'fecha', 'estado', 'requestId');

    public function __construct()
    {

        parent::__construct();

        $this->load->database();

    }


    public function get_pago($referencia)
    {
        $this->db->select("*");

        $this->db->from($this->_table);

        $this->db->where('referencia', $referencia);

        $this->db->order_by('id', 'DESC'); 

        $this->db->limit(1);

        $query  = $this->db->get();

        $result = ($query->result_array());

        return $result;
    }


    public function get_pagos_pedido($pedido_referencia){

        $this->db->select($this->list_colums);

        $this->db->from($this->_table);
    
        $this->db->where("referencia", $pedido_referencia);
        
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

}
