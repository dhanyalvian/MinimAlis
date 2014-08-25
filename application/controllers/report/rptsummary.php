<?php
/**
 * Description of Rptsummary
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptsummary extends MY_Controller {
    protected $_pageController = 'rptsummary';
    protected $_pageTitle = 'Report Summary';
    protected $_pageActive = 'report';
    protected $_pageViews = 'report/rptsummary';
    //protected $_pageBreadcumb = array (
    //    array ('title' => 'Report', 'url' => ''),
    //    array ('title' => 'Summary', 'url' => '')
    //);
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'rptsummary');
    protected $_rptsummaryModel = 'report/rptsummary_model';
    
    protected $_day;
    protected $_deliveryStatus = array ('Sent', 'Unknown', 'Failed', 'Delivered', 'Revenue');

    public function __construct() {
        parent::__construct();
        $this->_day = date('d');
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
        $this->_ajaxRequest['service'] = $this->input->post('service', true);
        
        $data = array (
            'thead' => $this->getGridReportThead(),
            'tbody' => $this->getGridReportTbody()
        );
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = $data;
        $this->_ajaxResponse();
    }
    
    private function getReportService() {
        $this->load->model($this->_rptsummaryModel);
        return $this->rptsummary_model->getReportService($this->_ajaxRequest);
    }

    private function getGridReportThead() {
        $thead = $this->_prepareThead();
        $result = '';
        
        if (is_array($thead) && count($thead) > 0) {
            $result .= '<tr>';
            
            foreach ($thead as $key => $th) {
                $colspan = array_key_exists('colspan', $th) ? 'colspan="' . $th['colspan'] . '"' : '';
                $class = array_key_exists('class', $th) ? 'class="' . $th['class'] . '"' : '';
                $result .= sprintf("<th %s %s>%s</th>", $colspan, $class, $th['title']);
            }
            
            $result .= '</tr>';
        }
        else {
            $result .= '<tr><th style="text-align:left">No data found</th></tr>';
        }
        
        return $result;
    }
    
    private function _prepareThead() {
        $day = $this->getDay();
        $thead = array ();
        
        /**
         * tdate > now()
         */
        if ($day == 0) {
            return $thead;
        }
        
        $thead[] = array (
            'title' => 'Subject',
            'colspan' => 2
        );
        $thead[] = array (
            'title' => 'Total',
            'class' => 'uppercase'
        );
        $y = (int) $day;
        
        for ($x = 1; $x <= (int) $y; $x++) {
            $thead[] = array (
                'title' => $this->_leadingByZero($day)
            );
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
         * row total
         */
        $tbody[$i][] = array (
            'value' => 'Total',
            'rowspan' => 5,
            'class' => 'middle-center uppercase'
        );
        
        foreach ($this->_deliveryStatus as $deliveryStatus) {
            $day = $this->getDay();
            $revenueClass = (strtolower($deliveryStatus) == 'revenue') ? 'revenue' : '';
            $totalRevenueClass = (strtolower($deliveryStatus) == 'revenue') ? 'total-revenue' : 'revenue';
            $tbody[$i][] = array (
                'value' => $deliveryStatus,
                'class' => $revenueClass
            );
            $perDay = array ();
            //$totalRow = 0;
            $y = (int) $day;
            
            for ($x = 1; $x <= $y; $x++) {
                $perDay[] = $this->_getTotalPerDay($reportService, $deliveryStatus, $this->_leadingByZero($day));
                $day--;
            }
            
            //total per row
            $tbody[$i][] = array (
                'value' => number_format(array_sum($perDay)),
                'class' => 'numeric total ' . $totalRevenueClass
            );
            
            foreach ($perDay as $value) {
                $tbody[$i][] = array (
                    'value' => number_format($value),
                    'class' => 'numeric ' . $revenueClass
                );
            }
            
            $i++;
        }
        
        /**
         * collect report per subject
         */
        $subjectValue = '';
        $reportPerSubject = array ();
        
        foreach ($reportService as $rptService) {
            if ($subjectValue != $rptService['subject']) {
                $reportPerSubject[] = $rptService['subject'];
                $subjectValue = $rptService['subject'];
            }
            
            continue;
        }
        
        /**
         * row per subject
         */
        foreach ($reportPerSubject as $rptSubject) {
            $tbody[$i][] = array (
                'value' => $rptSubject,
                'rowspan' => 5,
                'class' => 'middle-center uppercase'
            );

            foreach ($this->_deliveryStatus as $deliveryStatus) {
                $day = $this->getDay();
                $revenueClass = (strtolower($deliveryStatus) == 'revenue') ? 'revenue' : '';
                $totalRevenueClass = (strtolower($deliveryStatus) == 'revenue') ? 'total-revenue' : 'revenue';
                $tbody[$i][] = array (
                    'value' => $deliveryStatus,
                    'class' => $revenueClass
                );
                $perDay = array ();
                $y = (int) $day;

                for ($x = 1; $x <= $y; $x++) {
                    $perDay[] = $this->_getTotalPerDaySubject($reportService, $rptSubject, $deliveryStatus, $this->_leadingByZero($day));
                    $day--;
                }

                //total per row
                $tbody[$i][] = array (
                    'value' => number_format(array_sum($perDay)),
                    'class' => 'numeric total ' . $totalRevenueClass
                );

                foreach ($perDay as $value) {
                    $tbody[$i][] = array (
                        'value' => number_format($value),
                        'class' => 'numeric ' . $revenueClass
                    );
                }

                $i++;
            }
        }
        
        return $tbody;
    }
    
    private function _getTotalPerDay($reportService, $deliveryStatus, $day) {
        $result = 0;
        
        if (is_array($reportService) && count($reportService) > 0) {
            foreach ($reportService as $row) {
                if (strtolower($row['delivery_status']) == strtolower($deliveryStatus)) {
                    if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                        if (strtolower($deliveryStatus) == 'revenue') {
                            $result += ($row['total'] * $row['price']);
                        }
                        else {
                            $result += $row['total'];
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
                            if (strtolower($deliveryStatus) == 'revenue') {
                                $result += ($row['total'] * $row['price']);
                            }
                            else {
                                $result += $row['total'];
                            }
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
        $this->load->model($this->_rptsummaryModel);
        return $this->rptsummary_model->getComboboxAdn();
    }
    
    private function getComboboxOperator() {
        $this->load->model($this->_rptsummaryModel);
        return $this->rptsummary_model->getComboboxOperator();
    }
    
    private function getComboboxService() {
        $this->load->model($this->_rptsummaryModel);
        return $this->rptsummary_model->getComboboxService();
    }
}

/* End of file rptsummary.php */
/* Location: ./application/controllers/report/rptsummary.php */