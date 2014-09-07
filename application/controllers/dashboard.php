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
                'icon' => 'fa-usd',
                'title' => 'Revenue',
                'currency' => 'Rp',
                'total' => 2620890,
            ),
            array (
                'icon' => 'fa-tag',
                'title' => 'Tax',
                'currency' => 'Rp',
                'total' => 342135,
            ),
            array (
                'icon' => 'fa-truck',
                'title' => 'Shipping',
                'currency' => false,
                'total' => 39607,
            ),
            array (
                'icon' => 'fa-list-alt',
                'title' => 'Quantity',
                'currency' => false,
                'total' => 12314,
            ),
        );
        
        $bestSellers = array (
            5700 => 'SGM Ananda Presinutri 2 400gr Box',
            5093 => 'Huggies Ultra L 34',
            5063 => 'Bebelac 3 Madu 800gr Tin',
            4282 => 'Bebelac 3 Vanilla 800gr (tin)',
            3783 => 'Huggies Ultra M 40',
            12043 => 'Morinaga BMT Platinum 800gr Tin',
            11240 => 'S26 Gold Tahap 1 900gr Tin',
        );
        krsort($bestSellers);
        
        $this->_data['best_sellers'] = $bestSellers;
        $this->load->view('structure', $this->_data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */