<?php
/**
 * Description of Motraffic_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Motraffic_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * $interval
     *  - yesterday
     *  - lastsevenday
     */
    public function getTodayMo($interval = '') {
        $today = date('Y-m-d');
        
        if ($interval == 'today') {
            //$this->dbReport->where('DATE(mo_date)', $today);
            $where = sprintf("DATE(mo_date) = '%s'", $today);
        }
        else if ($interval == 'yesterday') {
            //$where = sprintf("DATE(mo_date) >= ('%s' - INTERVAL 1 DAY)", $today);
            $where = sprintf("DATE(mo_date) = ('%s' - INTERVAL 1 DAY)", $today);
        }
        else if ($interval == 'lastsevenday') {
            $where = sprintf("DATE(mo_date) >= DATE_SUB('%s', INTERVAL 7 DAY)", $today);
            //$where = sprintf("DATE(mo_date) BETWEEN '%s' and DATE_SUB(%s, INTERVAL 7 DAY)", $today, $today);
        }
        
        if ($where != '') {
            $this->dbReport->where($where);
        }
        
        $this->dbReport->select('COUNT(id) total');
        $query = $this->dbReport->get($this->tblReportMo);
        $result = 0;
        
        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();
            $result = $row[0]['total'];
        }
        
        return (int) $result;
    }
    
    public function getSeriesData($lastMonths) {
        $today = date('Y-m-d');
        $where = "mo_date >= DATE_FORMAT(DATE_SUB(STR_TO_DATE('" . $today . "', '%Y-%m-%d'), INTERVAL " . ($lastMonths - 1) . " MONTH), '%Y-%m-01')";
        
        $this->dbReport->select("DATE_FORMAT(mo_date, '%b-%Y') month_date, COUNT(id) total", false);
        $this->dbReport->where($where);
        $this->dbReport->order_by('month_date');
        $this->dbReport->group_by('month_date');
        $query = $this->dbReport->get($this->tblReportMo);
        $result = array ();
        
        if ($query && $query->num_rows() > 0) {
            $result = $query->result_array();
        }
        
        return $result;
    }
    
    /**
     * $interval
     *  - lastmonth
     *  - lastsixmonth
     */
    public function getTotalMo($interval = '') {
        $today = date('Y-m-d');
        $where = '';
        
        if ($interval == 'lastmonth') {
            $where = sprintf("DATE(mo_date) >= DATE_SUB('%s', INTERVAL 1 MONTH)", $today);
        }
        else if ($interval == 'lastsixmonth') {
            $where = sprintf("DATE(mo_date) >= DATE_SUB('%s', INTERVAL 6 MONTH)", $today);
        }
        
        if ($where != '') {
            $this->dbReport->where($where);
        }
        
        $this->dbReport->select('COUNT(id) total');
        $query = $this->dbReport->get($this->tblReportMo);
        $result = 0;
        
        if ($query && $query->num_rows() > 0) {
            $row = $query->result_array();
            $result = $row[0]['total'];
        }
        
        return (int) $result;
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ("a.msisdn", "a.operator", "a.adn", "a.service", "a.rawsms", "a.req_type", "a.channel", "DATE_FORMAT(a.mo_date, '%d-%b-%Y') mo_date", "a.id");
	$aColumnsX = array ('msisdn', 'operator', 'adn', 'service', 'rawsms', 'req_type', 'channel', 'mo_date', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblReportMo;
    
        $iDisplayStart = $this->input->post('iDisplayStart', true);
        $iDisplayLength = $this->input->post('iDisplayLength', true);
        $iSortCol_0 = $this->input->post('iSortCol_0', true);
        $iSortingCols = $this->input->post('iSortingCols', true);
        $sSearch = $this->input->post('sSearch', true);
        $sEcho = $this->input->post('sEcho', true);
    
        /**
         *  Pagination
         */
        if (isset ($iDisplayStart) && $iDisplayLength != '-1') {
            $this->dbReport->limit($this->dbReport->escape_str($iDisplayLength), $this->dbReport->escape_str($iDisplayStart));
        }
        
        /**
         *  Ordering
         */
        //if (isset ($iSortCol_0)) {
        //    for ($i = 0; $i < intval($iSortingCols); $i++) {
        //        $iSortCol = $this->input->post('iSortCol_' . $i, true);
        //        $bSortable = $this->input->post('bSortable_' . intval($iSortCol), true);
        //        $sSortDir = $this->input->post('sSortDir_' . $i, true);
    //
        //        if ($bSortable == 'true') {
        //            $this->dbReport->order_by($aColumns[intval($this->dbReport->escape_str($iSortCol))], $this->dbReport->escape_str($sSortDir));
        //        }
        //    }
        //}
        
        /**
         *  Filtering
         *  NOTE this does not match the built-in DataTables filtering which does it
         *  word by word on any field. It's possible to do here, but concerned about efficiency
         *  on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset ($sSearch) && !empty ($sSearch)) {
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->post('bSearchable_' . $i, true);
                
                // Individual column filtering
                if (isset ($bSearchable) && $bSearchable == 'true') {
                    $this->dbReport->or_like($aColumns[$i], $this->dbReport->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         * Custom Filtering 
         */
        $startDate = $this->input->post('start_date', true);
        $endDate = $this->input->post('end_date', true);
        $adn = $this->input->post('adn', true);
        $operator = $this->input->post('operator', true);
        $service = $this->input->post('service', true);
        $moType = $this->input->post('motype', true);
        $msisdn = $this->input->post('msisdn', true);
        $sms = $this->input->post('sms', true);
        
        if (!empty ($startDate) && !empty ($endDate)) {
            $where = "DATE(a.mo_date) BETWEEN STR_TO_DATE('" . $startDate . "', '%d-%b-%Y') AND STR_TO_DATE('" . $endDate . "', '%d-%b-%Y')";
            $this->dbReport->where($where);
        }
        
        if (!empty ($adn)) {
            $this->dbReport->where('a.adn', $adn);
        }
        
        if (!empty ($operator)) {
            $this->dbReport->where('a.operator', $operator);
        }
        
        if (!empty ($service)) {
            $this->dbReport->where('a.service', $service);
        }
        
        if (!empty ($moType)) {
            $this->dbReport->where('a.req_type', $moType);
        }
        
        if (!empty ($msisdn)) {
            $this->dbReport->like('a.msisdn', $msisdn);
        }
        
        if (!empty ($sms)) {
            $this->dbReport->where('a.rawsms', $sms);
        }
        
        /**
         *  Select Data
         */
        $this->dbReport->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->dbReport->order_by('DATE(mo_date)', 'DESC');
        $rResult = $this->dbReport->get($sTable . ' a');
    
        /**
         *  Data set length after filtering
         */
        $this->dbReport->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->dbReport->get()->row()->found_rows;
    
        /**
         *  Total data set length
         */
        $iTotal = $this->dbReport->count_all($sTable);
    
        /**
         *  Output
         */
        $output = array (
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array ()
        );
        $operators = $this->getOperator();
        
        foreach ($rResult->result_array() as $aRow) {
            $row = array ();
            
            foreach ($aColumnsX as $col) {
                if ($col == 'operator') {
                    $row[] = $this->collectGridDataTables($operators, $aRow[$col]);
                }
                else {
                    $row[] = $aRow[$col];
                }
            }
    
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    protected function collectGridDataTables($operators, $operatorId) {
        if (is_array($operators) && count($operators) > 0) {
            foreach ($operators as $operator) {
                if ($operatorId == $operator['id']) {
                    return $operator['long_name'];
                    break;
                }
            }
        }
        
        return '';
    }

    protected function getOperator() {
        $this->dbCore->select('id, long_name');
        $this->dbCore->order_by('id', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreOperator);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
}

/* End of file motraffic_model.php */
/* Location: ./application/models/motraffic_model.php */
