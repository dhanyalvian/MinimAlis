<?php
/**
 * Description of Service_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Service_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.name', 'a.shortname', 'a.adn', 'a.date_created', 'a.id');
	$aColumnsX = array ('name', 'shortname', 'adn', 'date_created', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreService;
        //$sTableJoin = $this->tblHandler;
    
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
            for ($i = 0; $i < count($aColumnsX); $i++) {
                $bSearchable = $this->input->post('bSearchable_' . $i, true);
                
                // Individual column filtering
                if (isset ($bSearchable) && $bSearchable == 'true') {
                    $this->dbCore->or_like($aColumnsY[$i], $this->dbCore->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbCore->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbCore->join($sTableJoin . ' b', 'b.id = a.handler', 'left');
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
    
    public function getComboboxAdn() {
        $where = array ('status' => 1);
        $this->dbCore->select('id, name');
        $this->dbCore->where($where);
        $this->dbCore->order_by('name', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreAdn);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function save() {
        $action = $this->input->post('action', true);
        $service = $this->input->post('service', true);
        $shortname = $this->input->post('shortname', true);
        $adn = $this->input->post('adn', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * Save -> Insert or Update
         */
        if ($action == 'add') {
            $data = array (
                'name' => $service,
                'shortname' => $shortname,
                'adn' => $adn,
                'date_created' => $dateCreated,
                'date_modified' => $dateModified
            );
            $this->dbCore->insert($this->tblCoreService, $data);
        }
        else {
            $data = array (
                'name' => $service,
                'shortname' => $shortname,
                'adn' => $adn,
                'date_modified' => $dateModified
            );
            $this->dbCore->where('id', $this->input->post('edit_id', true));
            $this->dbCore->update($this->tblCoreService, $data);
        }
        
        if ($this->dbCore->affected_rows() > 0) {
            if ($action == 'add') {
                return $this->dbCore->insert_id();
            }
            
            return true;
        }
        
        return false;
    }
    
    public function checkServiceExist($service, $edit_service = '') {
        $this->dbCore->select('id');
        $this->dbCore->where('name', $service);
        
        if (!empty ($edit_service)) {
            $this->dbCore->where('name !=', $edit_service);
        }
        
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreService);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function checkShortnameExist($shortname, $edit_shortname = '') {
        $this->dbCore->select('id');
        $this->dbCore->where('shortname', $shortname);
        
        if (!empty ($edit_shortname)) {
            $this->dbCore->where('shortname !=', $edit_shortname);
        }
        
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreService);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbCore->select('id, name, shortname, adn');
        $this->dbCore->where('id', $id);
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreService);
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
        $query = $this->dbCore->delete($this->tblCoreService);
        
        if ($this->dbCore->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file service_model.php */
/* Location: ./application/models/services/service_model.php */
