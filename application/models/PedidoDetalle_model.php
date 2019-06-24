<?php

if (!defined("BASEPATH")) {
    exit('No direct script access allowed');
}

class PedidoDetalle_model extends CI_Model
{

    private $_table            = 'tbl_pedido_detalle';

    private $_pk_field         = 'id_pedido_det';

    private $list_colums       = array('id_pedido_det', 'pedido_id', 'producto_id', 'cantidad', 'precio');

    private $sort_colums_order = array('id_pedido_det', 'pedido_id', 'producto_id', 'cantidad', 'precio');

    public function __construct()
    {

        parent::__construct();

        $this->load->database();

    }

    public function findByPk($id)
    {

        $this->db->select("*");
        $this->db->from($this->_table);

        $this->db->where($this->_pk_field, $id);
        $this->db->limit(1);
        $query  = $this->db->get();
        $result = array_shift($query->result_array());

        return $result;

    }

    public function get_data($sort_num = 0, $sortby = "DESC", $limit, $start, $search = "")
    {

        $sort_field = $this->sort_colums_order[$sort_num];

        $this->db->select($this->sort_colums_order);

        $this->db->from($this->_table);

        if (!empty($search)) {

        }

        $this->db->order_by($sort_field, $sortby);

        $this->db->limit($limit, $start);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }


    public function count_all_rows($search = "")
    {

        $this->db->select("COUNT(*) AS numrows");

        $this->db->from($this->_table);

        if (!empty($search)) {

        }

        return $this->db->get()->row()->numrows;
    }


    public function get_detail($idPedido)
    {
        $this->db->select("*");

        $this->db->from($this->_table);

        $this->db->join('tbl_producto', 'tbl_producto.id = '.$this->_table.'.producto_id');

        $this->db->where('pedido_id', $idPedido);

        $query  = $this->db->get();

        $result = ($query->result_array());

        return $result;
        
    }

    public function guardar_pedido_detalle($data){

        $this->db->insert($this->_table, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
        
    }

}
