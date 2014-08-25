<?php
/**
 * Description of Keyword
 * 
 * @author  dhanyalvian@gmail.com
 */

class Keyword extends MY_Controller {
    protected $_pageController = 'keyword';
    protected $_pageTitle = 'Keyword';
    protected $_pageActive = 'services';
    protected $_pageViews = 'services/keyword';
    protected $_pageBreadcrumb = false;
    protected $_additionalCss = array ('bootstrap.dataTables');
    protected $_additionalJs = array ('jquery.dataTables.min', 'jquery.dataTables.paging.min', 'keyword');
    protected $_keywordModel = 'services/keyword_model';
    
    protected $serviceIdSegment = 4;

    public function __construct() {
        parent::__construct();
        
        $this->load->model($this->_keywordModel);
        $this->load->model('combobox_model');
    }
    
    public function index() {
        $serviceId = $this->uri->segment($this->serviceIdSegment);
        
        if (empty ($serviceId)) {
            redirect(base_url() . 'services/service');
        }
        
        $serviceAdn = $this->getComboboxService($serviceId);
        $this->_data['service_id'] = $serviceId;
        $this->_data['service_name'] = $serviceAdn[0]['name'];
        $this->_data['service_adn'] = sprintf("%s [%s]", $serviceAdn[0]['name'], $serviceAdn[0]['adn']);
        $this->_data['adn'] = $serviceAdn[0]['adn'];
        $this->_data['operator'] = $this->getComboboxOperator();
        $this->_data['handler'] = $this->getComboboxHandler();
        $this->load->view('structure', $this->_data);
    }
    
    public function addedit() {
        $serviceId = $this->uri->segment($this->serviceIdSegment);
        
        if (empty ($serviceId)) {
            redirect(base_url() . 'services/service');
        }
        
        $serviceAdn = $this->getComboboxService($serviceId);
        $this->_additionalJs = array ('keyword_addedit');
        $this->_data['js_data'] = $this->getJsData();
        $this->_data['service_id'] = $serviceId;
        $this->_data['service_name'] = $serviceAdn[0]['name'];
        $this->_data['service_adn'] = sprintf("%s [%s]", $serviceAdn[0]['name'], $serviceAdn[0]['adn']);
        $this->_data['adn'] = $serviceAdn[0]['adn'];
        $this->_data['operators'] = $this->getComboboxOperator();
        $this->_data['chargings'] = json_encode($this->getComboboxCharging());
        $this->_data['modules'] = json_encode($this->getComboboxModule());
        $this->_data['page_views'] = 'services/keyword_addedit';
        $this->load->view('structure', $this->_data);
    }
    
    public function getGridDataTables() {
        $serviceId = $this->input->post('service_id', true);
        $this->load->model($this->_keywordModel);
        $keywordData = $this->keyword_model->getGridDataTables($serviceId);
        $keywordDataChild = $this->keyword_model->getGridDataTablesChild($serviceId);
        $result = '';
        
        if (is_array($keywordData) && count($keywordData) > 0) {
            foreach ($keywordData as $keyword) {
                $result .= '<tr>';
                $result .= '<td class="striped">' . $keyword['pattern'] . '</td>';
                $result .= '<td class="striped align-center">' . $this->getGridDataTablesAction($serviceId, $keyword['pattern']) . '</td>';
                $result .= '</tr>';
                
                $result .= $this->getKeywordPerOperator($keyword, $keywordDataChild);
            }
        }
        else {
            $result .= '<tr><td colspan="2">No data found.</td></tr>';
        }
        
        $this->_ajaxStatus = true;
        $this->_ajaxData = $result;
        $this->_ajaxResponse();
    }
    
    protected function getGridDataTablesAction($serviceId, $pattern) {
        $result = '<div class="btn-group">';
        $result .= '<a class="btn btn-default btn-xs" href="#">Add Operator</a>';
                    
        $result .= "<a class=\"btn btn-default btn-xs\" onclick=\"javascript: deleteKeywordByPattern(".$serviceId.", '".$pattern."');\">Delete</a>";
        $result .= '</div>';
       
       return $result;
    }
    
    protected function getKeywordPerOperator($keyword, $keywordDataChild) {
        $result = '';
        
        foreach ($keywordDataChild as $keywordChild) {
            if ($keywordChild['service_id'] == $keyword['service_id'] && $keywordChild['pattern'] == $keyword['pattern']) {
                $result .= '<tr>';
                $result .= '<td><span class="padding-left-15px">' . $keywordChild['operator_name'] . '</span></td>';
                $result .= '<td class="align-center">' . $this->getGridDataTablesChildAction($keywordChild['id']) . '</td>';
                $result .= '</tr>';
            }
        }
        
        return $result;
    }
    
