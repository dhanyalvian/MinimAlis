<?php
/**
 * Description of Rptsummary_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptsummary_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getReportService($request) {
        $this->dbReport->select('id, sumdate, subject, delivery_status, price, total');
        $where = "str_to_date(sumdate,'%Y-%m') = str_to_date('" . $request['tdate'] . "','%Y-%m')";
        $this->dbReport->where($where);
        
        if (!empty ($request['adn'])) {
            $this->dbReport->where('adn', $request['adn']);
        }
        
        if (!empty ($request['operator'])) {
            $this->dbReport->where('operator_id', $request['operator']);
        }
        
        if (!empty ($request['service'])) {
            $this->dbReport->where('LOWER(service)', strtolower($request['service']));
        }
        
        $this->dbReport->order_by('subject', 'ASC');
        $this->dbReport->order_by('delivery_status', 'ASC');
        $this->dbReport->order_by('sumdate', 'DESC');
        $this->dbReport->group_by('sumdate');
        $this->dbReport->group_by('subject');
        $this->dbReport->group_by('delivery_status');
        $query = $this->dbReport->get($this->tblReportService);
        //echo $this->dbReport->last_query();exit;
        $result = array ();
        
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }
        }

        return $result;
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
}

/* End of file rptsummary_model.php */
/* Location: ./application/models/report/rptsummary_model.php */
