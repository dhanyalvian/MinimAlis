<?php
/**
 * Description of Test_number
 * 
 * @author  dhanyalvian@gmail.com
 */

class Test_number extends MY_Controller {
    protected $_pageController = 'test_number';
    protected $_pageTitle = 'Test Number';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/test_number';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'Test Number', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'test_number');
    protected $_testNumberModel = 'master_data/test_number_model';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_testNumberModel);
        $response = $this->test_number_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('msisdn');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('msisdn', 'MSISDN', 'trim|required|numeric|min_length[3]|max_length[30]|xss_clean|callback_msisdn_check');
        }
        else {
            $this->form_validation->set_rules('msisdn', 'MSISDN', 'trim|required|numeric|min_length[3]|max_length[30]|xss_clean|callback_msisdn_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_testNumberModel);
            $result = $this->test_number_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Test Number successfully added.' : 'Test Number successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'Test Number failed saved.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function msisdn_check($value) {
        $this->load->model($this->_testNumberModel);
        
        if ($this->test_number_model->checkMsisdnExist($value)) {
            $this->form_validation->set_message('msisdn_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function msisdn_check_edit($value) {
        $this->load->model($this->_testNumberModel);
        
        if ($this->test_number_model->checkMsisdnExist($value, $this->input->post('edit_msisdn', true))) {
            $this->form_validation->set_message('msisdn_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_testNumberModel);
        $row = $this->test_number_model->edit($id);
        
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
        $this->load->model($this->_testNumberModel);
        $result = $this->test_number_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Test Number failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file test_number.php */
/* Location: ./application/controllers/master_data/test_number.php */