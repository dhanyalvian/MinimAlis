<?php
/**
 * Description of Restricted
 * 
 * @author  dhanyalvian@gmail.com
 */

class Restricted extends MY_Controller {
    protected $_pageController = 'restricted';
    protected $_pageTitle = 'Restricted Page';
    //protected $_pageActive = 'dashboard';
    protected $_pageViews = 'restricted';
//    protected $_pageBreadcumb = array (
//        array ('title' => 'Dashboard', 'url' => '')
//    );
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
}

/* End of file restricted.php */
/* Location: ./application/controllers/restricted.php */