<?php
/**
 * Description of Charging
 * 
 * @author  dhanyalvian@gmail.com
 */

class Charging extends SIA_Controller {
    protected $_pageController = 'charging';
    protected $_pageTitle = 'Charging';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/charging';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'Charging', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'charging');
    protected $_chargingModel = 'master_data/charging_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->_data['combobox_sender_type'] = $this->config->item('charging_sender_type');
        $this->_data['combobox_message_type'] = $this->config->item('charging_message_type');
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_chargingModel);
        $response = $this->charging_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxOperator() {
        $this->load->model($this->_chargingModel);
        return $this->charging_model->getComboboxOperator();
    }
    
    public function getComboboxAdn() {
        $this->load->model($this->_chargingModel);
        return $this->charging_model->getComboboxAdn();
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('charging', 'gross', 'netto', 'username', 'password', 'sender_type', 'message_type');
        $this->form_validation->set_rules('charging', 'Charging ID', 'trim|min_length[3]|max_length[50]|alpha_dash|xss_clean');
        $this->form_validation->set_rules('gross', 'Gross', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('netto', 'Netto', 'trim|required|numeric|xss_clean');
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('sender_type', 'Sender Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('message_type', 'Message Type', 'trim|required|xss_clean');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('charging', 'Charging ID', 'trim|required|min_length[3]|max_length[50]|alpha_dash|xss_clean|callback_charging_check');
        }
        else {
            $this->form_validation->set_rules('charging', 'Charging ID', 'trim|required|min_length[3]|max_length[50]|alpha_dash|xss_clean|callback_charging_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_chargingModel);
            $result = $this->charging_model->save();
            
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
    
    public function charging_check($value) {
        $this->load->model($this->_chargingModel);
        
        if ($this->charging_model->checkChargingExist($value)) {
            $this->form_validation->set_message('charging_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function module_check_edit($value) {
        $this->load->model($this->_chargingModel);
        
        if ($this->charging_model->checkModuleExist($value, $this->input->post('edit_module', true))) {
            $this->form_validation->set_message('module_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_chargingModel);
        $row = $this->charging_model->edit($id);
        
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
        $this->load->model($this->_chargingModel);
        $result = $this->charging_model->delete($id);
        
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

/* End of file charging.php */
/* Location: ./application/controllers/master_data/charging.php */