    protected function getGridDataTablesChildAction($mechanismId) {
        $result = '<div class="btn-group">';
        $result .= '<a class="btn btn-default btn-xs" href="#">Edit</a>';
                    
        $result .= "<a class=\"btn btn-default btn-xs\" onclick=\"javascript: deleteKeywordByOperator(" . $mechanismId . ");\">Delete</a>";
        $result .= '</div>';
       
       return $result;
    }
    
    public function deleteKeywordByPattern() {
        $serviceId = $this->input->post('service_id', true);
        $pattern = $this->input->post('pattern', true);
        $result = $this->keyword_model->deleteKeywordByPattern($serviceId, $pattern);
        
        if ($result) {
            $this->_ajaxStatus = true;
            $this->_ajaxMessage = sprintf("Delete keyword '%s' successfully.", $pattern);
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = sprintf("Delete keyword '%s' failed.", $pattern);
        }
        
        $this->_ajaxResponse();
    }
    
    public function deleteKeywordByOperator() {
        $mechanismId = $this->input->post('mechanism_id', true);
        $result = $this->keyword_model->deleteKeywordByOperator($mechanismId);
        
        if ($result) {
            $this->_ajaxStatus = true;
            $this->_ajaxMessage = sprintf("Delete keyword (id: %s) successfully.", $mechanismId);
        }
        else {
            $this->_ajaxStatus = false;
            $this->_ajaxMessage = sprintf("Delete keyword (id: %s) failed.", $mechanismId);
        }
        
        $this->_ajaxResponse();
    }
    
    public function saveStep1() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->_validateField = array ('keyword', 'operator');
        
        $this->form_validation->set_rules('operator', 'Operator', 'required');
        
        if ($this->input->post('action', true) == 'add') {
            $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|min_length[1]|max_length[20]|xss_clean');
        }
        else {
            $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|min_length[1]|max_length[20]|xss_clean');
        }
        
        if ($this->form_validation->run()) {
            $this->_ajaxStatus = true;
            $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'step 1 complete.' : 'Keyword successfully updated.';
            $this->_ajaxData = array (
                'post' => $this->input->post(),
                //'module' => $this->getComboboxModule()
                //'handler' => $this->getComboboxHandler(),
                //'reply_charging' => $this->getMessageReplyCharging()
                //'inifile' => $this->getIniFile(),
                //'charging' => $this->getComboboxCharging()
            );
        }
        else {
            $this->_validateData();
        }
        
