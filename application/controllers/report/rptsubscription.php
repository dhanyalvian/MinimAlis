<?php
/**
 * Description of Rptsubscription
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptsubscription extends MY_Controller {
    protected $_pageController = 'rptsubscription';
    protected $_pageTitle = 'Report Subscription';
    protected $_pageActive = 'report';
    protected $_pageViews = 'report/rptsubscription';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Report', 'url' => ''),
    //    array ('title' => 'Subscription', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'rptsubscription');
    protected $_rptsubscriptionModel = 'report/rptsubscription_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $this->load->model($this->_rptsubscriptionModel);
        $response = $this->rptsubscription_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
}

/* End of file rptsubscription.php */
/* Location: ./application/controllers/report/rptsubscription.php */