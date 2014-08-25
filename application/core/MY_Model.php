<?php
/**
 * Description of MY_Model
 * 
 * @author dhanyalvian@gmail.com
 */

class MY_Model extends CI_Model {
    /**
      * define connection db
      */
    protected $dbConn = null;

    /**
     * define table
     */
    protected $tblNavigation = null;
    protected $tblUsers = null;
    protected $tblRoles = null;
    protected $tblConfigData = null;
    
    /**
     * Date Format
     */
    protected $dateFormatMysql = null;
    protected $dateTimeFormatMysql = null;

    public function __construct() {
        parent::__construct();
        
        $this->_setDatabase();
        $this->_getDatabaseTable();
        $this->dateFormatMysql = $this->config->item('date_format_mysql');
        $this->dateTimeFormatMysql = $this->config->item('date_time_format_mysql');
    }
    
    private function _setDatabase() {
        $this->dbConn = $this->load->database('default', true);
    }
    
    private function _getDatabaseTable() {
        $this->tblNavigation = $this->config->item('tbl_navigation');
        $this->tblUsers = $this->config->item('tbl_users');
        $this->tblRoles = $this->config->item('tbl_roles');
        $this->tblConfigData = $this->config->item('tbl_config_data');
    }
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */