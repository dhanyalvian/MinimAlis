<?php
/**
 * Description of Motraffic
 * 
 * @author  Dhany Noor Alfian <dhanyalvian@gmail.com>
 */

class Motraffic extends MY_Controller {
    protected $_pageController = 'motraffic';
    protected $_pageTitle = 'MO Traffic';
    protected $_pageActive = 'motraffic';
    protected $_pageViews = 'motraffic';
    protected $_pageBreadcrumb = false;
    protected $_additionalCss = array ('bootstrap.dataTables', 'bootstrap-datetimepicker.min');
    protected $_additionalJs = array ('highcharts', 'jquery.dataTables.min', 'jquery.dataTables.paging.min', 'moment', 'bootstrap-datetimepicker.min', 'motraffic');
    protected $_motrafficModel = 'motraffic_model';

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->_data['today'] = date('d-M-Y');
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->_data['combobox_service'] = $this->getComboboxService();
        $this->_data['combobox_motype'] = $this->config->item('mo_type');
        $this->load->view('structure', $this->_data);
    }
    
    public function getTodayMo() {
        $this->load->model($this->_motrafficModel);
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = array (
            'today' => number_format($this->motraffic_model->getTodayMo('today')),
            'yesterday' => number_format($this->motraffic_model->getTodayMo('yesterday')),
            'lastsevenday' => number_format($this->motraffic_model->getTodayMo('lastsevenday'))
        );
        $this->_ajaxResponse();
    }
    
    public function getMoTrends() {
        $lastMonths = (int) $this->input->post('motrends_months', true);
        
        $xAxisData = $this->getXAxisData($lastMonths);
        $seriesData = $this->getSeriesData($lastMonths, $xAxisData);
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = array ('xAxis' => $xAxisData, 'series' => $seriesData);
        $this->_ajaxResponse();
    }
    
    private function getXAxisData($lastMonths) {
        $result = array ();
        
        for ($x = 0; $x < $lastMonths; $x++) {
            $result[] = date('M-Y', strtotime('-' . $x . ' months'));
        }
        
        return array_reverse($result);
    }
    
    private function getSeriesData($lastMonths, $xAxisData) {
        $this->load->model($this->_motrafficModel);
        $rows = $this->motraffic_model->getSeriesData($lastMonths);
        $result = array ();
        
        foreach ($xAxisData as $xAxis) {
            $series = false;
            
            foreach ($rows as $row) {
                if ($xAxis == $row['month_date']) {
                    $result[] = (int) $row['total'];
                    $series = true;
                }
            }
            
            if ($series == false) {
                $result[] = 0;
            }
        }
        
        return $result;
    }
    
    public function getTotalMo() {
        $this->load->model($this->_motrafficModel);
        $total = $this->motraffic_model->getTotalMo();
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = array (
            'total' => number_format($this->motraffic_model->getTotalMo()),
            'lastmonth' => number_format($this->motraffic_model->getTotalMo('lastmonth')),
            'lastsixmonth' => number_format($this->motraffic_model->getTotalMo('lastsixmonth'))
        );
        $this->_ajaxResponse();
    }

    public function getGridDataTables() {
        $this->load->model($this->_motrafficModel);
        $response = $this->motraffic_model->getGridDataTables();
        
        echo json_encode($response);
        exit;
    }
    
    private function getComboboxAdn() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxAdn();
    }
    
    private function getComboboxOperator() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxOperator();
    }
    
    private function getComboboxService() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxService();
    }
}

/* End of file motraffic.php */
/* Location: ./application/controllers/motraffic.php */