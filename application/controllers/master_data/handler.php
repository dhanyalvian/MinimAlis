<?php
/**
 * Description of Handler
 * 
 * @author  dhanyalvian@gmail.com
 */

class Handler extends MY_Controller {
    protected $_pageController = 'handler';
    protected $_pageTitle = 'Custom Handler';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/handler';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'Handler', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'handler');
    protected $_handlerModel = 'master_data/handler_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_handlerModel);
        $response = $this->handler_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('handler');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|min_length[3]|max_length[50]|xss_clean|callback_handler_check');
        }
        else {
            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|min_length[3]|max_length[50]|xss_clean|callback_handler_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_handlerModel);
            $result = $this->handler_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Handler successfully inserted.' : 'Handler successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New Handler failed inserted.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function handler_check($value) {
        $this->load->model($this->_handlerModel);
        
        if ($this->handler_model->checkHandlerExist($value)) {
            $this->form_validation->set_message('handler_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function handler_check_edit($value) {
        $this->load->model($this->_handlerModel);
        
        if ($this->handler_model->checkHandlerExist($value, $this->input->post('edit_handler', true))) {
            $this->form_validation->set_message('handler_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_handlerModel);
        $row = $this->handler_model->edit($id);
        
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
        $this->load->model($this->_handlerModel);
        $result = $this->handler_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Handler failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file handler.php */
/* Location: ./application/controllers/master_data/handler.php */