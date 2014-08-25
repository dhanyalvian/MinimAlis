<?php
/**
 * Description of Roles
 * 
 * @author  dhanyalvian@gmail.com
 */

class Roles extends MY_Controller {
    protected $_pageController = 'roles';
    protected $_pageTitle = 'Roles Management';
    protected $_pageActive = 'settings';
    protected $_pageViews = 'settings/roles';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Settings', 'url' => ''),
    //    array ('title' => 'Roles Management', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'roles');
    protected $_rolesModule = 'settings/roles_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['role_resources'] = $this->getRoleResources();
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_rolesModule);
        $response = $this->roles_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    protected function getRoleResources() {
        $this->load->model($this->_rolesModule);
        $roles = $this->roles_model->getRoleResources();
        $result = array ();
        
        if (is_array($roles) && count($roles) > 0) {
            foreach ($roles as $role) {
                if ($role['parent'] == 0) {
                    $result[] = array (
                        'id' => $role['id'],
                        'name' => $role['title'],
                        'child' => $this->getRoleResourcesChild($role['id'], $roles)
                    );
                }
                
                continue;
            }
        }
        
        return $result;
    }
    
    protected function getRoleResourcesChild($parent, $roles) {
        $result = array ();
        
        foreach ($roles as $role) {
            if ($role['parent'] == $parent) {
                $result[] = array (
                    'id' => $role['id'],
                    'name' => $role['title']
                );
            }
            
            continue;
        }
        
        return $result;
    }

    public function save() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('role', 'role_resources');
        
        $this->form_validation->set_rules('role_resources', 'Role Resources', 'required');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('role', 'Role Name', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_role_check');
        }
        else {
            $this->form_validation->set_rules('role', 'Role Name', 'trim|required|min_length[3]|max_length[20]|xss_clean|callback_role_check_edit');
        }
        
        if ($this->form_validation->run()) {
            $this->load->model($this->_rolesModule);
            $result = $this->roles_model->save();
            
            if ($result) {
                $this->_ajaxStatus = true;
                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Role successfully added.' : 'Role successfully updated.';
            }
            else {
                $this->_ajaxStatus = false;
                $this->_ajaxMessage = 'New Role failed added.';
            }
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function role_check($value) {
        $this->load->model($this->_rolesModule);
        
        if ($this->roles_model->checkRoleExist($value)) {
            $this->form_validation->set_message('role_check', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function role_check_edit($value) {
        $this->load->model($this->_rolesModule);
        
        if ($this->roles_model->checkRoleExist($value, $this->input->post('edit_role', true))) {
            $this->form_validation->set_message('role_check_edit', 'The %s "' . $value . '" already exist');
            
            return false;
        }
        
        return true;
    }
    
    public function edit() {
        $id = $this->input->post('id', true);
        $this->load->model($this->_rolesModule);
        $row = $this->roles_model->edit($id);
        
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
        $this->load->model($this->_rolesModule);
        $result = $this->roles_model->delete($id);
        
        if ($result) {
            $this->_ajaxStatus = true;
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = 'Delete Role failed';
        }
        
        $this->_ajaxResponse();
    }
}

/* End of file roles.php */
/* Location: ./application/controllers/settings/roles.php */