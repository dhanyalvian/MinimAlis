<?php
/**
 * Description of Rptrevenue
 * 
 * @author  dhanyalvian@gmail.com
 */

class Rptrevenue extends MY_Controller {
    protected $_pageController = 'rptrevenue';
    protected $_pageTitle = 'Report Revenue';
    protected $_pageActive = 'report';
    protected $_pageViews = 'report/rptrevenue';
    protected $_additionalCss = array ();
    protected $_additionalJs = array ('rptrevenue');
    protected $_rptrevenueModel = 'report/rptrevenue_model';
    
    protected $_day;
    protected $_lastDay;
    protected $_month;
    protected $_subject = array ('MO', 'MT');
    protected $_deliveryStatus = array ('Delivered', 'Gross Revenue');

    public function __construct() {
        parent::__construct();
        $this->_month = date('Y-m');
        $this->_day = date('d');
        $this->_lastDay = date('t', strtotime('today'));
    }
    
    public function index() {
        $this->_data['current_month_year'] = $this->getCurrentMonthYear();
        $this->_data['combobox_month'] = $this->getComboboxMonths();
        $this->_data['combobox_year'] = $this->getComboboxYears();
        $this->_data['combobox_adn'] = $this->getComboboxAdn();
        $this->_data['combobox_operator'] = $this->getComboboxOperator();
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
        $this->load->model($this->_rptrevenueModel);
        return $this->rptrevenue_model->getReportService($this->_ajaxRequest);
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
        $month = $this->getMonth();
        $day = $this->getDay();
        $thead = array ();
        
        /**
         * tdate > now()
         */
        if ($day == 0) {
            return $thead;
        }
        
        $thead[] = array (
            'title' => $month . ' <span style="padding-left:10px;">ALL</span>'
        );
        $thead[] = array (
            'title' => 'Total',
            'class' => 'uppercase'
        );
        $thead[] = array (
            'title' => 'Average'
        );
        $thead[] = array (
            'title' => 'MonthEnd'
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
                    $colspan = array_key_exists('colspan', $td) ? 'colspan="' . $td['colspan'] . '"' : '';
                    $rowspan = array_key_exists('rowspan', $td) ? 'rowspan="' . $td['rowspan'] . '"' : '';
                    $class = array_key_exists('class', $td) ? 'class="' . $td['class'] . '"' : '';
                    $style = array_key_exists('style', $td) ? 'style="' . $td['style'] . '"' : '';
                    $result .= sprintf("<td %s %s %s %s>%s</td>", $colspan, $rowspan, $class, $style, $td['value']);
                }
                
                $result .= '</tr>';
            }
        }
        
        return $result;
    }
    
    private function _prepareTbody() {
        $i = 0;
        $perAverage = (int) $this->getDay();
        $colspan = 4 + $perAverage;
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
            'colspan' => $colspan,
            'class' => 'uppercase font-bold total'
        );
        $i++;
        
        /**
         * looping for subject (MO, MT)
         */
        foreach ($this->_subject as $subject) {
            $day = $this->getDay();
            $tbody[$i][] = array (
                'value' => $subject,
                'class' => 'font-bold'
            );
            $perDay = array ();
            //$totalRow = 0;
            $y = (int) $day;
            
            for ($x = 1; $x <= $y; $x++) {
                $perDay[] = $this->_getTotalPerDaySubject($reportService, $subject, $this->_leadingByZero($day));
                //$perDay[] = 0;
                $day--;
            }
            
            //total per row
            $tbody[$i][] = array (
                'value' => number_format(array_sum($perDay)),
                'class' => 'numeric'
            );
            
            //average per row
            $tbody[$i][] = array (
                'value' => number_format(floor((array_sum($perDay) / $perAverage))),
                'class' => 'numeric'
            );
            
            //monthend per row
            $tbody[$i][] = array (
                'value' => number_format(floor((array_sum($perDay) / $perAverage) * $this->getLastDay())),
                'class' => 'numeric'
            );
            
            foreach ($perDay as $value) {
                $tbody[$i][] = array (
                    'value' => number_format($value),
                    'class' => 'numeric'
                );
            }
            
            $i++;
        }
        
        /**
         * looping for delivery_status (delivered, gross revenue)
         */
        foreach ($this->_deliveryStatus as $deliveryStatus) {
            $day = $this->getDay();
            $grossRevenueClass = (strtolower($deliveryStatus) == 'gross revenue') ? 'revenue font-bold' : '';
            $tbody[$i][] = array (
                'value' => $deliveryStatus,
                'class' => 'font-bold ' . $grossRevenueClass
            );
            $perDay = array ();
            $y = (int) $day;
            
            for ($x = 1; $x <= $y; $x++) {
                $perDay[] = $this->_getTotalPerDayDeliveryStatus($reportService, $deliveryStatus, $this->_leadingByZero($day));
                $day--;
            }
            
            //total per row
            $tbody[$i][] = array (
                'value' => number_format(array_sum($perDay)),
                'class' => 'numeric ' . $grossRevenueClass
            );
            
            //average per row
            $tbody[$i][] = array (
                'value' => number_format(floor(array_sum($perDay) / $perAverage)),
                'class' => 'numeric ' . $grossRevenueClass
            );
            
            //monthend per row
            $tbody[$i][] = array (
                'value' => number_format(floor((array_sum($perDay) / $perAverage) * $this->getLastDay())),
                'class' => 'numeric ' . $grossRevenueClass
            );
            
            foreach ($perDay as $value) {
                $tbody[$i][] = array (
                    'value' => number_format($value),
                    'class' => 'numeric ' . $grossRevenueClass
                );
            }
            
            $i++;
        }
        
        /**
         * row per operator
         */
        $operators = $this->getComboboxOperator();
        
        foreach ($operators as $operator) {
            if ($this->checkOperatorAvailableReport($operator['id'], $reportService)) {
                $tbody[$i][] = array (
                    'value' => '&nbsp;',
                    'colspan' => $colspan,
                    'style' => 'padding-top:0;padding-bottom:0;'
                );
                $i++;
                $tbody[$i][] = array (
                    'value' => $operator['name'] . ' (' . $operator['long_name'] . ')',
                    'colspan' => $colspan,
                    'class' => 'uppercase font-bold total'
                );
                $i++;
                
                /**
                 * looping for subject (MO, MT) per Operator
                 */
                foreach ($this->_subject as $subject) {
                    $day = $this->getDay();
                    $tbody[$i][] = array (
                        'value' => $subject,
                        'class' => 'font-bold'
                    );
                    $perDay = array ();
                    $y = (int) $day;

                    for ($x = 1; $x <= $y; $x++) {
                        $perDay[] = $this->_getTotalPerDaySubject($reportService, $subject, $this->_leadingByZero($day), $operator['id']);
                        $day--;
                    }

                    //total per row
                    $tbody[$i][] = array (
                        'value' => number_format(array_sum($perDay)),
                        'class' => 'numeric'
                    );

                    //average per row
                    $tbody[$i][] = array (
                        'value' => number_format(floor((array_sum($perDay) / $perAverage))),
                        'class' => 'numeric'
                    );

                    //monthend per row
                    $tbody[$i][] = array (
                        'value' => number_format(floor((array_sum($perDay) / $perAverage) * $this->getLastDay())),
                        'class' => 'numeric'
                    );

                    foreach ($perDay as $value) {
                        $tbody[$i][] = array (
                            'value' => number_format($value),
                            'class' => 'numeric'
                        );
                    }

                    $i++;
                }
               
                /**
                 * looping for delivery_status (delivered, gross revenue) per Operator
                 */
                foreach ($this->_deliveryStatus as $deliveryStatus) {
                    $day = $this->getDay();
                    $grossRevenueClass = (strtolower($deliveryStatus) == 'gross revenue') ? 'revenue font-bold' : '';
                    $tbody[$i][] = array (
                        'value' => $deliveryStatus,
                        'class' => 'font-bold ' . $grossRevenueClass
                    );
                    $perDay = array ();
                    $y = (int) $day;

                    for ($x = 1; $x <= $y; $x++) {
                        $perDay[] = $this->_getTotalPerDayDeliveryStatus($reportService, $deliveryStatus, $this->_leadingByZero($day), $operator['id']);
                        $day--;
                    }

                    //total per row
                    $tbody[$i][] = array (
                        'value' => number_format(array_sum($perDay)),
                        'class' => 'numeric ' . $grossRevenueClass
                    );

                    //average per row
                    $tbody[$i][] = array (
                        'value' => number_format(floor(array_sum($perDay) / $perAverage)),
                        'class' => 'numeric ' . $grossRevenueClass
                    );

                    //monthend per row
                    $tbody[$i][] = array (
                        'value' => number_format(floor((array_sum($perDay) / $perAverage) * $this->getLastDay())),
                        'class' => 'numeric ' . $grossRevenueClass
                    );

                    foreach ($perDay as $value) {
                        $tbody[$i][] = array (
                            'value' => number_format($value),
                            'class' => 'numeric ' . $grossRevenueClass
                        );
                    }

                    $i++;
                }
            }
            
            continue;
        }
        
        return $tbody;
    }

    private function _getTotalPerDaySubject($reportService, $subject, $day, $operatorId = 0) {
        $result = 0;
        
        if (is_array($reportService) && count($reportService) > 0) {
            foreach ($reportService as $row) {
                $subjects = explode(';', $row['subject']);
                
                if (strtolower($subjects[0]) == strtolower($subject)) {
                    if ($operatorId == 0) {
                        if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                            $result += $row['total'];
                        }
                    }
                    else {
                        if ($operatorId == $row['operator_id']) {
                            if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                                $result += $row['total'];
                            }
                        }
                    }
                }
            }
        }
        
        return (int) $result;
    }
    
    private function _getTotalPerDayDeliveryStatus($reportService, $deliveryStatus, $day, $operatorId = 0) {
        $result = 0;
        $deliveryStatusArr = explode(' ', $deliveryStatus);
        
        if (is_array($reportService) && count($reportService) > 0) {
            foreach ($reportService as $row) {
                if (strtolower($row['delivery_status']) == strtolower(end($deliveryStatusArr))) {
                    if ($operatorId == 0) {
                        if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                            if (strtolower($row['delivery_status']) == 'revenue') {
                                $result += (int) $row['price'];
                            }
                            else {
                                $result += $row['total'];
                            }
                        }
                    }
                    else {
                        if ($operatorId == $row['operator_id']) {
                            if ($row['sumdate'] == sprintf("%s-%s", $this->_ajaxRequest['tdate'], $day)) {
                                if (strtolower($row['delivery_status']) == 'revenue') {
                                    $result += (int) $row['price'];
                                }
                                else {
                                    $result += $row['total'];
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return (int) $result;
    }
    
    private function checkOperatorAvailableReport($operatorId, $reportService) {
        foreach ($reportService as $rptService) {
            if ($rptService['operator_id'] == $operatorId) {
                return true;
            }
        }
        
        return false;
    }
    
    private function getMonth() {
        $month = $this->_month;
        
        if ($month != $this->_ajaxRequest['tdate']) {
            $month = $this->_ajaxRequest['tdate'];
        }
        
        return $month;
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
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxAdn();
    }
    
    private function getComboboxOperator() {
        $this->load->model($this->_comboboxModel);
        return $this->combobox_model->getComboboxOperator();
    }
}

/* End of file rptrevenue.php */
/* Location: ./application/controllers/report/rptrevenue.php */