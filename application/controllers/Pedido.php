<?php
class Pedido extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->
            load->library("form_validation");
        $this->load->library("session");
        $this->load->helper("url");
        $this->load->model('Pedido_model');
        if (!$this->session->userdata("id_usuario")) {
            header("Location: /");
        }

    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('Pedido/list_Pedido');
        $this->load->view('footer');
    }

    public function tienda($idTienda)
    {
        $data['id'] = $idTienda; 
        $this->load->view('header');
        $this->load->view('Pedido/list_pedido_tienda', $data);
        $this->load->view('footer');
    }


    public function ver($id){

        $sql="select * from tbl_pedido where id_pedido='".$id."'";
        $query = $this->db->query($sql);
        $rowOrder = $query->row();

        $sqlDetail="SELECT tbl_pedido_detalle.*, tbl_producto.nombre, tbl_producto.img_ppla FROM tbl_pedido_detalle INNER JOIN tbl_producto ON tbl_producto.id = tbl_pedido_detalle.producto_id where pedido_id=".$rowOrder->id_pedido;
        $queryDetail=$this->db->query($sqlDetail);
        $resultDetail=$queryDetail->result();
        $dataView = array('order' => $rowOrder, 'details'=>$resultDetail);
        
        $this->load->view('header');
        $this->load->view('Pedido/detail_order', $dataView);
        $this->load->view('footer');
    }



     public function pedido_tienda($id){

        $sql="select * from tbl_pedido where id_pedido='".$id."'";
        $query = $this->db->query($sql);
        $rowOrder = $query->row();

        $sqlDetail="SELECT tbl_pedido_detalle.*, tbl_producto.nombre, tbl_producto.img_ppla FROM tbl_pedido_detalle INNER JOIN tbl_producto ON tbl_producto.id = tbl_pedido_detalle.producto_id where pedido_id=".$rowOrder->id_pedido;
        $queryDetail=$this->db->query($sqlDetail);
        $resultDetail=$queryDetail->result();
        $dataView = array('order' => $rowOrder, 'details'=>$resultDetail);
        
        $this->load->view('header');
        $this->load->view('Pedido/update_pedido_tienda', $dataView);
         $this->load->view('footer');


    }


    public function actilizar_informacion_pedido(){
        $data_inser_array    = array(
                'estado_pedido'                    => 2,
                'numeroguia'                       => $this->input->post('numeroguia')
            );
        
        $condition = array("id_pedido" => $this->input->post('id'));
        $insert = $this->db->update('tbl_pedido', $data_inser_array, $condition);

        $this->send_mail($this->input->post('id'));

        $message['data'] =  "Pedido Despachado Correctamente.";
        $message['is_redirect'] = true;
        echo json_encode($message);
        exit;
    }

    public function create()
    {
        $data['id'] = 0;
        $this->load->view('header');
        $this->load->view('Pedido/create_Pedido', $data);
        $this->load->view('footer');
    }

    public function edit($id = 0)
    {

        $data['id'] = $id;
        if ($id != 0) {
            $result = $this->Pedido_model->findByPk($id);
            if (empty($result)) {
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = $result;
            }

        }

        $this->load->view('header');
        $this->load->view('Pedido/create_Pedido', $data);
        $this->load->view('footer');

    }

    public function process_form()
    {
    }

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

        $config["total_rows"] = $this->Pedido_model->count_all_rows($search);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Pedido_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

        $output = array(
            "aaData"               => $arr,
            "sEcho"                => intval($_GET["sEcho"]),
            "iTotalRecords"        => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],

        );
        echo json_encode($output);

        exit;
    }

    public function list_all_data_tienda($idTienda)
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

        $config["total_rows"] = $this->Pedido_model->count_all_rows_tienda($search, $idTienda);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->Pedido_model->get_data_tienda($sort_col, $sort_dir, $limit, $start, $search, $idTienda);

        $output = array(
            "aaData"               => $arr,
            "sEcho"                => intval($_GET["sEcho"]),
            "iTotalRecords"        => $config["total_rows"],
            "iTotalDisplayRecords" => $config["total_rows"],

        );
        echo json_encode($output);

        exit;
    }

    public function remove_form()
    {

        $message["is_error"] = true;
        $pid                 = $this->input->post("id");

        if (!empty($pid)) {
            $data = $this->employee_model->findByPk($pid);

            $condition = array("id_pedido" => $pid);
            // $params = array("is_active" => 0);

            $insert = $this->db->delete("tbl_pedido", $condition);

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
    /**
     * Send Email 
     * */
        public function send_mail($idOrden){

        $sql = "SELECT * from tbl_pedido where id_pedido='" . $idOrden . "' and estado_pedido=2";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $this->load->library(array('session', 'form_validation'));
            $rowOrder = $query->row();

            $sqlDetail="SELECT tbl_pedido_detalle.*, tbl_producto.nombre, tbl_producto.img_ppla FROM tbl_pedido_detalle INNER JOIN tbl_producto ON tbl_producto.id = tbl_pedido_detalle.producto_id where pedido_id=".$rowOrder->id_pedido;
            $queryDetail = $this->db->query($sqlDetail);
            $resultDetail = $queryDetail->result();

            $dataView = array('order' => $rowOrder, 'details' => $resultDetail);
            $InfoView = $this->load->view('Pedido/send_mail', $dataView, true);

            $from_email = "info@reportes.in";
            
            $to_email   = $rowOrder->correo_comprador;

            //Load email library
            $this->load->library('email');

            $config = array(
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'mailtype' => 'html',
            );

            $this->email->initialize($config);
            $this->email->from($from_email, 'REPORTES.IN');
            $this->email->to($to_email);
            $this->email->subject('ORDEN - REPORTES.IN');
            $this->email->message($InfoView);
            if ($this->email->send()) {
                $this->session->set_flashdata("email_sent", "Email sent correctly");
                $data = 'Email pedido enviado correctamente!';
            } else {
                $data = 'Error enviando email!';
            }
        }else{
            $data = 'Pedido no despachado';
        }
    }

}
