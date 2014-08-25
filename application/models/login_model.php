<?php
/**
 * Description of Login_model
 * 
 * @author  dhanyalvian@gmail.com
 */
class Login_model extends SIA_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function authentication($username, $password) {
        $result = array ();
        $where = array (
            'username' => $username,
            'password' => md5($password),
            'status' => 1
        );
        
        $this->dbConn->select('userid, fullname, role');
        $this->dbConn->where($where);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCmsUsers);

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
}

/* End of file Navigation_Model.php */
/* Location: ./application/models/Navigation_Model.php */
