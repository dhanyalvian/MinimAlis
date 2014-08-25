<?php
/**
 * Description of Password
 * 
 * @author  dhanyalvian@gmail.com
 */

class Password extends MY_Controller {
    protected $_pageController = 'password';
    protected $_pageTitle = 'Change Password';
    protected $_pageActive = 'profile';
    protected $_pageViews = 'profile/password';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Profile', 'url' => ''),
    //    array ('title' => 'Change Password', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'password');
    protected $_passwordModel = 'profile/password_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        //$this->_data['edit_username'] = $this->session->userdata('username');
        $this->load->view('structure', $this->_data);
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('old_password', 'new_password', 'confirm_password');
        
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_password_check');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[3]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'trim|required|min_length[3]|max_length[20]|matches[new_password]|xss_clean');
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_passwordModel);
            $result = $this->password_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = 'Password has been changed.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'Change password failed.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function password_check($value) {
        $this->load->model($this->_passwordModel);
        
        if (!$this->password_model->checkPasswordExist($value)) {
            $this->form_validation->set_message('password_check', 'Invalid Old Password');
            
            return false;
        }
        
        return true;
    }
    
}

/* End of file password.php */
/* Location: ./application/controllers/profile/password.php */