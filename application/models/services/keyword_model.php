<?php
/**
 * Description of Keyword_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Keyword_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTablesOld() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ("a.pattern", "CONCAT (b.name, ' (', b.long_name, ')') operator", "a.handler", "a.status", "a.id");
	$aColumnsX = array ('pattern', 'operator', 'handler', 'status', 'id');
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCoreMechanism;
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
                    $this->dbCore->or_like($aColumnsX[$i], $this->dbCore->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbCore->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->dbCore->join($sTableJoin . ' b', 'b.id = a.operator_id', 'left');
        $this->dbCore->where('a.service_id', $this->input->post('service_id', true));
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
    
    public function getGridDataTables($serviceId) {
        $this->dbCore->select('service_id, pattern');
        $this->dbCore->where('service_id', $serviceId);
        $this->dbCore->group_by('pattern');
        $query = $this->dbCore->get($this->tblCoreMechanism);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getGridDataTablesChild($serviceId) {
        $this->dbCore->select('a.id, a.service_id, a.pattern, a.operator_id, b.name operator_name');
        $this->dbCore->join($this->tblCoreOperator . ' b', 'b.id = a.operator_id', 'left');
        $this->dbCore->where('service_id', $serviceId);
        $this->dbCore->group_by('pattern, operator_id, operator_name');
        $query = $this->dbCore->get($this->tblCoreMechanism . ' a');
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function getComboboxService($serviceId) {
        $where = array ('id' => $serviceId);
        $this->dbCore->select('id, name, adn');
        $this->dbCore->where($where);
        $this->dbCore->order_by('name', 'asc');
        $this->dbCore->limit(1);
        $query = $this->dbCore->get($this->tblCoreService);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function deleteKeywordByPattern($serviceId, $pattern) {
        $this->dbCore->trans_begin();
        $deleteStatus = false;
        $mechanismData = $this->getMechanism($serviceId, $pattern);
        
        if (is_array($mechanismData)&& count($mechanismData) > 0) {
            foreach ($mechanismData as $mechanism) {
                $replyData = $this->getReply($mechanism['id']);
                
                if (is_array($replyData) && count($replyData) > 0) {
                    // step 1 -> delete reply_attribute by reply_id
                    $deleteReplyAttribute = $this->processDeleteReplyAttribute($replyData);

                    if ($deleteReplyAttribute) {
                        // step 2 -> delete reply by mechanism_id
                        $deleteReply = $this->deleteReply($mechanism['id']);

                        if ($deleteReply) {
                            // step 3 -> delete mechanism by mechanism_id
                           $deleteMechanism = $this->deleteMechanism($mechanism['id']);

                           if ($deleteMechanism) {
                               $deleteStatus = true;
                           }
                       }
                    }
                }
            }
        }
        
        /**
         * commit/rollback sql transaction
         */
        if ($deleteStatus) {
            $this->dbCore->trans_commit();
            return true;
        }
        else {
            $this->dbCore->trans_rollback();
            return false;
        }
    }
    
    public function deleteKeywordByOperator($mechanismId) {
        $this->dbCore->trans_begin();
        $deleteStatus = false;
        $replyData = $this->getReply($mechanismId);
        
        if (is_array($replyData) && count($replyData) > 0) {
            // step 1 -> delete reply_attribute by reply_id
            $deleteReplyAttribute = $this->processDeleteReplyAttribute($replyData);
            
            if ($deleteReplyAttribute) {
                // step 2 -> delete reply by mechanism_id
                $deleteReply = $this->deleteReply($mechanismId);
                
                if ($deleteReply) {
                    // step 3 -> delete mechanism by mechanism_id
                    $deleteMechanism = $this->deleteMechanism($mechanismId);
                    
                    if ($deleteMechanism) {
                        $deleteStatus = true;
                    }
                }
            }
        }
        
        /**
         * commit/rollback sql transaction
         */
        if ($deleteStatus) {
            $this->dbCore->trans_commit();
            return true;
        }
        else {
            $this->dbCore->trans_rollback();
            return false;
        }
    }
    
    protected function getMechanism($serviceId, $pattern) {
        $this->dbCore->select('id');
        $this->dbCore->where('service_id', $serviceId);
        $this->dbCore->where('pattern', $pattern);
        $query = $this->dbCore->get($this->tblCoreMechanism);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        
        return $result;
    }

    protected function getReply($mechanismId) {
        $this->dbCore->select('id');
        $this->dbCore->where('mechanism_id', $mechanismId);
        $query = $this->dbCore->get($this->tblCoreReply);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    protected function processDeleteReplyAttribute($replyData) {
        if (is_array($replyData) && count($replyData) > 0) {
            foreach ($replyData as $reply) {
                $deleteReplyAttribute = $this->deleteReplyAttribute($reply['id']);
                
                if (!$deleteReplyAttribute) {
                    return false;
                }
            }
            
            return true;
        }
        
        return false;
    }
    
    protected function deleteReplyAttribute($replyId) {
        $this->dbCore->where('reply_id', $replyId);
        $query = $this->dbCore->delete($this->tblCoreReplyAttribute);
        
        if ($query) {
            return true;
        }
        
        return false;
    }
    
    protected function deleteReply($mechanismId) {
        $this->dbCore->where('mechanism_id', $mechanismId);
        $query = $this->dbCore->delete($this->tblCoreReply);
        
        if ($query) {
            return true;
        }
        
        return false;
    }
    
    protected function deleteMechanism($mechanismId) {
        $this->dbCore->where('id', $mechanismId);
        $query = $this->dbCore->delete($this->tblCoreMechanism);
        
        if ($query) {
            return true;
        }
        
        return false;
    }

    public function saveMechanism($data) {
        $query = $this->dbCore->insert($this->tblCoreMechanism, $data);
        $affectedRow = $this->dbCore->affected_rows();
        $result = 0;
        
        if ($affectedRow > 0) {
            $result = $this->dbCore->insert_id();
        }
        
        return $result;
    }
    
    public function saveReply($data) {
        $query = $this->dbCore->insert($this->tblCoreReply, $data);
        $affectedRow = $this->dbCore->affected_rows();
        $result = 0;
        
        if ($affectedRow > 0) {
            $result = $this->dbCore->insert_id();
        }
        
        return $result;
    }














//    
//    public function getComboboxOperator() {
//        $this->dbCore->select('id, name, long_name');
//        $this->dbCore->order_by('name', 'asc');
//        $query = $this->dbCore->get($this->tblCoreOperator);
//        $result = array ();
//        
//        if ($query->num_rows() > 0) {
//            $result = $query->result_array();
//        }
//
//        return $result;
//    }
//    
//    public function getComboboxHandler() {
//        $where = array ('status' => 1);
//        $this->dbCore->select('id, name');
//        $this->dbCore->where($where);
//        $this->dbCore->order_by('name', 'asc');
//        $query = $this->dbCore->get($this->tblCoreHandler);
//        $result = array ();
//        
//        if ($query->num_rows() > 0) {
//            $result = $query->result_array();
//        }
//
//        return $result;
//    }
//    
//    public function getMessageReplyCharging() {
//        $serviceId = $this->input->post('service_id', true);
//        $adn = $this->input->post('adn', true);
//        $operatorId = $this->input->post('operator_id', true);
//        
//        $this->dbCore->select('a.charging_id');
//        $this->dbCore->join($this->tblCoreCharging . ' b', 'b.id = a.charging_id', 'left');
//        $this->dbCore->where('a.service_id', $serviceId);
//        $this->dbCore->where('b.operator', $operatorId);
//        $this->dbCore->where('b.adn', $adn);
//        $this->dbCore->limit(1);
//        $query = $this->dbCore->get($this->tblCoreServiceSetting . ' a');
//        $result = false;
//        
//        if ($query->num_rows() > 0) {
//            $rows = $query->result_array();
//            $result = $rows[0]['charging_id'];
//        }
//
//        return $result;
//    }
//    
//    public function save() {
//        $action = $this->input->post('action', true);
//        $service = $this->input->post('service', true);
//        $operator = $this->input->post('operator', true);
//        $pattern = $this->input->post('pattern', true);
//        $handler = $this->input->post('handler', true);
//        $status = 1;
//        $dateCreated = date('Y-m-d H:i:s');
//        $dateModified = date('Y-m-d H:i:s');
//        
//        /**
//         * Save -> Insert or Update
//         */
//        if ($action == 'add') {
//            $data = array (
//                'pattern' => $pattern,
//                'operator_id' => $operator,
//                'service_id' => $service,
//                'handler' => $handler,
//                'date_created' => $dateCreated,
//                'date_modified' => $dateModified,
//                'status' => $status
//            );
//            $this->dbCore->insert($this->tblCoreMechanism, $data);
//        }
//        else {
//            $data = array (
//                'pattern' => $pattern,
//                'handler' => $handler,
//                'date_modified' => $dateModified
//            );
//            $this->dbCore->where('id', $this->input->post('edit_id', true));
//            $this->dbCore->update($this->tblCoreMechanism, $data);
//        }
//        
//        if ($this->dbCore->affected_rows() > 0) {
//            return true;
//        }
//        
//        return false;
//    }
//    
//    public function checkPatternExist($pattern, $serviceId, $operator, $edit_pattern = '') {
//        $this->dbCore->select('id');
//        $this->dbCore->where('service_id', $serviceId);
//        $this->dbCore->where('LOWER(pattern)', strtolower($pattern));
//        $this->dbCore->where('operator_id', $operator);
//        
//        if (!empty ($edit_pattern)) {
//            $this->dbCore->where('LOWER(pattern) !=', strtolower($edit_pattern));
//        }
//        
//        $this->dbCore->limit(1);
//        $query = $this->dbCore->get($this->tblCoreMechanism);
//        
//        if ($query->num_rows() > 0) {
//            return true;
//        }
//
//        return false;
//    }
//    
//    public function checkOperatorExist($operator, $serviceId, $pattern, $edit_operator = '') {
//        $this->dbCore->select('id');
//        $this->dbCore->where('operator_id', $operator);
//        $this->dbCore->where('service_id', $serviceId);
//        $this->dbCore->where('pattern', $pattern);
//        
//        if (!empty ($edit_operator)) {
//            $this->dbCore->where('operator_id !=', $edit_operator);
//        }
//        
//        $this->dbCore->limit(1);
//        $query = $this->dbCore->get($this->tblCoreMechanism);
//        
//        if ($query->num_rows() > 0) {
//            return true;
//        }
//
//        return false;
//    }
//    
//    public function edit($id) {
//        $this->dbCore->select('id, pattern, operator_id, service_id, handler, status');
//        $this->dbCore->where('id', $id);
//        $this->dbCore->limit(1);
//        $query = $this->dbCore->get($this->tblCoreMechanism);
//        $result = array ();
//        
//        if ($query->num_rows() > 0) {
//            $rows = $query->result_array();
//            $result = $rows[0];
//        }
//
//        return $result;
//    }
}

/* End of file keyword_model.php */
/* Location: ./application/models/services/keyword_model.php */
