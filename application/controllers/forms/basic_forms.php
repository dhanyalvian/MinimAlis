<?php
/**
 * Description of Basic_forms
 * 
 * @author  dhanyalvian@gmail.com
 */

class Basic_forms extends MY_Controller {
    protected $_pageController = 'basic_forms';
    protected $_pageTitle = 'Basic Forms';
    protected $_pageActive = 'forms';
    protected $_pageViews = 'forms/basic_forms';
    protected $_pageBreadcumb = array (
        array ('title' => 'Forms', 'url' => '#'),
        array ('title' => 'Basic Forms', 'url' => '')
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