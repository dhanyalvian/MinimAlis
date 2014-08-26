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
        $this->_data['dashboard_icon'] = array (
            'fa-android',
            'fa-apple',
            'fa-windows',
            'fa-git',
            'fa-github',
            'fa-bitbucket',
            'fa-drupal',
            'fa-wordpress',
        );
        $this->load->view('structure', $this->_data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */