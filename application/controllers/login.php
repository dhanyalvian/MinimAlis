<?php
/**
 * Description of Login
 * 
 * @author  dhanyalvian@gmail.com
 */

class Login extends MY_Controller {
    protected $_pageController = 'login';
    protected $_pageTitle = 'Login';
    protected $_pageActive = 'login';
    protected $_pageViews = 'login';
    protected $_pageHeader = false;
    protected $_pageBreadcrumb = false;
    protected $_additionalJs = array ('login');

    protected $_username;

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->checkSessionLogin();
        $this->load->view('structure', $this->_data);
    }
    
    protected function checkSessionLogin() {
        if ($this->session->userdata('username')) {
            redirect(base_url() . $this->config->item('home_url'));
        }
    }

    public function authentication() {
        $this->_isAjax = true;
        
        $sid = $this->input->post('sid', true);
        $username = $this->input->post('cms_username', true);
        $password = $this->input->post('cms_password', true);
        $this->_username = $username;
        
        $this->load->model('login_model');
        $authentication = $this->login_model->authentication($username, $password);
        
        if (is_array($authentication) && count($authentication) > 0) {
            $referer = !empty ($sid) ? $this->getUrlDecode($sid) : $this->config->item('home_url');
            $this->setSessionLogin($authentication);
            $this->_ajaxStatus = true;
            $this->_ajaxMessage = 'Login success.';
            $this->_ajaxData = array ('redirect' => base_url() . $referer);
        }
        else {
            $this->_ajaxMessage = 'Login failed.';
        }
        
        $this->_ajaxResponse();
    }
    
    protected function setSessionLogin($data) {
        $sessionData = array (
            'username' => $this->_username,
            'fullname' => $data[0]->fullname,
            'role' => $data[0]->role,
            'logged_in' => true
        );

        $this->session->set_userdata($sessionData);
    }
    
    public function out() {
        $this->session->sess_destroy();
        redirect(base_url() . $this->config->item('logout_redirect'));
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */