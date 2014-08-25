<?php
/**
 * Description of Rptservice
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptservice extends MY_Controller {
    protected $_pageController = 'rptservice';
    protected $_pageTitle = 'Report Service';
    protected $_pageActive = 'report';
    protected $_pageViews = 'report/rptservice';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Report', 'url' => ''),
    //    array ('title' => 'Service', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'rptservice');
    protected $_rptserviceModel = 'report/rptservice_model';
    
    protected $_day;
    protected $_lastDay;
    protected $_deliveryStatus = array ('Sent', 'Unknown', 'Failed', 'Delivered', 'Revenue');

    public function __construct() {
        parent::__construct();
        $this->_day = date('d');
        $this->_lastDay = date('t', strtotime('today'));
    }
    
    public function index() {
        $this->_data['current_month_year'] = $this->getCurrentMonthYear();
        $this->_data['combobox_month'] = $this->getComboboxMonths();
        $this->_data['combobox_year'] = $this->getComboboxYears();
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
        $this->_data['combobox_service'] = $this->getComboboxService();
        $this->load->view('structure', $this->_data);
    }

    public function getGridReportTables() {
        $this->_ajaxRequest['tdate'] = $this->input->post('year', true) . '-' . $this->input->post('month', true);
        $this->_ajaxRequest['adn'] = $this->input->post('adn', true);
        $this->_ajaxRequest['operator'] = $this->input->post('operator', true);
        
        $data = array (
            'thead' => $this->getGridReportThead(),
            'tbody' => $this->getGridReportTbody()
        );
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = $data;
        $this->_ajaxResponse();
    }
    
    private function getReportService() {
        $this->load->model($this->_rptserviceModel);
        return $this->rptservice_model->getReportService($this->_ajaxRequest);
    }

    private function getGridReportThead() {
        $thead = $this->_prepareThead();
        $result = '';
        
        if (is_array($thead) && count($thead) > 0) {
            foreach ($thead as $tr) {
                $result .= '<tr>';

                foreach ($tr as $th) {
                    $colspan = array_key_exists('colspan', $th) ? 'colspan="' . $th['colspan'] . '"' : '';
                    $rowspan = array_key_exists('rowspan', $th) ? 'rowspan="' . $th['rowspan'] . '"' : '';
                    $class = array_key_exists('class', $th) ? 'class="' . $th['class'] . '"' : '';
                    $result .= sprintf("<th %s %s %s>%s</th>", $colspan, $rowspan, $class, $th['title']);
                }

                $result .= '</tr>';
            }
        }
        else {
            $result .= '<tr><th style="text-align:left">No data found</th></tr>';
        }
        
        return $result;
    }
    
    private function _prepareThead() {
        $thead = array ();
        $i = 0;
        $day = $this->getDay();
        
        /**
         * tdate > now()
         */
        if ($day == 0) {
            return $thead;
        }
        
        $thead[$i][] = array (
            'title' => 'Service',
            'rowspan' => 2,
            'class' => 'middle-center'
        );
        $thead[$i][] = array (
            'title' => 'Total',
            'colspan' => 3,
            'class' => 'uppercase'
        );
        $thead[$i][] = array (
            'title' => 'This Mon Avg',
            'colspan' => 3
        );
        $thead[$i][] = array (
            'title' => 'MonthEnd',
            'colspan' => 3
        );
        
        $y = (int) $day;
        
        for ($x = 1; $x <= (int) $y; $x++) {
            $thead[$i][] = array (
                'title' => $this->_leadingByZero($day),
                'colspan' => 3
            );
            $day--;
        }
        $i++;
        
        /**
         * second row
         * Sent, Received, Gross
         */
        for ($x = 0; $x < 3; $x++) {
            $thead[$i][] = array ('title' => 'Sent');
            $thead[$i][] = array ('title' => 'Rcvd');
            $thead[$i][] = array ('title' => 'Gross');
        }
        
        $day = $this->getDay();
        
        for ($x = 1; $x <= (int) $y; $x++) {
            $thead[$i][] = array ('title' => 'Sent');
            $thead[$i][] = array ('title' => 'Rcvd');
            $thead[$i][] = array ('title' => 'Gross');
            $day--;
        }
        
        return $thead;
    }
    
    private function getGridReportTbody() {
        $tbody = $this->_prepareTbody();
        $result = '';
        
        if (is_array($tbody) && count($tbody) > 0) {
            foreach ($tbody as $tr) {
                $result .= '<tr>';
                
                foreach ($tr as $td) {
                    $rowspan = array_key_exists('rowspan', $td) ? 'rowspan="' . $td['rowspan'] . '"' : '';
                    $class = array_key_exists('class', $td) ? 'class="' . $td['class'] . '"' : '';
                    $result .= sprintf("<td %s %s>%s</td>", $rowspan, $class, $td['value']);
                }
                
                $result .= '</tr>';
            }
        }
        
        return $result;
    }
    
    private function _prepareTbody() {
        $i = 0;
        $reportService = $this->getReportService();
        $tbody = array ();
        
        /**
         * tdate > now()
         */
        if ($this->getDay() == 0) {
            return $tbody;
        }
        
        /**
         * collect row per service
         */
        $serviceValue = '';
        $reportPerService = array ();
        
        foreach ($reportService as $rptService) {
            if ($serviceValue != $rptService['service']) {
                $reportPerService[] = $rptService['service'];
                $serviceValue = $rptService['service'];
            }
            
            continue;
        }
        
        foreach ($reportPerService as $rptService) {
            $day = $this->getDay();
            $tbody[$i][] = array ('value' => $rptService);
            
            /**
             * collect data per day
             */
            $perDay = array ();
            $y = (int) $day;

            for ($x = 0; $x < $y; $x++) {
                $perDay[] = array (
                    'sent' => $this->_getTotalPerDay($reportService, $rptService, 'sent', $this->_leadingByZero($day)),
                    'rcvd' => $this->_getTotalPerDay($reportService, $rptService, 'delivered', $this->_leadingByZero($day)),
                    'gross' => $this->_getTotalPerDay($reportService, $rptService, 'gross', $this->_leadingByZero($day))
                );
                $day--;
            }
            
            /**
             * collect Total
             */
            $dayTotalSent = 0;
            $dayTotalRcvd = 0;
            $dayTotalGross = 0;
            
            foreach ($perDay as $key => $row) {
                $dayTotalSent += $row['sent'];
                $dayTotalRcvd += $row['rcvd'];
                $dayTotalGross += $row['gross'];
            }
            
            /**
             * Total
             */
            $tbody[$i][] = array ('value' => number_format($dayTotalSent), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format($dayTotalRcvd), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format($dayTotalGross), 'class' => 'numeric total');
            
            /**
             * This month average
             */
            $tbody[$i][] = array ('value' => number_format(floor($dayTotalSent / count($perDay))), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format(floor($dayTotalRcvd / count($perDay))), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format(floor($dayTotalGross / count($perDay))), 'class' => 'numeric total');
            
            /**
             * Monthend
             */
            $tbody[$i][] = array ('value' => number_format(floor(($dayTotalSent / count($perDay)) * $this->getLastDay())), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format(floor(($dayTotalRcvd / count($perDay)) * $this->getLastDay())), 'class' => 'numeric');
            $tbody[$i][] = array ('value' => number_format(floor(($dayTotalGross / count($perDay)) * $this->getLastDay())), 'class' => 'numeric total');
            
            /**
             * create day per row
             */
            foreach ($perDay as $key => $row) {
                $tbody[$i][] = array ('value' => number_format($row['sent']), 'class' => 'numeric');
                $tbody[$i][] = array ('value' => number_format($row['rcvd']), 'class' => 'numeric');
                $tbody[$i][] = array ('value' => number_format($row['gross']), 'class' => 'numeric');
            }
            
            $i++;
        }
        
        return $tbody;
    }
    
    private function _getTotalPerDay($reportService, $service, $deliveryStatus, $day) {
        $result = 0;
        
        if (is_array($reportService) && count($reportService) > 0) {
            foreach ($reportService as $row) {
                if (strtolower($row['service'] == strtolower($service))) {
                    if (strtolower($row['delivery_status']) == strtolower($deliveryStatus)) {
                        if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                            $result += $row['total'];
                        }
                    }
                    else if ($deliveryStatus == 'gross') {
                        if (strtolower($row['delivery_status']) == 'revenue') {
                            if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                                $result += ($row['total'] * $row['price']);
                            }
                        }
                    }
                }
            }
        }
        
        return (int) $result;
    }

    private function _getTotalPerDaySubject($reportService, $subject, $deliveryStatus, $day) {
        $result = 0;
        
        if (is_array($reportService) && count($reportService) > 0) {
            foreach ($reportService as $row) {
                if ($row['subject'] == $subject) {
                    if (strtolower($row['delivery_status']) == strtolower($deliveryStatus)) {
                        if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                            $result += $row['total'];
                        }
                    }
                }
            }
        }
        
        return (int) $result;
    }

    private function getDay() {
        $day = $this->_day;
        
        if (date('Y-m') != $this->_ajaxRequest['tdate']) {
            if (strtotime($this->_ajaxRequest['tdate']) > strtotime(date('Y-m'))) {
                $day = 0;
            }
            else {
                $day = date('t', strtotime($this->_ajaxRequest['tdate']));
            }
        }
        
        return $day;
    }
    
    private function getLastDay() {
        $lastDay = $this->_lastDay;
        
        if (date('Y-m') != $this->_ajaxRequest['tdate']) {
            if (strtotime($this->_ajaxRequest['tdate']) > strtotime(date('Y-m'))) {
                $lastDay = 0;
            }
            else {
                $lastDay = date('t', strtotime($this->_ajaxRequest['tdate']));
            }
        }
        
        return $lastDay;
    }
    
    private function getCurrentMonthYear() {
        $result = array (
            'month' => date('m'),
            'year' => date('Y')
        );
        
        return $result;
    }
    
    private function getComboboxMonths() {
        $month = array (
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );
        
        return $month;
    }
    
    private function getComboboxYears() {
        $year = $this->config->item('year_start');
        $range = $this->config->item('year_range');
        $years = array ();
        
        for ($x = 0; $x < $range; $x++) {
            $years[] = $year;
            $year++;
        }
        
        return $years;
    }
    
    private function getComboboxAdn() {
        $this->load->model($this->_rptserviceModel);
        return $this->rptservice_model->getComboboxAdn();
    }
    
    private function getComboboxOperator() {
        $this->load->model($this->_rptserviceModel);
        return $this->rptservice_model->getComboboxOperator();
    }
    
    private function getComboboxService() {
        $this->load->model($this->_rptserviceModel);
        return $this->rptservice_model->getComboboxService();
    }
}

/* End of file rptservice.php */
/* Location: ./application/controllers/report/rptservice.php */