        $this->_ajaxResponse();
    }
    
    public function saveStep2() {
        $errorStatus = false;
        $errorMessage = null;
        $service = $this->input->post('service', true);
        $adn = $this->input->post('adn', true);
        $keyword = $this->input->post('keyword', true);
        $operators = $this->input->post('operator', true);
        $operatorArr = explode(',', $operators);
        $handlerType = $this->input->post('handler_type', true);
        $moduleCreator = $this->input->post('module_creator', true);
        $chargingId = $this->input->post('charging', true);
        $message = $this->input->post('message', true);
        $status = $this->input->post('status', true);
        $dateCreated = date('Y-m-d H:i:s');
        $dateModified = date('Y-m-d H:i:s');
        
        /**
         * insert to table mechanism
         */
        if (is_array($operatorArr) && count($operatorArr) > 0) {
            $mechanismId = 0;
            $moduleCreatorArr = $this->getComboboxModule();
            $attributeArr = $this->getComboboxAttribute();
            
            foreach ($operatorArr as $operator) {
                $mechanismData = array (
                    'pattern' => $keyword,
                    'operator_id' => $operator,
                    'service_id' => $service,
                    'handler' => $this->getHandler($handlerType[$operator]),
                    'date_created' => $dateCreated,
                    'date_modified' => $dateModified,
                    'status' => $status[$operator]
                );
                $mechanismId = $this->keyword_model->saveMechanism($mechanismData);
                
                if ($mechanismId != 0) {
                    if (is_array($moduleCreator[$operator]) && count($moduleCreator[$operator]) > 0) {
                        foreach ($moduleCreator[$operator] as $index => $module) {
                            $replyData = array (
                                'mechanism_id' => $mechanismId,
                                'module_id' => $this->getModuleId($moduleCreatorArr, $module),
                                'charging_id' => $chargingId[$operator][$index],
                                'subject' => ' ',
                                'message' => $message[$operator][$index]
                            );
                            $replyId = $this->keyword_model->saveReply($replyData);
                            
                            if ($replyId != 0) {
                                // continue to save reply_attribute (not yet)
                                continue;
                                //$attribute
                            }
                            else {
                                $errorStatus = true;
                                $errorMessage = 'save reply failed';
                                break;
                            }
                        }
                    }
                }
                else {
                    $errorStatus = true;
                    $errorMessage = 'save mechanism failed';
                    break;
                }
            }
        }
                
        $this->_ajaxStatus = $errorStatus ? false : true;
        $this->_ajaxMessage = $errorMessage;
        $this->_ajaxData = array ('post' => $this->input->post());
        $this->_ajaxResponse();
    }
    
    protected function getHandler($handlerType) {
        if ($handlerType == 'creator') {
            return 'service_creator_handler';
        }
        
        return $handlerType;
    }

    protected function getModuleId($moduleCreatorArr, $moduleName) {
        $result = 0;
        
        if (is_array($moduleCreatorArr) && count($moduleCreatorArr) > 0) {
            foreach ($moduleCreatorArr as $moduleCreator) {
                if ($moduleName == $moduleCreator['name']) {
                    $result = $moduleCreator['id'];
                    break;
                }
            }
        }
        
        return $result;
    }

    public function getComboboxService($serviceId) {
        return $this->keyword_model->getComboboxService($serviceId);
    }
    
    protected function getComboboxOperator() {
        return $this->combobox_model->getComboboxOperator();
    }
    
    protected function getComboboxCharging() {
        return $this->combobox_model->getComboboxCharging();
    }
    
    protected function getComboboxHandler() {
        return $this->combobox_model->getComboboxHandler();
    }
    
    protected function getComboboxModule() {
        return $this->combobox_model->getComboboxModule();
    }
    
    protected function getComboboxAttribute() {
        return $this->combobox_model->getComboboxAttribute();
    }
    
