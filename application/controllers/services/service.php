<?php
/**
 * Description of Service
 * 
 * @author  dhanyalvian@gmail.com
 */

class Service extends MY_Controller {
    protected $_pageController = 'service';
    protected $_pageTitle = 'Service';
    protected $_pageActive = 'services';
    protected $_pageViews = 'services/service';
    protected $_pageBreadcrumb = false;
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'service');
    protected $_serviceModel = 'services/service_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_serviceModel);
        $response = $this->service_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function getComboboxAdn() {
        $this->load->model($this->_serviceModel);
        return $this->service_model->getComboboxAdn();
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('service', 'shortname', 'adn');
        $action = $this->input->post('action', true);
        
        if ($action == 'add') {
            $this->form_validation->set_rules('service', 'Service Name', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_service_check');
            $this->form_validation->set_rules('shortname', 'Shortname', 'trim|required|max_length[50]|xss_clean|callback_shortname_check');
            $this->form_validation->set_rules('adn', 'ADN', 'trim|required|xss_clean');
        }
        else {
            $this->form_validation->set_rules('service', 'Service Name', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_service_check_edit');
            $this->form_validation->set_rules('shortname', 'Shortname', 'trim|required|max_length[50]|xss_clean|callback_shortname_check_edit');
            $this->form_validation->set_rules('adn', 'ADN', 'trim|required|xss_clean');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_serviceModel);
            $result = $this->service_model->save();
            $service = $this->input->post('service', true);
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? sprintf("New Service <b>%s</b> successfully added.", $service) : sprintf("Service <b>%s</b> successfully updated.", $service);
                
                if ($action == 'add') {
                    $goto = $this->input->post('goto', true);
                    
                    if ($goto) {
                        $this->_ajaxData = array (
                            'redirect' => true,
                            'redirect_url' => base_url() . 'services/keyword/index/' . $result
                        );
                    }
                }
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New Service failed added.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function service_check($value) {
        $this->load->model($this->_serviceModel);
        
        if ($this->service_model->checkServiceExist($value)) {
            $this->form_validation->set_message('service_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function service_check_edit($value) {
        $this->load->model($this->_serviceModel);
        
        if ($this->service_model->checkServiceExist($value, $this->input->post('edit_service', true))) {
            $this->form_validation->set_message('service_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function shortname_check($value) {
        $this->load->model($this->_serviceModel);
        
        if ($this->service_model->checkShortnameExist($value)) {
            $this->form_validation->set_message('shortname_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function shortname_check_edit($value) {
        $this->load->model($this->_serviceModel);
        
        if ($this->service_model->checkServiceExist($value, $this->input->post('edit_shortname', true))) {
            $this->form_validation->set_message('shortname_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_serviceModel);
        $row = $this->service_model->edit($id);
        
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
        $this->load->model($this->_serviceModel);
        $result = $this->service_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Service failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file service.php */
/* Location: ./application/controllers/services/service.php */