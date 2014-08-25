<?php
/**
 * Description of Adn
 * 
 * @author  dhanyalvian@gmail.com
 */

class Adn extends MY_Controller {
    protected $_pageController = 'adn';
    protected $_pageTitle = 'ADN';
    protected $_pageActive = 'master_data';
    protected $_pageViews = 'master_data/adn';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Master Data', 'url' => ''),
    //    array ('title' => 'ADN', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'adn');
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        //$this->_data['combobox_roles'] = $this->getComboboxRoles();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model('master_data/adn_model');
        $response = $this->adn_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('adn');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('adn', 'ADN', 'trim|required|numeric|min_length[3]|max_length[10]|xss_clean|callback_adn_check');
        }
        else {
            $this->form_validation->set_rules('adn', 'ADN', 'trim|required|numeric|min_length[3]|max_length[10]|xss_clean|callback_adn_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model('master_data/adn_model');
            $result = $this->adn_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New ADN successfully inserted.' : 'ADN successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New ADN failed inserted.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function adn_check($value) {
        $this->load->model('master_data/adn_model');
        
        if ($this->adn_model->checkAdnExist($value)) {
            $this->form_validation->set_message('adn_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function adn_check_edit($value) {
        $this->load->model('master_data/adn_model');
        
        if ($this->adn_model->checkAdnExist($value, $this->input->post('edit_adn', true))) {
            $this->form_validation->set_message('adn_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model('master_data/adn_model');
        $row = $this->adn_model->edit($id);
        
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
        $this->load->model('master_data/adn_model');
        $result = $this->adn_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete ADN failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file adn.php */
/* Location: ./application/controllers/master_data/adn.php */