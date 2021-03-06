<?php
/**
 * Description of Test_number_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Test_number_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.msisdn', 'a.status', 'a.id');
	$aColumnsX = array ('msisdn', 'status', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreTestNumber;
    
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
            $this->dbCore->limit($this->dbCore->escape_str($iDisplayLength), $this->dbCore->escape_str($iDisplayStart));
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
                    $this->dbCore->order_by($aColumns[intval($this->dbCore->escape_str($iSortCol))], $this->dbCore->escape_str($sSortDir));
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
                    $this->dbCore->or_like($aColumns[$i], $this->dbCore->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbCore->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbCore->join($sTableJoin . ' b', 'b.id = a.role', 'left');
        $rResult = $this->dbCore->get($sTable . ' a');
    
        /**
         *  Data set length after filtering
         */
        $this->dbCore->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->dbCore->get()->row()->found_rows;
    
        /**
         *  Total data set length
         */
        $iTotal = $this->dbCore->count_all($sTable);
    
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

    public function save() {
        $msisdn = $this->input->post('msisdn', true);
        $status = $this->input->post('status', true);
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'msisdn' => $msisdn,
                'status' => $status
            );
            $this->dbCore->insert($this->tblCoreTestNumber, $data);
        }
        else {
            $data = array (
                'msisdn' => $msisdn,
                'status' => $status
            );
            $this->dbCore->where('id', $this->input->post('edit_id', true));
            $this->dbCore->update($this->tblCoreTestNumber, $data);
        }
        
        if ($this->dbCore->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkMsisdnExist($msisdn, $edit_msisdn = '') {
        $this->dbCore->select('id');
        $this->dbCore->where('msisdn', $msisdn);
        
        if (!empty ($edit_msisdn)) {
            $this->dbCore->where('msisdn !=', $edit_msisdn);
        }
        
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreTestNumber);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbCore->select('id, msisdn, status');
        $this->dbCore->where('id', $id);
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreTestNumber);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }

        return $result;
    }
    
    public function delete($id) {
        $this->dbCore->where('id', $id);
        $this->dbCore->limit(1);
        $query = $this->dbCore->delete($this->tblCoreTestNumber);
        
        if ($this->dbCore->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file test_number_model.php */
/* Location: ./application/models/master_data/test_number_model.php */
