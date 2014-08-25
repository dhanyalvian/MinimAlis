<?php
/**
 * Description of MY_Controller
 * 
 * @author dhanyalvian@gmail.com
 */

class MY_Controller extends CI_Controller {
    protected $_data = array ();
    
    /**
     * Page information
     */
    protected $_pageController = '';
    protected $_pageTitle = '';
    protected $_pageActive = '';
    protected $_pageViews = '';
    protected $_pageHeader = true;
    protected $_pageBreadcrumb = true;
    protected $_controllerExclude;
    protected $_controllerInclude;

    /**
     * CSS and JS handling
     */
    protected $_additionalCss = array ();
    protected $_additionalJs = array ();
    
    /**
     * User Permission handling
     */
    protected $_aclController = array ();

    /**
     * Ajax controller handling
     */
    protected $_isAjax = false;
    protected $_ajaxStatus = false;
    protected $_ajaxMessage = null;
    protected $_ajaxData = array ();
    protected $_ajaxRequest = array ();


    /**
     * Grid handling
     */
    protected $_gridId = '';
    protected $_columns = array ();
    
    /**
     * Form Validation handling
     */
    protected $_validateField = array ();
    protected $_validateError = array ();
    
    /**
     * Date Format
     */
    protected $dateFormatPhp = null;
    protected $dateTimeFormatPhp = null;
    
    /**
     * Combobox model data
     */
    protected $_comboboxModel = 'combobox_model';

    public function __construct() {
        parent::__construct();
        
        $this->load->model('navigation_model');
        
        $this->_controllerExclude = $this->config->item('exclude_checking_session');
        $this->_controllerInclude = $this->config->item('include_checking_session');
        
        $this->sessionRedirect();
        $this->getCollectionData();
        $this->aclRedirect();
        $this->dateFormatPhp = $this->config->item('date_format_php');
        $this->dateTimeFormatPhp = $this->config->item('date_time_format_php');
    }
    
    protected function sessionRedirect() {
        return true; //hardcode
        if (!in_array($this->_pageController, $this->_controllerExclude) || in_array($this->_pageController, $this->_controllerInclude)) {
            if (!$this->session->userdata('username')) {
                if ($this->_isAjax) {
                    $this->_ajaxStatus = false;
                    $this->_ajaxMessage = 'Session expired.';
                    $this->_ajaxData = array ('redirect' => base_url() . $this->config->item('logout_redirect'));
                }
                
                $urlEncode = $this->getUrlEncode($this->uri->uri_string());

                redirect(base_url() . $this->config->item('logout_redirect') . '?sid=' . $urlEncode);
            }
        }
    }
    
    protected function getUrlEncode($url) {
        return base64_encode($url);
    }
    
    protected function getUrlDecode($url) {
        return base64_decode($url);
    }

    protected function aclRedirect() {
        if (!in_array($this->_pageController, $this->_controllerExclude) && !in_array($this->_pageController, $this->_controllerInclude)) {
            if (!in_array($this->_pageController, $this->_aclController)) {
                redirect(base_url() . 'restricted');
            }
        }   
    }

    protected function getCollectionData() {
        $parentData = $this->getParentData();
        
        $this->_data['base_url'] = base_url();
        $this->_data['apps_title'] = $this->getConfigData('app_title');
        $this->_data['css_data'] = $this->getCssData();
        $this->_data['js_data'] = $this->getJsData();
        $this->_data['parent_title'] = $parentData['title'];
        $this->_data['parent_url'] = base_url() . $parentData['url'];
        $this->_data['page_title'] = $this->getPageTitle();
        $this->_data['page_active'] = $this->_pageActive;
        $this->_data['page_controller'] = $this->_pageController;
        $this->_data['page_is_report'] = $this->pageIsReport();
        $this->_data['page_header'] = $this->_pageHeader;
        $this->_data['page_views'] = $this->_pageViews;
        $this->_data['page_breadcrumb'] = $this->getPageBreadcrumb();
        $this->_data['header_skin'] = $this->config->item('header_skin') == 'black' ? 'navbar-inverse' : 'navbar-default';
        $this->_data['navigation'] = $this->getNavigation();
        $this->_data['sub_navigation'] = $this->getSubNavigation();
        $this->_data['home_url'] = base_url() . $this->config->item('home_url');
        $this->_data['user_fullname'] = $this->getUserFullname();
        $this->_data['profile_photo'] = $this->getPhotoProfile();
        $this->_data['footer_text'] = $this->config->item('footer_text');
    }

