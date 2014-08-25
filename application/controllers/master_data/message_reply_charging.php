<?php
/**
 * Description of Message_reply_charging
 * 
 * @author  dhanyalvian@gmail.com
 */

class Message_reply_charging extends SIA_Controller {
    protected $_pageController = 'message_reply_charging';
    protected $_pageTitle = 'Message Reply/Charging';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/message_reply_charging';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'Message Reply/Charging', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'message_reply_charging');
    protected $_messageReplyChargingModel = 'master_data/message_reply_charging_model';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['combobox_service'] = $this->getComboboxService();
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_messageReplyChargingModel);
        $response = $this->message_reply_charging_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxService() {
        $this->load->model($this->_messageReplyChargingModel);
        return $this->message_reply_charging_model->getComboboxService();
    }
    
    public function getComboboxOperator() {
        $this->load->model($this->_messageReplyChargingModel);
        return $this->message_reply_charging_model->getComboboxOperator();
    }
    
    public function ajaxOperatorChange() {
        $serviceAdn = explode('_', $this->input->post('service_adn', true));
        $service = $serviceAdn[0];
        $adn = $serviceAdn[1];
        $operator = $this->input->post('operator', true);
        
        if (empty ($service) || empty ($adn) || empty ($operator)) {
            $this->_ajaxResponse();
        }
        
        $this->load->model($this->_messageReplyChargingModel);
        $result = $this->message_reply_charging_model->getComboboxCharging($service, $adn, $operator);
        
        if (is_array($result) && count($result) > 0) {
            $this->_ajaxStatus = true;
            $this->_ajaxData = $result;
        }
        
        $this->_ajaxResponse();
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('service_adn', 'operator', 'name', 'reply', 'charging');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('service_adn', 'Service', 'trim|required|xss_clean');
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_name_check');
            $this->form_validation->set_rules('reply', 'Reply', 'trim|required|xss_clean');
            $this->form_validation->set_rules('charging', 'Charging', 'trim|required|xss_clean');
        }
        else {
            //$this->form_validation->set_rules('edit_service_adn', 'Service', 'trim|required|xss_clean');
            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_name_check_edit');
            $this->form_validation->set_rules('reply', 'Reply', 'trim|required|xss_clean');
            $this->form_validation->set_rules('charging', 'Charging', 'trim|required|xss_clean');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_messageReplyChargingModel);
            $result = $this->message_reply_charging_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Message Reply/Charging successfully added.' : 'Message Reply/Charging successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'Message Reply/Charging failed saved.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function name_check($value) {
        $this->load->model($this->_messageReplyChargingModel);
        $serviceAdn = explode('_', $this->input->post('service_adn', true));
        $service = $serviceAdn[0];
        
        if (empty ($service)) {
            return false;
        }
        
        if ($this->message_reply_charging_model->checkNameExist($value, $service)) {
            $this->form_validation->set_message('name_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function name_check_edit($value) {
        $this->load->model($this->_messageReplyChargingModel);
        $serviceAdn = explode('_', $this->input->post('edit_service_adn', true));
        $service = $serviceAdn[0];
        $editName = $this->input->post('edit_name', true);
        
        if (empty ($service)) {
            return false;
        }
        
        if ($this->message_reply_charging_model->checkNameExist($value, $service, $editName)) {
            $this->form_validation->set_message('name_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_messageReplyChargingModel);
        $row = $this->message_reply_charging_model->edit($id);
        
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
        $this->load->model($this->_messageReplyChargingModel);
        $result = $this->message_reply_charging_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Message Reply/Charging failed';
        }
        
        $this->_ajaxResponse();
    }
    
    protected function parseOperatorAdn($value) {
        if (empty ($value)) {
            return array ();
        }
        
        $dataArr = explode('_', $value);
        
        return array (
            'operator' => $dataArr[0],
            'adn' => $dataArr[1]
        );
    }
}

/* End of file message_reply_charging.php */
/* Location: ./application/controllers/master_data/message_reply_charging.php */