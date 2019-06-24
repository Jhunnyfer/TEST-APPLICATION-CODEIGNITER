<?php
if (!defined("BASEPATH")) {
    exit('No direct script access allowed');
}

class Usuario_model extends CI_Model
{

    private $_table            = 'tbl_usuario';

    private $_pk_field         = 'id';

    private $list_colums       = array('id', 'nombre', 'usuario', 'password', 'direccion', 'email', 'telefono', 'perfil_id', 'tienda_id', 'status');

    private $sort_colums_order = array('id', 'nombre', 'usuario', 'password', 'direccion');

    public function __construct()
    {

        parent::__construct();

        $this->load->database();

    }

    public function findByPk($id)
    {

        $this->db->select("*");

        $this->db->from($this->_table);

        $this->db->where("status", "1");

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

         $this->db->where("status", "1");

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

        $this->db->where("status", "1");

        if (!empty($search)) {
        }

        return $this->db->get()->row()->numrows;
    }

    public function iniciar_sesion($email, $password )
    {
        $result = null;

        $this->db->group_start(); 

        $this->db->where('email', $email);

        $this->db->or_where('usuario',  $email);

        $this->db->group_end();

        $this->db->where('password', $password );

        $this->db->where('status', 1 );

        $query = $this->db->get('tbl_usuario' );

        if ($query->num_rows() == 1 )
        {
            
            $result['status'] = 1;

            $result['user'] = $query->row();

        }

        return $result;
    }



    public function registro($data )
    {
         $this->db->insert($this->_table, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

}