    protected function getCssData() {
        return array (
            'path' => str_replace('index.php/', '', base_url()) . $this->config->item('css_path'),
            'default' => $this->config->item('css_file'),
            'additional' => $this->_additionalCss
        );
    }
    
    protected function getJsData() {
        return array (
            'path_core' => str_replace('index.php/', '', base_url()) . $this->config->item('js_path_core'),
            'path_module' => str_replace('index.php/', '', base_url()) . $this->config->item('js_path_module'),
            'default_top' => $this->config->item('js_file_top'),
            'default_bottom' => $this->config->item('js_file_bottom'),
            'additional' => $this->_additionalJs
        );
    }
    
    protected function pageIsReport() {
        if ($this->_pageActive == 'report') {
            return true;
        }
        
        return false;
    }

    protected function getNavigationData($parent = 0) {
        //$this->load->model('navigation_model');
        $role = (int) $this->session->userdata('role');
        return $this->navigation_model->getNavigationData($role, $parent);
    }

    protected function getNavigation() {
        $result = array ();
        
        if (!in_array($this->_pageController, $this->_controllerExclude) || in_array($this->_pageController, $this->_controllerInclude)) {
            $rows = $this->getNavigationData();

            foreach ($rows as $row) {
                array_push($this->_aclController, $row->controller);
                
                if ($row->parent != 0) {
                    continue;
                }
                
                $result[] = array (
                    'id' => $row->id,
                    'controller' => $row->controller,
                    'title' => $row->title,
                    'url' => $row->url,
                    'display' => $row->display,
                    'sub_nav' => $this->getNavigationData($row->id)
                );
            }
        }
        
        return $result;
    }
    
    protected function getSubNavigation($controller = null) {
        $result = array ();
        $parentData = $this->getParentData($controller);
        $parentId = $parentData['id'];
        
        if ($parentId != 0) {
            $rows = $this->getNavigationData($parentId);

            foreach ($rows as $row) {
                array_push($this->_aclController, $row->controller);
                if ($row->display == 0) {
                    continue;
                }
                
                $result[] = array (
                    'id' => $row->id,
                    'controller' => $row->controller,
                    'title' => $row->title,
                    'url' => $row->url,
                    'sub_nav' => array ()
                );
            }
        }
        
        return $result;
    }
    
    protected function getParentData($controller = null) {
        if (is_null($controller)) {
            $controller = $this->_pageController;
        }
        
        return $this->navigation_model->getParent($controller);
    }

    protected function getPageTitle() {
        $pageTitle = $this->navigation_model->getPageTitle($this->_pageController);
        $this->_pageTitle = $pageTitle;
        
        return $pageTitle;
    }
    
    protected function getPageBreadcrumb() {
        $result = array ();
        
        if ($this->_pageBreadcrumb) {
            $result = array (
                array (
                    'title' => $this->_pageTitle,
                    'url' => ''
                )
            );
        }
        
        return $result;
    }

    protected function getUserFullname() {
        if (!$this->session->userdata('username')) {
            return '';
        }
        
        return $this->session->userdata('fullname');
    }
    
    protected function getPhotoProfile() {
        if (!$this->session->userdata('username')) {
            return '';
        }
        
        $path = $this->config->item('photo_path');
        $default = md5($this->config->item('photo_default'));
        $photo = md5($this->session->userdata('username'));
        $ext = $this->config->item('photo_ext');
        
        $pp = $path . $photo . $ext;
        
        if (file_exists($pp)) {
            return base_url() . $pp;
        }
        
        return base_url() . $path . $default . $ext;
    }

