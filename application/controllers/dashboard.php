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
                'icon' => 'fa-tags',
                'title' => 'Lifetime Sales',
                'currency' => 'Rp',
                'total' => 2620890,
            ),
            array (
                'icon' => 'fa-shopping-cart',
                'title' => 'Average Orders',
                'currency' => 'Rp',
                'total' => 342135,
            ),
            array (
                'icon' => 'fa-user',
                'title' => 'Users Registered',
                'currency' => false,
                'total' => 39607,
            ),
            array (
                'icon' => 'fa-bar-chart-o',
                'title' => 'Total Profit',
                'currency' => false,
                'total' => 12314,
            ),
        );
        $this->load->view('structure', $this->_data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */