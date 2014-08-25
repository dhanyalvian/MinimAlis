<?php
/**
 * Description of Push_project_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Push_project_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
        $aColumns = array ('a.sid', 'a.src', 'a.oprid', 'a.service', 'a.subject', 'a.message', 'FORMAT(a.price, 0) price', 'FORMAT(a.amount, 0) amount', 'a.processed', 'a.stat', 'DATE_FORMAT(a.created, \'' . $this->dateTimeFormatMysql . '\') created', 'a.pid');
	$aColumnsX = array ('sid', 'src', 'oprid', 'service', 'subject', 'message', 'price', 'amount', 'processed', 'stat', 'created', 'pid');
        
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblPushProject;
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
            $this->dbPush->limit($this->dbPush->escape_str($iDisplayLength), $this->dbPush->escape_str($iDisplayStart));
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
                    $this->dbPush->order_by($aColumns[intval($this->dbPush->escape_str($iSortCol))], $this->dbPush->escape_str($sSortDir));
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
                    $this->dbPush->or_like($aColumnsX[$i], $this->dbPush->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbPush->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbPush->join($sTableJoin . ' b', 'b.id = a.handler', 'left');
        $rResult = $this->dbPush->get($sTable . ' a');
    
        /**
         *  Data set length after filtering
         */
        $this->dbPush->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->dbPush->get()->row()->found_rows;
    
        /**
         *  Total data set length
         */
        $iTotal = $this->dbPush->count_all($sTable);
    
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
        $this->dbCore->select('id, name');
        $this->dbCore->order_by('name', 'asc'); 
        $query = $this->dbCore->get($this->tblCoreService);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function save() {
        $service = $this->input->post('service', true);
        $contentLabel = $this->input->post('content_label', true);
        $content = $this->input->post('content', true);
        $author = $this->input->post('author', true);
        $notes = $this->input->post('notes', true);
        $datePublish = $this->input->post('datepublish', true);
        $lastUsed = date('Y-m-d H:i:s');
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'service' => $service,
                'content_label' => $contentLabel,
                'content' => $content,
                'author' => $author,
                'notes' => $notes,
                'datepublish' => date('Y-m-d H:i:s', strtotime($datePublish)),
                'lastused' => $lastUsed,
                'created' => $dateCreated,
                'modified' => $dateModified
            );
            $this->dbPush->insert($this->tblPushContent, $data);
        }
        else {
            $data = array (
                'service' => $service,
                'content_label' => $contentLabel,
                'content' => $content,
                'author' => $author,
                'notes' => $notes,
                'datepublish' => date('Y-m-d H:i:s', strtotime($datePublish)),
                'modified' => $dateModified
            );
            $this->dbPush->where('id', $this->input->post('edit_id', true));
            $this->dbPush->update($this->tblPushContent, $data);
        }
        
        if ($this->dbPush->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function edit($id) {
        $this->dbPush->select('id, service, content_label, content, author, notes, DATE_FORMAT(datepublish, \'' . $this->dateTimeFormatMysql . '\') datepublish', false);
        $this->dbPush->where('id', $id);
        $this->dbPush->limit(1);
        $query = $this->dbPush->get($this->tblPushContent);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }

        return $result;
    }
    
    public function delete($id) {
        $this->dbPush->where('id', $id);
        $this->dbPush->limit(1);
        $query = $this->dbPush->delete($this->tblPushContent);
        
        if ($this->dbPush->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file push_project_model.php */
/* Location: ./application/models/dailypush/push_project_model.php */
