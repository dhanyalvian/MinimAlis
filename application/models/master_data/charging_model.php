<?php
/**
 * Description of Charging_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Charging_model extends SIA_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('b.name', 'a.adn', 'a.charging_id', 'a.gross', 'a.netto', 'a.sender_type', 'a.message_type', 'a.id');
	$aColumnsX = array ('name', 'adn', 'charging_id', 'gross', 'netto', 'sender_type', 'message_type', 'id');
        $aColumnsY = array ('b.name', 'a.adn', 'a.charging_id', 'a.gross', 'a.netto', 'a.sender_type', 'a.message_type', 'a.id');
        
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreCharging;
        $sTableJoin = $this->tblCoreOperator;
    
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
            for ($i = 0; $i < count($aColumnsY); $i++) {
                $bSearchable = $this->input->post('bSearchable_' . $i, true);
                
                // Individual column filtering
                if (isset ($bSearchable) && $bSearchable == 'true') {
                    $this->dbConn->or_like($aColumnsY[$i], $this->dbConn->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbConn->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->dbConn->join($sTableJoin . ' b', 'b.id = a.operator', 'left');
        $rResult = $this->dbConn->get($sTable . ' a');
//        echo $this->dbConn->last_query();
//        exit;
    
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
    
    public function getComboboxOperator() {
        $this->dbConn->select('id, name, long_name');
        $this->dbConn->order_by('name', 'asc'); 
        $query = $this->dbConn->get($this->tblCoreOperator);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }
    
    public function getComboboxAdn() {
        $where = array ('status' => 1);
        $this->dbConn->select('id, name');
        $this->dbConn->where($where);
        $this->dbConn->order_by('name', 'asc'); 
        $query = $this->dbConn->get($this->tblCoreAdn);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
        }

        return $result;
    }

    public function save() {
        $operator = $this->input->post('operator', true);
        $adn = $this->input->post('adn', true);
        $charging = $this->input->post('charging', true);
        $gross = $this->input->post('gross', true);
        $netto = $this->input->post('netto', true);
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $senderType = $this->input->post('sender_type', true);
        $messageType = $this->input->post('message_type', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'operator' => $operator,
                'adn' => $adn,
                'charging_id' => $charging,
                'gross' => $gross,
                'netto' => $netto,
                'username' => $username,
                'password' => $password,
                'sender_type' => $senderType,
                'message_type' => $messageType,
                'date_created' => $dateCreated,
                'date_modified' => $dateModified
            );
            $this->dbConn->insert($this->tblCoreCharging, $data);
        }
        else {
            $data = array (
                'operator' => $operator,
                'adn' => $adn,
                'charging_id' => $charging,
                'gross' => $gross,
                'netto' => $netto,
                'username' => $username,
                'password' => $password,
                'sender_type' => $senderType,
                'message_type' => $messageType,
                'date_modified' => $dateModified
            );
            $this->dbConn->where('id', $this->input->post('edit_id', true));
            $this->dbConn->update($this->tblCoreCharging, $data);
        }
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkChargingExist($chargingId, $editChargingId = '') {
        $this->dbConn->select('id');
        $this->dbConn->where('charging_id', $chargingId);
        
        if (!empty ($editChargingId)) {
            $this->dbConn->where('charging_id !=', $editChargingId);
        }
        
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreCharging);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbConn->select('id, operator, adn, charging_id, gross, netto, username, password, sender_type, message_type');
        $this->dbConn->where('id', $id);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreCharging);
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
        $query = $this->dbConn->delete($this->tblCoreCharging);
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file charging_model.php */
/* Location: ./application/models/master_data/charging_model.php */
