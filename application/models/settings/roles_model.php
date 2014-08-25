<?php
/**
 * Description of Roles_model
 * 
 * @author  dhanyalvian@gmail.com
 */

class Roles_model extends MY_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function getGridDataTables() {
        /**
         *  Array of database columns which should be read and sent back to DataTables. Use a space where
	 *  you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array ('a.name', 'a.description', 'a.status', 'a.id');
	$aColumnsX = array ('name', 'description', 'status', 'id');
        $aColumnsY = array ('a.name', 'a.description', 'a.status', 'a.id');
        
	
	/**
         *  Indexed column (used for fast and accurate table cardinality)
         */
	$sIndexColumn = 'a.id';
	
	/**
         *  DB table to use
         */
	$sTable = $this->tblCmsRoles;
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
            for ($i = 0; $i < count($aColumnsY); $i++) {
                $bSearchable = $this->input->post('bSearchable_' . $i, true);
                
                // Individual column filtering
                if (isset ($bSearchable) && $bSearchable == 'true') {
                    $this->dbCms->or_like($aColumnsY[$i], $this->dbCms->escape_like_str($sSearch));
                }
            }
        }
        
        /**
         *  Select Data
         */
        $this->dbCms->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->dbCms->join($sTableJoin . ' b', 'b.id = a.handler', 'left');
        $this->dbCms->where('id !=', 1);
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
    
    public function getRoleResources($parent = 0) {
        $result = array ();
        $where = array (
            'status' => 1
        );
        //$whereIn = $this->getRoleId($role);

        $this->dbCms->select('id, title, parent');
        //$this->dbCms->where_in('id', $whereIn);
        $this->dbCms->where($where);
        $query = $this->dbCms->get($this->tblCmsNavigation);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }
    
    public function save() {
        $role = $this->input->post('role', true);
        $description = $this->input->post('description', true);
        $role_resources = $this->input->post('role_resources', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        $status = $this->input->post('status', true);
        
        /**
         * Save -> Insert or Update
         */
        if ($this->input->post('action', true) == 'add') {
            $data = array (
                'name' => $role,
                'description' => $description,
                'module' => implode(',', $role_resources),
                'date_created' => $dateCreated,
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbCms->insert($this->tblCmsRoles, $data);
        }
        else {
            $data = array (
                'name' => $role,
                'description' => $description,
                'module' => implode(',', $role_resources),
                'date_modified' => $dateModified,
                'status' => $status
            );
            $this->dbCms->where('id', $this->input->post('edit_id', true));
            $this->dbCms->update($this->tblCmsRoles, $data);
        }
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
    
    public function checkRoleExist($role, $edit_role = '') {
        $this->dbCms->select('id');
        $this->dbCms->where('name', $role);
        
        if (!empty ($edit_role)) {
            $this->dbCms->where('LOWER(name) !=', strtolower($edit_role));
        }
        
        $this->dbCms->limit(1);
        $query = $this->dbCms->get($this->tblCmsRoles);
        
        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
    
    public function edit($id) {
        $this->dbCms->select('id, name, description, module, status');
        $this->dbCms->where('id', $id);
        $this->dbCms->limit(1);
        $query = $this->dbCms->get($this->tblCmsRoles);
        $result = array ();
        
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $result = $rows[0];
        }

        return $result;
    }
    
    public function delete($id) {
        $this->dbCms->where('id', $id);
        $this->dbCms->limit(1);
        $query = $this->dbCms->delete($this->tblCmsRoles);
        
        if ($this->dbCms->affected_rows() > 0) {
            return true;
        }
        
        return false;
    }
}

/* End of file roles_model.php */
/* Location: ./application/models/settings/roles_model.php */
