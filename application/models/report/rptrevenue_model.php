<?php
/**
 * Description of Rptrevenue_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptrevenue_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getReportService($request) {
        $this->dbReport->select('id, sumdate, subject, delivery_status, operator_id, (price * total) price, total');
        $where = "str_to_date(sumdate,'%Y-%m') = str_to_date('" . $request['tdate'] . "','%Y-%m')";
        $this->dbReport->where($where);
        
        if (!empty ($request['adn'])) {
            $this->dbReport->where('adn', $request['adn']);
        }
        
        if (!empty ($request['operator'])) {
            $this->dbReport->where('operator_id', $request['operator']);
        }
        
        $this->dbReport->order_by('subject', 'ASC');
        $this->dbReport->order_by('delivery_status', 'ASC');
        $this->dbReport->order_by('operator_id', 'ASC');
        $this->dbReport->order_by('sumdate', 'DESC');
        $this->dbReport->group_by('sumdate');
        $this->dbReport->group_by('subject');
        $this->dbReport->group_by('delivery_status');
        $this->dbReport->group_by('operator_id');
        $query = $this->dbReport->get($this->tblReportService);
        $result = array ();
        
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }
        }

        return $result;
    }
}

/* End of file rptrevenue_model.php */
/* Location: ./application/models/report/rptrevenue_model.php */
