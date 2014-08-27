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
        $this->_data['dashboard_overview'] = array (
            array (
                'icon' => 'fa-user',
                'title' => 'Users',
                'total' => 222,
            ),
            array (
                'icon' => 'fa-tags',
                'title' => 'Sales',
                'total' => 1234,
            ),
            array (
                'icon' => 'fa-shopping-cart',
                'title' => 'New Order',
                'total' => 326,
            ),
            array (
                'icon' => 'fa-bar-chart-o',
                'title' => 'Total Profit',
                'total' => 12314,
            ),
        );
        $this->load->view('structure', $this->_data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */