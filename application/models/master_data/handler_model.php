<?php
/**
 * Description of Handler_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Handler_model extends SIA_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.name', 'a.description', 'a.date_created', 'a.status', 'a.id');
	$aColumnsX = array ('name', 'description', 'date_created', 'status', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreHandler;
    
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
            $this->dbConn->limit($this->dbConn->escape_str($iDisplayLength), $this->dbConn->escape_str($iDisplayStart));
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
                    $this->dbConn->order_by($aColumns[intval($this->dbConn->escape_str($iSortCol))], $this->dbConn->escape_str($sSortDir));
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
                    $this->dbConn->or_like($aColumns[$i], $this->dbConn->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbConn->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbCore->join($sTableJoin . ' b', 'b.id = a.role', 'left');
        $rResult = $this->dbConn->get($sTable . ' a');
    
        /**
         *  Data set length after filtering
         */
        $this->dbConn->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->dbConn->get()->row()->found_rows;
    
        /**
         *  Total data set length
         */
        $iTotal = $this->dbConn->count_all($sTable);
    
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
        $handler = $this->input->post('handler', true);
        $description = $this->input->post('description', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        $status = $this->input->post('status', true);
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'name' => $handler,
                'description' => $description,
                'date_created' => $dateCreated,
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbConn->insert($this->tblCoreHandler, $data);
        }
        else {
            $data = array (
                'name' => $handler,
                'description' => $description,
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbConn->where('id', $this->input->post('edit_id', true));
            $this->dbConn->update($this->tblCoreHandler, $data);
        }
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkHandlerExist($handler, $edit_handler = '') {
        $this->dbConn->select('id');
        $this->dbConn->where('name', $handler);
        
        if (!empty ($edit_handler)) {
            $this->dbConn->where('name !=', $edit_handler);
        }
        
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreHandler);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbConn->select('id, name, description, status');
        $this->dbConn->where('id', $id);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreHandler);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }

        return $result;
    }
    
    public function delete($id) {
        $this->dbConn->where('id', $id);
        $this->dbConn->limit(1);
        $query = $this->dbConn->delete($this->tblCoreHandler);
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file handler_model.php */
/* Location: ./application/models/master_data/handler_model.php */
