<?php
/**
 * Description of Glyphicons
 * 
 * @author  dhanyalvian@gmail.com
 */

class Glyphicons extends MY_Controller {
    protected $_pageController = 'glyphicons';
    protected $_pageTitle = 'Glyphicons';
    protected $_pageActive = 'components';
    protected $_pageViews = 'components/glyphicons';
    protected $_pageBreadcumb = array (
        array ('title' => 'Components', 'url' => '#'),
        array ('title' => 'Glyphicons', 'url' => '')
    );
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
}

/* End of file glyphicons.php */
/* Location: ./application/controllers/glyphicons.php */