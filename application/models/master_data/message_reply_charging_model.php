<?php
/**
 * Description of Message_reply_charging_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Message_reply_charging_model extends SIA_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
    /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ("CONCAT (b.name, ' (', b.adn, ')') service", "CONCAT (d.name, ' (', d.long_name, ')') operator", "a.name", "a.reply", "FORMAT(c.gross, 2) charging", "a.status", "a.id");
	$aColumnsX = array ('service', 'operator', 'name', 'reply', 'charging', 'status', 'id');
        $aColumnsY = array ('service', 'operator', 'a.name', 'a.reply', 'a.charging', 'a.status', 'a.id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreServiceSetting;
	$sTableJoin = $this->tblCoreService;
	$sTableJoin2 = $this->tblCoreCharging;
	$sTableJoin3 = $this->tblCoreOperator;
    
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
                    $this->dbConn->order_by($aColumnsY[intval($this->dbConn->escape_str($iSortCol))], $this->dbConn->escape_str($sSortDir));
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
                    $this->dbPush->or_like($aColumnsY[$i], $this->dbPush->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbConn->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->dbConn->join($sTableJoin . ' b', 'b.id = a.service_id', 'left');
        $this->dbConn->join($sTableJoin2 . ' c', 'c.id = a.charging_id', 'left');
        $this->dbConn->join($sTableJoin3 . ' d', 'd.id = c.operator', 'left');
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

    public function getComboboxService() {
        $this->dbConn->select('id, name, adn');
        $this->dbConn->order_by('name', 'asc'); 
        $query = $this->dbConn->get($this->tblCoreService);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxOperator() {
        $this->dbConn->select('id, name, long_name');
        $this->dbConn->order_by('name', 'asc');
        $query = $this->dbConn->get($this->tblCoreOperator);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxCharging($service, $adn, $operator) {
        $this->dbConn->select('id, sender_type, message_type, FORMAT(gross, 2) gross', false);
        $this->dbConn->where('operator', $operator);
        $this->dbConn->where('adn', $adn);
        $this->dbConn->order_by('sender_type, message_type, gross', 'asc');
        $query = $this->dbConn->get($this->tblCoreCharging);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function save() {
        $serviceAdn = explode('_', $this->input->post('service_adn', true));
        $service = $serviceAdn[0];
        $name = $this->input->post('name', true);
        $reply = $this->input->post('reply', true);
        $charging = $this->input->post('charging', true);
        $status = $this->input->post('status', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'service_id' => $service,
                'name' => $name,
                'reply' => $reply,
                'charging_id' => $charging,
                'status' => $status,
                'created_at' => $dateCreated,
                'updated_at' => $dateModified
            );
            $this->dbConn->insert($this->tblCoreServiceSetting, $data);
        }
        else {
            $data = array (
                'name' => $name,
                'reply' => $reply,
                'charging_id' => $charging,
                'status' => $status,
                'updated_at' => $dateModified
            );
            $this->dbConn->where('id', $this->input->post('edit_id', true));
            $this->dbConn->update($this->tblCoreServiceSetting, $data);
        }
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkNameExist($name, $service, $edit_name = '') {
        $this->dbConn->select('id');
        $this->dbConn->where('name', $name);
        $this->dbConn->where('service_id', $service);
        
        if (!empty ($edit_name)) {
            $this->dbConn->where('name !=', $edit_name);
        }
        
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreServiceSetting);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbConn->select('a.id, a.service_id, b.adn, c.operator, a.name, a.reply, a.charging_id, a.status');
        $this->dbConn->join($this->tblCoreService . ' b', 'b.id = a.service_id', 'left');
        $this->dbConn->join($this->tblCoreCharging . ' c', 'c.id = a.charging_id', 'left');
        $this->dbConn->where('a.id', $id);
        $this->dbConn->limit(1);
        $query = $this->dbConn->get($this->tblCoreServiceSetting . ' a');
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
        $query = $this->dbConn->delete($this->tblCoreServiceSetting);
        
        if ($this->dbConn->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file message_reply_charging_model.php */
/* Location: ./application/models/master_data/message_reply_charging_model.php */
