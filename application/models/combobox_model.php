<?php
/**
 * Description of Combobox_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Combobox_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getComboboxAdn() {
        $where = array ('status' => 1);
        $this->dbCore->select('id, name');
        $this->dbCore->where($where);
        $this->dbCore->order_by('name', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreAdn);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxOperator() {
        $this->dbCore->select('id, name, long_name');
        $this->dbCore->order_by('name', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreOperator);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxService() {
        $this->dbCore->select('id, name, adn');
        $this->dbCore->order_by('name', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreService);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxCharging() {
        $this->dbCore->select('id, operator, adn, charging_id, gross');
        $query = $this->dbCore->get($this->tblCoreCharging);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxHandler() {
        $where = array ('status' => 1);
        $this->dbCore->select('id, name');
        $this->dbCore->where($where);
        $this->dbCore->order_by('name', 'asc');
        $query = $this->dbCore->get($this->tblCoreHandler);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxModule() {
        $this->dbCore->select('id, name');
        $this->dbCore->where('status', 1);
        $this->dbCore->order_by('name', 'asc');
        $query = $this->dbCore->get($this->tblCoreModule);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxAttribute() {
        $this->dbCore->select('id, name');
        $this->dbCore->order_by('name', 'asc');
        $query = $this->dbCore->get($this->tblCoreAttribute);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
}

/* End of file combobox_model.php */
/* Location: ./application/models/combobox_model.php */
