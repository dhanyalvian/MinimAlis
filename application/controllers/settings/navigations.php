<?php
/**
 * Description of Navigations
 * 
 * @author  dhanyalvian@gmail.com
 */

class Navigations extends MY_Controller {
    protected $_pageController = 'navigations';
    protected $_pageTitle = 'Navigations Management';
    protected $_pageActive = 'settings';
    protected $_pageViews = 'settings/navigations';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Settings', 'url' => ''),
    //    array ('title' => 'Users Management', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'navigations');
    protected $_navigationsModel = 'settings/navigations_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['combobox_parent'] = $this->getComboboxParent();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_navigationsModel);
        $response = $this->navigations_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxParent() {
        $this->load->model($this->_navigationsModel);
        return $this->navigations_model->getComboboxParent();
    }

    //---------------------------------------------- sampai sini dulu yak ---------------------------------------------------//
    
    
    
    
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('username', 'fullname');
        
        $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[3]|max_length[30]|xss_clean');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_username_check');
        }
        else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_username_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_navigationsModel);
            $result = $this->navigations_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New User successfully added.' : 'User successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New user failed added.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function username_check($value) {
        $this->load->model($this->_navigationsModel);
        
        if ($this->navigations_model->checkUsernameExist($value)) {
            $this->form_validation->set_message('username_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function username_check_edit($value) {
        $this->load->model($this->_navigationsModel);
        
        if ($this->navigations_model->checkUsernameExist($value, $this->input->post('edit_username', true))) {
            $this->form_validation->set_message('username_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_navigationsModel);
        $row = $this->navigations_model->edit($id);
        
        if (is_array($row) && count($row) > 0) {
            $this->_ajaxStatus = true;
            $this->_ajaxData = $row;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Get data failed';
        }
        
        $this->_ajaxResponse();
    }
    
    public function delete() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_navigationsModel);
        $result = $this->navigations_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete User failed';
        }
        
        $this->_ajaxResponse();
    }
    
    public function reset() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_navigationsModel);
        $result = $this->navigations_model->reset($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Reset Password failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file navigations.php */
/* Location: ./application/controllers/settings/navigations.php */