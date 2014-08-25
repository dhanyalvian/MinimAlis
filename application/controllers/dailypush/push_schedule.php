<?php
/**
 * Description of Push_schedule
 * 
 * @author  dhanyalvian@gmail.com
 */

class Push_schedule extends MY_Controller {
    protected $_pageController = 'push_schedule';
    protected $_pageTitle = 'Push Schedule';
    protected $_pageActive = 'dailypush';
    protected $_pageViews = 'dailypush/push_schedule';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Daily Push', 'url' => ''),
    //    array ('title' => 'Push Schedule', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables', 'bootstrap-datetimepicker.min');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'moment', 'bootstrap-datetimepicker.min', 'push_schedule');
    protected $_pushScheduleModel = 'dailypush/push_schedule_model';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['today'] = date($this->dateTimeFormatPhp);
        $this->_data['combobox_service'] = $this->getComboboxService();
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->_data['combobox_recurring_type'] = $this->getComboboxReccuringType();
        $this->_data['combobox_handler_file'] = $this->getComboboxHandlerFile();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_pushScheduleModel);
        $response = $this->push_schedule_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxService() {
        $this->load->model($this->_pushScheduleModel);
        return $this->push_schedule_model->getComboboxService();
    }
    
    public function getComboboxOperator() {
        $this->load->model($this->_pushScheduleModel);
        return $this->push_schedule_model->getComboboxOperator();
    }
    
    public function getComboboxAdn() {
        $this->load->model($this->_pushScheduleModel);
        return $this->push_schedule_model->getComboboxAdn();
    }
    
    private function getComboboxReccuringType() {
        $result = array (
            1 => 'Daily',
            2 => 'Weekly'
        );
        
        return $result;
    }
    
    private function getComboboxHandlerFile() {
        $result = array ('default', 'custom');
        
        return $result;
    }

    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('content_label', 'content_select', 'price', 'push_time', 'handler_file_custom');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('content_label', 'Content Label', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('content_select', 'Content Select', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('push_time', 'Push Time', 'trim|required|min_length[1]|xss_clean|callback_push_time_check');
            
            if ($this->input->post('handler_file', true) == 'custom') {
                $this->form_validation->set_rules('handler_file_custom', 'Custom Handler File', 'trim|required|min_length[1]|xss_clean');
            }
        }
        else {
            $this->form_validation->set_rules('content_label', 'Content Label', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('content_select', 'Content Select', 'trim|required|min_length[1]|xss_clean');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('push_time', 'Push Time', 'trim|required|min_length[1]|xss_clean|callback_push_time_check');
            
            if ($this->input->post('handler_file', true) == 'custom') {
                $this->form_validation->set_rules('handler_file_custom', 'Custom Handler File', 'trim|required|min_length[1]|xss_clean');
            }
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_pushScheduleModel);
            $result = $this->push_schedule_model->save();
            
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
    
    public function push_time_check($value) {
        $dateCheck = DateTime::createFromFormat($this->dateTimeFormatPhp, $value);
        
        if (!$dateCheck) {
            $this->form_validation->set_message('push_time_check', 'The %s "' . $value . '" is invalid format date');
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_pushScheduleModel);
        $row = $this->push_schedule_model->edit($id);
        
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
        $this->load->model($this->_pushScheduleModel);
        $result = $this->push_schedule_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Push Schedule failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file push_schedule.php */
/* Location: ./application/controllers/dailypush/push_schedule.php */