<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller Class
 *
 * Extends CodeIgniter Controller
 * Basic Model loads and settings set.
 *
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();

        if (!$this->db->db_select()) {
            $error =& load_class('Exceptions', 'core');
            echo $error->show_error('Database Error', 'Unable to connect to the specified database : '. $this->db->database, 'error_db');
            exit;
        }

        // Models
        $this->load->model(array('base_model'), '', TRUE);

        // Libraries
        $this->load->library('smarty');
        $this->load->library('session');

        $this->load->helper('url_helper');

    }

    protected function xhr_output($data) {
        if (is_array($data) OR is_object($data)) {
            $data = json_encode($data);
        }
        echo($data);
        die();
    }

    protected function _display($template, $data = array()) {
        $data['session'] = $this->session->userdata();
        return $this->smarty->view($template, $data);
    }

//    datatabel渲染表格
    public function echojson($draw, $recordsTotal, $recordsFiltered, $ret)
    {
        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $ret
        ),JSON_UNESCAPED_UNICODE);
    }
}
// End MY_Controller
