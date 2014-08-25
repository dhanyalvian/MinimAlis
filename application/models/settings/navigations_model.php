<?php
/**
 * Description of Navigations_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Navigations_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.title', 'a.controller', 'a.url', 'b.title parent_title', 'a.display', 'a.sort', 'a.status', 'a.id');
	$aColumnsX = array ('title', 'controller', 'url', 'parent_title', 'display', 'sort', 'status', 'id');
        //$aColumnsX = array ('a.username', 'a.fullname', 'b.name', 'a.status', 'a.userid');
        
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCmsNavigation;
        $sTableJoin = $this->tblCmsNavigation;
    
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
            $this->dbCms->limit($this->dbCms->escape_str($iDisplayLength), $this->dbCms->escape_str($iDisplayStart));
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
                    $this->dbCms->order_by($aColumns[intval($this->dbCms->escape_str($iSortCol))], $this->dbCms->escape_str($sSortDir));
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
                    $this->dbCms->or_like($aColumnsX[$i], $this->dbCms->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbCms->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->dbCms->join($sTableJoin . ' b', 'b.id = a.parent', 'left');
        //$this->dbCms->where('a.role >', (int) $this->roleId);
        $rResult = $this->dbCms->get($sTable . ' a');
        
        /**
         *  Data set length after filtering
         */
        $this->dbCms->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->dbCms->get()->row()->found_rows;
    
        /**
         *  Total data set length
         */
        $iTotal = $this->dbCms->count_all($sTable);
    
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
    
    public function getComboboxParent() {
        $result = array ();
        $where = array (
            'parent' => 0,
            'display' => 1,
            'status' => 1
        );
        $this->dbCms->select('id, title');
        $this->dbCms->where($where);
        $this->dbCms->order_by('title', 'asc'); 
        $query = $this->dbCms->get($this->tblCmsNavigation);
        
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    //-------------------------------------------------------------------------- sampe sini dulu yak ------------------------------------------------//

    public function save() {
        $username = $this->input->post('username', true);
        $fullname = $this->input->post('fullname', true);
        $password = $this->config->item('default_password');
        $role = $this->input->post('role', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        $status = $this->input->post('status', true);
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'username' => $username,
                'fullname' => $fullname,
                'password' => md5($password),
                'role' => $role,
                'date_created' => $dateCreated,
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbCms->insert($this->tblCmsUsers, $data);
        }
        else {
            $data = array (
                'username' => $username,
                'fullname' => $fullname,
                'role' => $role,
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbCms->where('userid', $this->input->post('edit_id', true));
            $this->dbCms->update($this->tblCmsUsers, $data);
        }
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkUsernameExist($username, $edit_username = '') {
        $this->dbCms->select('userid');
        $this->dbCms->where('username', $username);
        
        if (!empty ($edit_username)) {
            $this->dbCms->where('username !=', $edit_username);
        }
        
        $this->dbCms->limit(1);
        $query = $this->dbCms->get($this->tblCmsUsers);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbCms->select('userid, username, fullname, role, status');
        $this->dbCms->where('userid', $id);
        $this->dbCms->limit(1);
        $query = $this->dbCms->get($this->tblCmsUsers);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }

        return $result;
    }
    
    public function delete($id) {
        $this->dbCms->where('userid', $id);
        $this->dbCms->limit(1);
        $query = $this->dbCms->delete($this->tblCmsUsers);
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function reset($id) {
        $data = array (
            'password' => md5($this->config->item('default_password')),
            'date_modified' => date('Y-m-d H:i:s')
        );
        $this->dbCms->where('userid', $id);
        $this->dbCms->limit(1);
        $query = $this->dbCms->update($this->tblCmsUsers, $data);
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file navigations_model.php */
/* Location: ./application/models/settings/navigations_model.php */
