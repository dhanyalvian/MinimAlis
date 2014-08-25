<?php
/**
 * Description of Module
 * 
 * @author  dhanyalvian@gmail.com
 */

class Module extends SIA_Controller {
    protected $_pageController = 'module';
    //protected $_pageTitle = 'Message Module';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/module';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Message Module', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'module');
    protected $_moduleModel = 'master_data/module_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['combobox_handler'] = $this->getComboboxHandler();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_moduleModel);
        $response = $this->module_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxHandler() {
        $this->load->model($this->_moduleModel);
        return $this->module_model->getComboboxHandler();
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('module', 'handler');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('module', 'Module', 'trim|required|min_length[3]|max_length[50]|xss_clean|callback_module_check');
            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        }
        else {
            $this->form_validation->set_rules('module', 'Module', 'trim|required|min_length[3]|max_length[50]|xss_clean|callback_module_check_edit');
            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_moduleModel);
            $result = $this->module_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Module successfully inserted.' : 'Module successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New Module failed inserted.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function module_check($value) {
        $this->load->model($this->_moduleModel);
        
        if ($this->module_model->checkModuleExist($value)) {
            $this->form_validation->set_message('module_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function module_check_edit($value) {
        $this->load->model($this->_moduleModel);
        
        if ($this->module_model->checkModuleExist($value, $this->input->post('edit_module', true))) {
            $this->form_validation->set_message('module_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_moduleModel);
        $row = $this->module_model->edit($id);
        
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
        $this->load->model($this->_moduleModel);
        $result = $this->module_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Module failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file module.php */
/* Location: ./application/controllers/master_data/module.php */