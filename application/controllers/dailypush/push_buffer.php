<?php
/**
 * Description of Push_buffer
 * 
 * @author  dhanyalvian@gmail.com
 */

class Push_buffer extends MY_Controller {
    protected $_pageController = 'push_buffer';
    protected $_pageTitle = 'Push Buffer';
    protected $_pageActive = 'dailypush';
    protected $_pageViews = 'dailypush/push_buffer';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Daily Push', 'url' => ''),
    //    array ('title' => 'Push Buffer', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables', 'bootstrap-datetimepicker.min');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'moment', 'bootstrap-datetimepicker.min', 'push_buffer');
    protected $_pushBufferModel = 'dailypush/push_buffer_model';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['today'] = date($this->dateTimeFormatPhp);
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->_data['combobox_service'] = $this->getComboboxService();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_pushBufferModel);
        $response = $this->push_buffer_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxOperator() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxOperator();
    }
    
    public function getComboboxService() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxService();
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('content_label', 'content', 'author', 'datepublish');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('content_label', 'Content Label', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('datepublish', 'Date Publish', 'trim|required|min_length[1]|xss_clean|callback_datepublish_check');
        }
        else {
            //$this->form_validation->set_rules('adn', 'ADN', 'trim|required|numeric|min_length[3]|max_length[10]|xss_clean|callback_adn_check_edit');
            $this->form_validation->set_rules('content_label', 'Content Label', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('author', 'Author', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('datepublish', 'Date Publish', 'trim|required|min_length[1]|xss_clean|callback_datepublish_check');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_pushBufferModel);
            $result = $this->push_buffer_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'Push Content successfully added.' : 'Push Content successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'Push Content failed added.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function datepublish_check($value) {
        $dateCheck = DateTime::createFromFormat($this->dateTimeFormatPhp, $value);
        
        if (!$dateCheck) {
            $this->form_validation->set_message('datepublish_check', 'The %s "' . $value . '" is invalid format date');
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_pushBufferModel);
        $row = $this->push_buffer_model->edit($id);
        
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
        $this->load->model($this->_pushBufferModel);
        $result = $this->push_buffer_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Push Content failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file push_buffer.php */
/* Location: ./application/controllers/dailypush/push_buffer.php */