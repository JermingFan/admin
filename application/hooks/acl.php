<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acl
{
    private $cName;
    private $fName;
    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->cName = $this->CI->uri->segment(1);
        $this->fName = $this->CI->uri->segment(2);

        $this->CI->load->model(array(
            'Personalinfo_model',
            'Users_model',
        ));

        if (!$this->cName)
        {
            $this->cName = 'user';
        }
        if (!$this->fName)
        {
            $this->fName = 'index';
        }
    }

    function auth() {
        $user_id = $this->CI->session->userdata('uid');

        if (empty($user_id)) {
            // check cookie
            $user_id = $this->CI->input->cookie('user_id');
            $token = $this->CI->input->cookie('token');

            if ($user_id && $token) {
                $result = $this->CI->Users_model->get_row_array(array(Users_model::ID => $user_id, Users_model::ACCESS_TOKEN => $token));

                if (empty($result)) {
                    $this->_redirect();
                } else {
                    $data = $this->CI->Personalinfo_model->get_row_array(array(Personalinfo_model::USER_ID => $user_id));
                    // create session
                    $this->CI->session->set_userdata(array(
                        'uid' => $user_id,
                        'token' => $result[Users_model::M_ACCESS_TOKEN],
                        'username' => $data[Personalinfo_model::USER_NAME],
                        'avatar' => $data[Personalinfo_model::FACE],
                        //'type' => 'normal',
                    ));

                    $this->CI->Users_model->update_login_info($user_id);
                    //$this->CI->_assign('globalLoginUserToken', $this->CI->Users_model->getMTokenByUserId($user_id));
                    //$this->CI->_assign('globalLoginUserPhoto', $this->CI->PersonalinfoModel->getPhotoByUserId($user_id));
                }
            } else {
                $this->_redirect();
            }
        }/* else {
      $this->CI->_assign('globalLoginUserToken', $this->CI->Users_model->getMTokenByUserId($userId));
      $this->CI->_assign('globalLoginUserPhoto', $this->CI->PersonalinfoModel->getPhotoByUserId($userId));
    }*/
    }

    private function _redirect() {
        $this->CI->config->load('acl');
        $auth = $this->CI->config->item('auth');

        if (array_key_exists($this->cName, $auth)) {
            if (in_array($this->fName, $auth[$this->cName])) {
                redirect ('/account/login?redirect=' . urlencode(current_url()));
                die();
            }
        }
    }
}