<?php
/**
 * Description of Operator
 * 
 * @author  dhanyalvian@gmail.com
 */

class Operator extends MY_Controller {
    protected $_pageController = 'operator';
    protected $_pageTitle = 'Operator';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/operator';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'Operator', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'operator');
    protected $_operatorModel = 'master_data/operator_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_operatorModel);
        $response = $this->operator_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('operator', 'operator_long');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|min_length[2]|max_length[50]|xss_clean|callback_operator_check');
        }
        else {
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|min_length[2]|max_length[50]|xss_clean|callback_operator_check_edit');
        }
        
        $this->form_validation->set_rules('operator_long', 'Operator Long', 'trim|required|min_length[3]|max_length[50]|xss_clean');
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_operatorModel);
            $result = $this->operator_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Operator successfully inserted.' : 'Operator successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New Operator failed inserted.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function operator_check($value) {
        $this->load->model($this->_operatorModel);
        
        if ($this->operator_model->checkOperatorExist($value)) {
            $this->form_validation->set_message('operator_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function operator_check_edit($value) {
        $this->load->model($this->_operatorModel);
        
        if ($this->operator_model->checkOperatorExist($value, $this->input->post('edit_operator', true))) {
            $this->form_validation->set_message('operator_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_operatorModel);
        $row = $this->operator_model->edit($id);
        
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
        $this->load->model($this->_operatorModel);
        $result = $this->operator_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Operator failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file operator.php */
/* Location: ./application/controllers/master_data/operator.php */