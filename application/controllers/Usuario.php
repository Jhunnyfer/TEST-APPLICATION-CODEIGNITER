<?php
class Usuario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library("form_validation");
        $this->load->library("session");
        $this->load->helper("url");
        $this->load->model('Usuario_model');

        if (!$this->session->userdata("id_usuario")) {
            header("Location: /");
        }}

    /**
     * Functon index
     *
     * list all the values in grid
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-08
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
        $this->load->view('Usuario/list_Usuario');
        $this->load->view('footer');
    }

    /**
     * Functon create
     *
     * create form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-08
     * @
     *
     * @param type
     * @return type
     * exceptions
     *
     * Created Using CIIgnator
     *
     */

    public function create()
    {
        $data['id'] = 0;

        $this->load->view('header');
        $this->load->view('Usuario/create_Usuario', $data);
        $this->load->view('footer');

    }

    /**
     * Functon edit
     * edit form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-08
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
            $result = $this->Usuario_model->findByPk($id);
            if (empty($result)) {
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = array_shift($result);
            }

        }

        $this->load->view('header');
        $this->load->view('Usuario/create_Usuario', $data);
        $this->load->view('footer');

    }

    /**
     * Functon process
     *
     * process form
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-08
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

        $this->form_validation->set_rules("nombre_completo", "nombre completo", "required");
        $this->form_validation->set_rules("usuario", "usuario", "required");
        $this->form_validation->set_rules("password", "password", "required");
        $this->form_validation->set_rules("direccion", "direccion", "required");
        $this->form_validation->set_rules("email", "email", "required");
        $this->form_validation->set_rules("telefono", "telefono", "required");
        $this->form_validation->set_rules("perfil_id", "perfil id", "required");
        if($this->input->post('perfil_id')!=2){
            //$this->form_validation->set_rules("tienda_id", "tienda id", "required");
        }
        $this->form_validation->set_rules("status", "status", "required");

        if ($this->form_validation->run() == false) {

            $message['is_redirect'] = false;
            $err                    = validation_errors();
            //$err =  $this->form_validation->_error_array();
            $data                   = $err;
            $count                  = count($this->form_validation->error_array());
            $message['error_count'] = $count;
        } else {
            $id              = $this->input->post('id');
            $nombre_completo = $this->input->post('nombre_completo');
            $usuario         = $this->input->post('usuario');
            $password        = sha1($this->input->post('password'));
            $direccion       = $this->input->post('direccion');
            $email           = $this->input->post('email');
            $telefono        = $this->input->post('telefono');
            $perfil_id       = $this->input->post('perfil_id');
            $tienda_id       = $this->input->post('tienda_id');
            $status          = $this->input->post('status');

            $data_inser_array = array('nombre' => $nombre_completo,
                'usuario'                          => $usuario,
                'password'                         => $password,
                'direccion'                        => $direccion,
                'email'                            => $email,
                'telefono'                         => $telefono,
                'perfil_id'                        => $perfil_id,
                'tienda_id'                        => $tienda_id,
                'status'                           => $status,
            );

            if (isset($id) && !empty($id)) {

                $condition = array("id" => $id);
                // $insert = $this->Usuario_model->update('tbl_usuario',$data_inser_array,$condition);
                $insert = $this->db->update('tbl_usuario', $data_inser_array, $condition);
                $data   = "Data Updated Successfully.";
                $this->session->set_flashdata('smessage', "Data Updated Successfully");
                $message['is_redirect'] = true;
            } else {
                //$insert = $this->Usuario_model->create('tbl_usuario',$data_inser_array);
                $insert = $this->db->insert('tbl_usuario', $data_inser_array);

                $data_inser_array = array('tienda_id' => $tienda_id, 'caja_menor' => 0);
                $insert           = $this->db->insert('tbl_caja_menor', $data_inser_array);

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

    /**
     * Functon list_all_data
     *
     * process grid data
     *
     * @auther Shabeeb <mail@shabeebk.com>
     * @createdon   : 2019-04-08
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

        $config["total_rows"] = $this->Usuario_model->count_all_rows($search);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Usuario_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

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
     * @createdon   : 2019-04-08
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
            $data = $this->Usuario_model->findByPk($pid);

            $condition = array("id" => $pid);
             $data_inser_array = array(
                'status' => 2
            );
            $insert = $this->db->update('tbl_usuario', $data_inser_array, $condition);
            // $params = array("is_active" => 0);

            //$insert = $this->db->delete("tbl_usuario", $condition);

            $message["is_error"] = false;
            $data[]              = "Usuario eliminado correctamente!";
            $this->session->set_flashdata("Entry Removed Successfully", "sucess");
        } else {
            $data[] = "Usuario no existe!";
            $this->session->set_flashdata("Usuario no existe!", "error");
        }

        $message["data"] = $data;
        echo json_encode($message);
        exit;

    }}
