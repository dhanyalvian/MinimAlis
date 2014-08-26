<?php
/**
 * Description of Navigation_Model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Navigation_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getNavigationData($role, $parent = 0) {
        $role = 1; // hardcode
        $result = array ();
        $where = array ('status' => 1);
        
        if ($parent != 0) {
            $where = array ('status' => 1, 'parent' => $parent);
        }
        
        $roleIds = $this->getRoleId($role);

        $this->dbConn->select('id, controller, title, url, parent, display, icon');
        
        if (is_array($roleIds)) {
            $this->dbConn->where_in('id', $roleIds);
        }
        
        $this->dbConn->where($where);
        $this->dbConn->order_by('sort, id');
        $query = $this->dbConn->get($this->tblNavigation);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    protected function getRoleId($role) {
        $result = array ();
        $where = array (
            'status' => '1',
            'id' => $role
        );
        $this->dbConn->select('id, module');
        $this->dbConn->where($where);
        $query = $this->dbConn->get($this->tblRoles);
        
        if ($query->num_rows() > 0) {
            $rows = $query->result();
            
            if ($rows[0]->module == '*') {
                $result = $rows[0]->module;
            }
            else {
                $result = explode(',', $rows[0]->module);
            }
        }

        return $result;
    }
    
    public function getParent($controller) {
        $result = array ('id' => null, 'title' => null, 'url' => null);
        $where = array ('a.controller' => strtolower($controller));
        $this->dbConn->select('a.parent id, b.title, b.url');
        $this->dbConn->join($this->tblNavigation . ' b', 'b.id = a.parent', 'left');
        $this->dbConn->where($where);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblNavigation . ' a');
        //echo $this->dbConn->last_query();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }
        
        return $result;
    }
    
    public function getPageTitle($controller) {
        $result = '';
        $where = array ('controller' => strtolower($controller));
        $this->dbConn->select('title');
        
        $this->dbConn->where($where);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblNavigation);
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0]['title'];
        }
        
        return $result;
    }
}

/* End of file Navigation_Model.php */
/* Location: ./application/models/Navigation_Model.php */
