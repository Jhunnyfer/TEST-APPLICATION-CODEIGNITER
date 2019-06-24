<?php
class PedidoDetalle extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library("form_validation");
        $this->load->library("session");
        $this->load->helper("url");
        $this->load->model('PedidoDetalle_model');
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
        $this->load->view('PedidoDetalle/list_PedidoDetalle');
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

    public function create()
    {
        $data['id'] = 0;

        $this->load->view('header');
        $this->load->view('PedidoDetalle/create_PedidoDetalle', $data);
        $this->load->view('footer');

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
            $result = $this->PedidoDetalle_model->findByPk($id);
            if (empty($result)) {
                show_error('Page is not existing', 404);
            } else {
                $data['update_data'] = $result;
            }

        }

        $this->load->view('header');
        $this->load->view('PedidoDetalle/create_PedidoDetalle', $data);
        $this->load->view('footer');

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

        $config["total_rows"] = $this->PedidoDetalle_model->count_all_rows($search);

        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();

        $sort_col = $_GET["iSortCol_0"];
        $sort_dir = $_GET["sSortDir_0"];
        $limit    = $_GET["iDisplayLength"];
        $start    = $_GET["iDisplayStart"];
        $search   = $_GET["sSearch"];

        $arr = $this->PedidoDetalle_model->get_data($sort_col, $sort_dir, $limit, $start, $search);

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
            $data = $this->employee_model->findByPk($pid);

            $condition = array("id_pedido_det" => $pid);
            // $params = array("is_active" => 0);

            $insert = $this->db->delete("tbl_pedido_detalle", $condition);

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
