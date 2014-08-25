<?php
/**
 * Description of Dashboard
 * 
 * @author  dhanyalvian@gmail.com
 */

class Dashboard extends MY_Controller {
    protected $_pageController = 'dashboard';
    protected $_pageTitle = 'Dashboard';
    protected $_pageActive = 'dashboard';
    protected $_pageViews = 'dashboard';
    protected $_pageBreadcumb = array (
        array ('title' => 'Dashboard', 'url' => '')
    );
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */