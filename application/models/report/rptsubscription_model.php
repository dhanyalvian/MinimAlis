<?php
/**
 * Description of Rptsubscription_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptsubscription_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.date_subscribed', 'a.adn', 'a.service', 'a.channel', 'a.operator', 'a.total', 'a.id');
	$aColumnsX = array ('date_subscribed', 'adn', 'service', 'channel', 'operator', 'total', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblReportSubscription;
    
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
        if (isset ($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->post('iSortCol_' . $i, true);
                $bSortable = $this->input->post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->post('sSortDir_' . $i, true);
    
                if ($bSortable == 'true') {
                    $this->dbReport->order_by($aColumns[intval($this->dbReport->escape_str($iSortCol))], $this->dbReport->escape_str($sSortDir));
                }
            }
        }
        
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
         *  Select Data
         */
        $this->dbReport->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbReport->join($sTableJoin . ' b', 'b.id = a.role', 'left');
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
        
        foreach ($rResult->result_array() as $aRow) {
            $row = array ();
            
            foreach ($aColumnsX as $col) {
                $row[] = $aRow[$col];
            }
    
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
}

/* End of file rptsubscription_model.php */
/* Location: ./application/models/report/rptsubscription_model.php */
