<?php

if (!defined("BASEPATH")) {
    exit('No direct script access allowed');
}

class Producto_model extends CI_Model
{

    private $_table            = 'tbl_producto';

    private $_pk_field         = 'id';

    private $list_colums       = array('tbl_producto.id', 'nombre', 'descripcion', 'precio', 'img_ppla', 'estado');

    private $sort_colums_order = array('tbl_producto.id', 'nombre', 'descripcion', 'precio', 'img_ppla', 'estado');

    public function __construct()
    {

        parent::__construct();

        $this->load->database();

    }

    public function findByPk($id)
    {

        $this->db->select("*");

        $this->db->from($this->_table);

        $this->db->where("tbl_producto.estado", "1");

        $this->db->where($this->_pk_field, $id);

        $this->db->limit(1);

        $query  = $this->db->get();

        $result = ($query->result_array());

        return $result;

    }

    public function get_data($sort_num = 0, $sortby = "DESC", $limit, $start, $search = "")
    {

        $sort_field = $this->sort_colums_order[$sort_num];

        $this->db->select($this->sort_colums_order);

        $this->db->from($this->_table);

        $this->db->join('tbl_tienda', 'tbl_tienda.id = tbl_producto.tienda_id');

        $this->db->where("tbl_producto.estado", "1");

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

        $this->db->where("tbl_producto.estado", "1");

        if (!empty($search)) {

        }

        return $this->db->get()->row()->numrows;
    }


    public function get_productos_activos()
    {

        $this->db->select($this->sort_colums_order);

        $this->db->from($this->_table);
    
        $this->db->where("tbl_producto.estado", "1");
        
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }


    public function get_productos_activos_cart()
    {
        $this->db->select($this->sort_colums_order);

        $this->db->from($this->_table);

        $this->db->where("tbl_producto.estado", "1");

        $this->db->limit(3);

        $this->db->order_by('rand()');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }

}