    /**
     * Ajax response handling
     */
    protected function _ajaxResponse() {
        $response = array (
            'status' => $this->_ajaxStatus,
            'message' => $this->_ajaxMessage,
            'data' => $this->_ajaxData
        );
        
        echo json_encode($response);
        exit;
    }
    
    /**
     * Grid handling
     */
    protected function _prepareGrid() {}
    
    protected function _generateGrid() {
        $this->_prepareGrid();
        $this->_data['grid_table'] = $this->_generateGridTable();
        $this->_data['grid_column'] = count($this->_columns);
    }
    
    protected function _generateGridTable() {
        $result = sprintf("<table id=\"%s\" class=\"table table-bordered table-hover table-striped\">", $this->_gridId);
        $result .= $this->_generateGridThead();
        $result .= $this->_generateGridTbody();
        $result .= $this->_generateGridTfoot();
        $result .= "</table>";
        
        return $result;
    }

    protected function _generateGridThead() {
        $result = '';
        
        if (is_array($this->_columns) && count($this->_columns) > 0) {
            $result .= "<thead><tr>";
            
            foreach ($this->_columns as $column) {
                $title = $column['title'] ? $column['title'] : ''; 
                $align = isset ($column['align']) ? sprintf("text-align:%s;", $column['align']) : "";
                $width = isset ($column['width']) ? sprintf("width:%s;", $column['width']) : "";
                $style = $align . $width;
                        
                $result .= sprintf("<th style=\"%s\">%s</th>", $style, $title);
            }
            
            $result .= "</tr></thead>";
        }
        
        return $result;
    }
    
    protected function _generateGridTbody() {
        $result = sprintf("<tbody><tr><td colspan=\"%d\">No records found.</td></tr></tbody>", count($this->_columns));
        
        return $result;
    }
    
    protected function _generateGridTfoot() {
        $result = sprintf("<tfoot><tr><td colspan=\"%d\">", count($this->_columns));
        $result .= "<div id=\"gridPaging\" class=\"pull-left\">Page <span></span></div>";
        $result .= "<div id=\"gridRecord\" class=\"pull-right\"><span id=\"from\">0</span> - <span id=\"to\">0</span> of <span id=\"total\">0</span> records</div>";
        $result .= "<div class=\"clearfix\"></div>";
        $result .= "</td></tr></tfoot>";
        
        return $result;
    }

    protected function _addGridColumn($data) {
        if (is_array($data)) {
            array_push($this->_columns, $data);
        }
    }
    
    protected function _generateButtonRow($url, $label, $marginLeft = false) {
        $buttonClass = $marginLeft ? "margin-left-5px" : "";
        return sprintf("<span class=\"%s\"><a href=\"%s\" class=\"btn btn-primary btn-xs\">%s</a></span>", $buttonClass, $url, $label);
    }
    
    protected function _generateEmptyRow($colspan) {
        return sprintf("<tr><td colspan=\"%d\">%s</td></tr>", $colspan, NO_RECORD_FOUND);
    }
    
    protected function _checkArrayWithData($data) {
        if (is_array($data) && count($data) > 0) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Form Validation handling
     */
    protected function _validateData() {
        foreach ($this->_validateField as $field) {
            if (form_error($field)) {
                $this->_validateError[] = array ($this->_arrayToId($field) => form_error($field));
            }
        }
        
        $this->_ajaxStatus = false;
        $this->_ajaxMessage = 'error';
        $this->_ajaxData = $this->_validateError;
    }
    
    protected function _arrayToId($text) {
        $result = str_replace('[', '_', $text);
        $result = str_replace(']', '', $result);
        
        return $result;
    }
    
    protected function _leadingByZero($number) {
        if (strlen($number) == 1) {
            return '0' . $number;
        }
        
        return $number;
    }
    
    protected function getConfigData($filter) {
        $this->load->model('config_model');
        return $this->config_model->getConfigData($filter);
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */