<?php
class Producto extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library("form_validation");
        $this->load->library("session");
        $this->load->helper("url");
        $this->load->model('Producto_model');

        if (!$this->session->userdata("id_usuario")) {
            header("Location: /");
        }

    }

    /**
     * Functon index
     *
     * list all the values in grid
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     *
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */

    public function index()
    {

        $this->load->view('header');
        if($this->session->userdata('perfil')==1){
            $this->load->view('Producto/list_Producto');
        }else{
             $this->load->view('Producto/tienda');
        }
        
        $this->load->view('footer');
    }

    public function tienda($idTienda)
    {
        $data['id'] = $idTienda;
        $this->load->view('header');
        $this->load->view('Producto/list_producto_tienda', $data);
        $this->load->view('footer');
    }

    public function inventario($idProducto)
    {
        $data['id'] = $idProducto;
        $this->load->view('header');
        $this->load->view('Producto/inventario', $data);
        $this->load->view('footer');
    }

    /**
     * Functon create
     *
     * create form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     * @
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */

    public function create($idTienda)
    {
        $data['id'] = 0;
        $data['update_data']['tienda_id'] = $idTienda;
        $this->load->view('Producto/create_Producto', $data);
        

    }




    public function create_p($idTienda)
    {
        $data['id'] = 0;
        $data['update_data']['tienda_id'] = $idTienda;
        $this->load->view('Producto/create_Producto', $data);
        

    }

    /**
     * Functon edit
     * edit form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */
    public function edit($id = 0)
    {

        $data['id'] = $id;
        if ($id != 0) {
            $result = $this->Producto_model->findByPk($id);
            if (empty($result)) {
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = array_shift($result);
            }

        }
        $this->load->view('Producto/create_Producto', $data);
    }

    /**
     * Functon process
     *
     * process form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     * @
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */
    public function process_form()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id                     = isset($_POST['id']) ? $_POST['id'] : 0;
        $userid                 = $this->session->userdata('user_id');
        $message['is_error']    = true;
        $message['error_count'] = 0;
        $data                   = array();

        $this->form_validation->set_rules("tienda_id", "tienda id", "required");
        //$this->form_validation->set_rules("categoria_id", "categoria id", "required");
        $this->form_validation->set_rules("nombre", "nombre", "required");
        $this->form_validation->set_rules("descripcion", "descripcion", "required");
        $this->form_validation->set_rules("precio", "precio", "required");
        //$this->form_validation->set_rules("img_ppla", "img ppla", "required");
        $this->form_validation->set_rules("estado", "estado", "required");

        if ($this->form_validation->run() == false) {

            $message['is_redirect'] = false;
            $err                    = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data                   = $err;
            $count                  = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {

            $id           = $this->input->post('id');
            $tienda_id    = $this->input->post('tienda_id');
            //$categoria_id = $this->input->post('categoria_id');
            $nombre       = $this->input->post('nombre');
            $descripcion  = $this->input->post('descripcion');
            $precio       = $this->input->post('precio');
            //$img_ppla= $this->input->post('img_ppla');
            $estado = $this->input->post('estado');

            $data_inser_array = array('tienda_id' => $tienda_id,
                //'categoria_id'                        => $categoria_id,
                'nombre'                              => $nombre,
                'descripcion'                         => $descripcion,
                'precio'                              => $precio,
                //'img_ppla'=>$img_ppla,
                'estado'                              => $estado,
            );

            $config['upload_path']   = 'public/products/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 0;
            $config['max_width']     = 0;
            $config['max_height']    = 0;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('img_ppla')) {
                $data                         = array('upload_data' => $this->upload->data());
                $data_inser_array['img_ppla'] = $data['upload_data']['file_name'];
            }

            if (isset($id) && !empty($id)) {

                $condition = array("id" => $id);
                // $insert = $this->Producto_model->update('tbl_producto',$data_inser_array,$condition);
                $insert = $this->db->update('tbl_producto', $data_inser_array, $condition);
                $data   = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {
                //$insert = $this->Producto_model->create('tbl_producto',$data_inser_array);
                $insert                 = $this->db->insert('tbl_producto', $data_inser_array);
                $message['is_redirect'] = true;

                $data = "Data Inserted Successfully.";
            }
            if ($insert) {

                $message['is_error']    = false;
                $message['is_redirect'] = true;

            } else {
                $message['is_error']    = true;
                $message['is_redirect'] = false;
                $data                   = "Something Went Wrong..";
            }

        }
        $message['data'] = $data;
        echo json_encode($message);
        exit;

    }


    public function process_form_inventario(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id                     = isset($_POST['producto_id']) ? $_POST['producto_id'] : 0;
        $userid                 = $this->session->userdata('user_id');
        $message['is_error']    = true;
        $message['error_count'] = 0;
        $data                   = array();

        $this->form_validation->set_rules("producto_id", "producto_id id", "required");
        $this->form_validation->set_rules("cantidad", "cantidad id", "required");

        if ($this->form_validation->run() == false) {

            $message['is_redirect'] = false;
            $err                    = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data                   = $err;
            $count                  = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {

            $data_inser_array = array(
                'producto_id'                           => $this->input->post('producto_id'),
                'cantidad'                              => $this->input->post('cantidad'),
                'fecha_ingreso'                         => date("Y-m-d H:i:s")
            );
            $insert                 = $this->db->insert('tbl_inventario', $data_inser_array);
            $message['is_redirect'] = true;
            $data = "Data Inserted Successfully.";


            if ($insert) {

                $message['is_error']    = false;
                $message['is_redirect'] = true;

            } else {
                $message['is_error']    = true;
                $message['is_redirect'] = false;
                $data                   = "Something Went Wrong..";
            }

        }
        $message['data'] = $data;
        echo json_encode($message);
        exit;
    }

    /**
     * Functon list_all_data
     *
     * process grid data
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     * @
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */

    public function list_all_data()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->library('pagination');

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $config["total_rows"] = $this->Producto_model->count_all_rows($search);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Producto_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

        $output = array(
            "aaData"               => $arr,
            "sEcho"                => intval($_GET["sEcho"]),
            "iTotalRecords"        => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],

        );
        echo json_encode($output);

        exit;
    }

    public function list_all_data_inventario($idProducto)
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->library('pagination');

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $config["total_rows"] = $this->Producto_model->count_all_rows_inventario($search, $idProducto);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Producto_model->get_data_inventario($sort_col, $sort_dir, $limit, $start, $search, $idProducto);

        $output = array(
            "aaData"               => $arr,
            "sEcho"                => intval($_GET["sEcho"]),
            "iTotalRecords"        => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],

        );
        echo json_encode($output);

        exit;
    }

    public function list_all_data_by_tienda($idTienda)
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->library('pagination');

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $config["total_rows"] = $this->Producto_model->count_all_rows_tienda($search, $idTienda);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Producto_model->get_data_tienda($sort_col, $sort_dir, $limit, $start, $search, $idTienda);

        $output = array(
            "aaData"               => $arr,
            "sEcho"                => intval($_GET["sEcho"]),
            "iTotalRecords"        => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],

        );
        echo json_encode($output);

        exit;
    }

    /**
     * Functon remove_form
     *
     * process grid data
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-09
     * @
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */

    public function remove_form()
    {

        $message["is_error"] = true;
        $pid                 = $this->input->post("id");

        if (!empty($pid)) {
            $data = $this->Producto_model->findByPk($pid);

            $condition = array("id" => $pid);


            $data_inser_array = array(
                'estado' => 2
            );
            $insert = $this->db->update('tbl_producto', $data_inser_array, $condition);

            // $params = array("is_active" => 0);

            //$insert = $this->db->delete("tbl_producto", $condition);

            $message["is_error"] = false;
            $data[]              = "Entry Removed Successfully";
            $this->session->set_flashdata("Entry Removed Successfully", "sucess");
        } else {
            $data[] = "Entry Not Existing";
            $this->session->set_flashdata("Entry Not Existing", "error");
        }

        $message["data"] = $data;
        echo json_encode($message);
        exit;

    }
}