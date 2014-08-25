<?php
/**
 * Description of Config_Model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Config_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getConfigData($filter) {
        $this->dbConn->select('value');
        $this->dbConn->where('path', $filter);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblConfigData);
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0]->value;
        }

        return null;
    }
}

/* End of file Config_Model.php */
/* Location: ./application/models/Config_Model.php */