//    public function ajaxOperatorChange() {
//        $result = $this->keyword_model->getMessageReplyCharging();
//        
//        
//        if ($result !== false) {
//            $this->_ajaxStatus = true;
//            $this->_ajaxMessage = 'Found';
//            $this->_ajaxData = $result;
//        }
//        else {
//            $this->_ajaxStatus = false;
//            $this->_ajaxMessage = 'Not found';
//        }
//        
//        $this->_ajaxResponse();
//    }
//    
//    public function save() {
//        $this->load->library('form_validation');
//        $this->form_validation->set_error_delimiters('', '');
//        $this->_validateField = array ('service', 'pattern', 'operator', 'handler', 'reply_charging');
//        
//        if ($this->input->post('action', true) == 'add') {
//            $this->form_validation->set_rules('service', 'Service', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('pattern', 'Pattern', 'trim|required|xss_clean|callback_pattern_check');
//            $this->form_validation->set_rules('operator', 'Operator', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('reply_charging', 'Reply/Charging', 'trim|required|xss_clean');
//        }
//        else {
//            $this->form_validation->set_rules('service', 'Service', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('pattern', 'Pattern', 'trim|required|xss_clean|callback_pattern_check_edit');
//            //$this->form_validation->set_rules('operator', 'Operator', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('handler', 'Handler', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('reply_charging', 'Reply/Charging', 'trim|required|xss_clean');
//        }
//        
//        if ($this->form_validation->run()) {
//            $this->load->model($this->_keywordModel);
//            $result = $this->keyword_model->save();
//            
//            if ($result) {
//                $this->_ajaxStatus = true;
//                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Pattern successfully added.' : 'Pattern successfully updated.';
//            }
//            else {
//                $this->_ajaxStatus = false;
//                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'New Pattern failed added.' : 'Pattern failed updated.';
//            }
//        }
//        else {
//            $this->_validateData();
//        }
//        
//        $this->_ajaxResponse();
//    }
//    
//    public function edit() {
//        $id = $this->input->post('id', true);
//        $this->load->model($this->_keywordModel);
//        $row = $this->keyword_model->edit($id);
//        
//        if (is_array($row) && count($row) > 0) {
//            $this->_ajaxStatus = true;
//            $this->_ajaxData = $row;
//        }
//        else {
//            $this->_ajaxStatus = false;
//            $this->_ajaxMessage = 'Get data failed';
//        }
//        
//        $this->_ajaxResponse();
//    }
//    
//    public function pattern_check($value) {
//        $this->load->model($this->_keywordModel);
//        $serviceId = $this->input->post('service', true);
//        $operator = $this->input->post('operator', true);
//        
//        /**
//         * jika operator belum dipilih, validasi ok
//         */
//        if (empty ($operator) || $operator == '') {
//            return true;
//        }
//        
//        if ($this->keyword_model->checkPatternExist($value, $serviceId, $operator)) {
//            $this->form_validation->set_message('pattern_check', 'The %s already exist');
//            
//            return false;
//        }
//        
//        return true;
//    }
//    
//    public function pattern_check_edit($value) {
//        $this->load->model($this->_keywordModel);
//        $serviceId = $this->input->post('service', true);
//        $operator = $this->input->post('edit_operator', true);
//        $edit_pattern = $this->input->post('edit_pattern', true);
//        
//        if ($this->keyword_model->checkPatternExist($value, $serviceId, $operator, $edit_pattern)) {
//            $this->form_validation->set_message('pattern_check_edit', 'The %s already exist');
//            
//            return false;
//        }
//        
//        return true;
//    }
//    
//    public function operator_check($value) {
//        $this->load->model($this->_keywordModel);
//        $serviceId = $this->input->post('service', true);
//        $pattern = $this->input->post('pattern', true);
//        
//        if ($this->keyword_model->checkOperatorExist($value, $serviceId, $pattern)) {
//            $this->form_validation->set_message('operator_check', 'The %s already exist');
//            
//            return false;
//        }
//        
//        return true;
//    }
//    
//    public function operator_check_edit($value) {
//        $this->load->model($this->_keywordModel);
//        $serviceId = $this->input->post('service', true);
//        $pattern = $this->input->post('pattern', true);
//        $edit_operator = $this->input->post('edit_operator', true);
//        
//        if ($this->keyword_model->checkOperatorExist($value, $serviceId, $pattern, $edit_operator)) {
//            $this->form_validation->set_message('operator_check_edit', 'The %s already exist');
//            
//            return false;
//        }
//        
//        return true;
//    }
//    
//    public function saveStep1() {
//        $this->load->library('form_validation');
//        $this->form_validation->set_error_delimiters('', '');
//        $this->_validateField = array ('keyword', 'operator');
//        
//        $this->form_validation->set_rules('operator', 'Operator', 'required');
//        
//        if ($this->input->post('action', true) == 'add') {
//            $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|min_length[1]|max_length[20]|xss_clean');
//        }
//        else {
//            $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|min_length[1]|max_length[20]|xss_clean');
//        }
//        
//        if ($this->form_validation->run()) {
//            $this->_ajaxStatus = true;
//            $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'step 1 complete.' : 'Keyword successfully updated.';
//            $this->_ajaxData = array (
//                'post' => $this->input->post(),
//                //'handler' => $this->getComboboxHandler(),
//                //'reply_charging' => $this->getMessageReplyCharging()
//                //'inifile' => $this->getIniFile(),
//                //'charging' => $this->getComboboxCharging()
//            );
//        }
//        else {
//            $this->_validateData();
//        }
//        
//        $this->_ajaxResponse();
//    }
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    
//    public function keyword_check_edit($value) {
//        $this->load->model($this->_keywordModel);
//        $serviceId = $this->input->post('service', true);
//        
//        if ($this->keyword_model->checkKeywordExist($value, $serviceId, $this->input->post('edit_keyword', true))) {
//            $this->form_validation->set_message('keyword_check_edit', 'The %s "' . $value . '" already exist');
//            
//            return false;
//        }
//        
//        return true;
//    }
//    
//    
//    //---------------------------------------------------------------------------------------//
//    
//    
//    
//    
////    public function pattern_check($value) {
////        $this->load->model($this->_keywordModel);
////        $serviceAdn = explode('_', $this->input->post('service_adn', true));
////        $serviceId = $serviceAdn[0];
////        
////        if ($this->keyword_model->checkPatternExist($value, $serviceId)) {
////            $this->form_validation->set_message('pattern_check', 'The %s "' . $value . '" already exist');
////            
////            return false;
////        }
////        
////        return true;
////    }
//    
//    public function saveStep2() {
//        $this->load->library('form_validation');
//        $this->form_validation->set_error_delimiters('', '');
//        $this->_validateField = array ('pattern', 'operator');
//        
//        
//        if ($this->input->post('action', true) == 'add') {
//            $this->form_validation->set_rules('pattern', 'Pattern', 'trim|required|min_length[1]|max_length[20]|xss_clean|callback_pattern_check');
//        }
//        else {
//            $this->form_validation->set_rules('pattern', 'Pattern', 'required');
//        }
//        
//        $this->form_validation->set_rules('operator', 'Operator', 'required');
//        
//        foreach ($this->input->post('operator', true) as $value) {
//            array_push($this->_validateField, 'reply_charging['.$value.']');
//            $this->form_validation->set_rules('reply_charging['.$value.']', 'Reply/Charging', 'required');
//        }
//        
//        /**
//         * Form validation is OK
//         */
//        if ($this->form_validation->run()) {
//            $this->load->model($this->_keywordModel);
//            $result = $this->keyword_model->save();
//
//            if ($result) {
//                $serviceAdn = $this->input->post('service_adn', true);
//                $serviceAdnArr = explode('_', $serviceAdn);
//                $serviceId = $serviceAdnArr[0];
//
//                $this->_ajaxStatus = true;
//                $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'Keyword successfully added.' : 'Keyword successfully updated.';
//                $this->_ajaxData = array ('redirect' => base_url() . 'services/keyword/index/' . $serviceId);
//                $this->session->set_flashdata('success', $this->_ajaxMessage);
//            }
//            else {
//                $this->_ajaxStatus = false;
//                $this->_ajaxMessage = $this->session->flashdata('error');
//            }
//        }
//        else {
//            $this->_validateData();
//        }
//        
//        $this->_ajaxResponse();
//        exit;
//        
//        
//        
//        if ($this->input->post('action', true) == 'add') {
//            $this->form_validation->set_rules('pattern', 'Pattern', 'trim|required|min_length[1]|max_length[20]|xss_clean|callback_pattern_check');
//        }
//            
//        $this->load->model($this->_keywordModel);
//        $result = $this->keyword_model->save();
//        
//        if ($result) {
//            $serviceAdn = $this->input->post('service_adn', true);
//            $serviceAdnArr = explode('_', $serviceAdn);
//            $serviceId = $serviceAdnArr[0];
//        
//            $this->_ajaxStatus = true;
//            $this->_ajaxMessage = $this->input->post('action', true) == 'add' ? 'Keyword successfully added.' : 'Keyword successfully updated.';
//            $this->_ajaxData = array ('redirect' => base_url() . 'services/keyword/index/' . $serviceId);
//            $this->session->set_flashdata('success', $this->_ajaxMessage);
//        }
//        else {
//            $this->_ajaxStatus = false;
//            $this->_ajaxMessage = $this->session->flashdata('error');
//        }
//        
//        $this->_ajaxResponse();
//    }
//    
//    protected function getMessageReplyCharging() {
//        $this->load->model($this->_keywordModel);
//        $serviceAdn = explode('_', $this->input->post('service_adn', true));
//        $serviceId = $serviceAdn[0];
//        $operators = $this->input->post('operator', true);
//        $messageReplyCharging = $this->keyword_model->getMessageReplyCharging($serviceId, $operators);
//        $result = array ();
//        
//        foreach ($operators as $operator) {
//            $operatorCheck = false;
//            
//            if (is_array($messageReplyCharging) && count($messageReplyCharging) > 0) {
//                foreach ($messageReplyCharging as $row) {
//                    if ($operator == $row['operator']) {
//                        $result[] = array (
//                            'operator' => $operator,
//                            'operator_id' => $row['operator'],
//                            'label' => 'found'
//                        );
//                        $operatorCheck = true;
//                        break;
//                    }
//                }
//            }
//            
//            if (!$operatorCheck) {
//                $result[] = array (
//                    'operator' => $operator,
//                    'operator_id' => '',
//                    'label' => 'not found'
//                );
//            }
//            
//        }
//        
//        return $result;
//    }
//    
//    protected function getKeywordOperator($serviceId, $pattern) {
//        $this->load->model($this->_keywordModel);
//        return $this->keyword_model->getKeywordOperator($serviceId, $pattern);
//    }
//    
//    public function delete() {
//        $id = $this->input->post('id', true);
//        $this->load->model($this->_keywordModel);
//        $result = $this->keyword_model->delete($id);
//        
//        if ($result) {
//            $this->_ajaxStatus = true;
//        }
//        else {
//            $this->_ajaxStatus = false;
//            $this->_ajaxMessage = 'Delete Service failed';
//        }
//        
//        $this->_ajaxResponse();
//    }
}

/* End of file keyword.php */
/* Location: ./application/controllers/services/keyword.php */