<?php
/**
 * Description of Password_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Password_model extends MY_Model {
    protected $_username = null;
    
    public function __construct() {
        parent::__construct();
        
        $this->_username = $this->session->userdata('username');
    }

    public function save() {
        $newPassword = $this->input->post('new_password', true);
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * Save -> Update
         */
        $data = array (
            'password' => md5($newPassword),
            'date_modified' => $dateModified
        );
        $this->dbCms->where('username', $this->_username);
        $this->dbCms->update($this->tblCmsUsers, $data);
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkPasswordExist($password) {
        $this->dbCms->select('userid');
        $this->dbCms->where('username', $this->_username);
        $this->dbCms->where('password', md5($password));
        $this->dbCms->limit(1);
        $query = $this->dbCms->get($this->tblCmsUsers);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
}

/* End of file password_model.php */
/* Location: ./application/models/profile/password_model.php */
