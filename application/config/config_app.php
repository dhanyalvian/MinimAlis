<?php
/**
 * Configuration Application
 */
$config['exclude_checking_session'] = array ('login');
$config['include_checking_session'] = array ('restricted');
$config['apps_title'] = 'MinimAlis';
$config['css_path'] = 'assets/css/';
$config['css_file'] = array (
    'bootstrap',
    'font-awesome.min',
    'styles',
    'themes',
);
$config['js_path_core'] = 'assets/js/core/';
$config['js_path_module'] = 'assets/js/module/';
$config['js_file_top'] = array ();
$config['js_file_bottom'] = array (
    'jquery-2.1.1.min',
    'bootstrap.min',
    'flot',
    'flot.categories',
    'script',
);
$config['home_url'] = 'dashboard';
$config['header_skin'] = 'silver'; //black or silver
$config['photo_path'] = 'assets/photos/';
$config['photo_ext'] = '.jpg';
$config['photo_default'] = 'default';
$config['footer_text'] = 'Messaging CMS &copy; 2013';

/**
 * Random Password
 */
$config['default_password'] = 'messaging123';

/**
 * Database Table CMS
 */
$config['tbl_navigation'] = 'navigation';
$config['tbl_users'] = 'users';
$config['tbl_roles'] = 'roles';
$config['tbl_config_data'] = 'config_data';

/**
 * Database Table Core
 */
$config['tbl_core_handler'] = 'custom_handler';
$config['tbl_core_module'] = 'module';
$config['tbl_core_charging'] = 'charging';
$config['tbl_core_operator'] = 'operator';
$config['tbl_core_adn'] = 'adn';
$config['tbl_core_test_number'] = 'test_number';
$config['tbl_core_message_reply'] = 'message_reply';
$config['tbl_core_manage_reply'] = 'manage_reply';
$config['tbl_core_service'] = 'service';
$config['tbl_core_keyword'] = 'keyword';
$config['tbl_core_mechanism'] = 'mechanism';
$config['tbl_core_reply'] = 'reply';
$config['tbl_core_reply_attribute'] = 'reply_attribute';
$config['tbl_core_attribute'] = 'attribute';
$config['tbl_core_service_charging_mapping'] = 'service_charging_mapping';
$config['tbl_core_service_operator_mapping'] = 'service_operator_mapping';
$config['tbl_core_service_setting'] = 'service_setting';

/**
 * Database Table Push
 */
$config['tbl_push_content'] = 'push_content';
$config['tbl_push_schedule'] = 'push_schedule';
$config['tbl_push_buffer'] = 'push_buffer';
$config['tbl_push_project'] = 'push_projects';

/**
 * Database Table Report
 */
$config['tbl_report_mo'] = 'rpt_mo';
$config['tbl_report_service'] = 'rpt_service2';
$config['tbl_report_subscription'] = 'rpt_subscription';

/**
 * Service Keyword
 */
$config['service_keyword_status'] = array (
    1 => 'launched',
    2 => 'deleted',
    3 => 'test'
);
$config['path_ini_file'] = '../../base/%s/service/reply/%s.ini';

/**
 * Charging SenderType & MessageType
 */
$config['charging_sender_type'] = array ('mo', 'option', 'wappush', 'text', 'sms', 'push');
$config['charging_message_type'] = array ('dailypush', 'dailywappush', 'mo', 'mtpull', 'mtpush', 'option', 'sms', 'wappush');

/**
 * MO
 */
$config['mo_type'] = array ('confirm', 'reg', 'unreg');

/**
 * Date Format
 */
$config['date_format_php'] = 'm/d/Y g:i A';
$config['date_time_format_php'] = 'd-M-Y h:i A';
$config['date_format_mysql'] = '%m/%d/%Y %h:%i %p';
$config['date_time_format_mysql'] = '%d-%b-%Y %h:%i %p';

/**
 * Report
 */
$config['year_start'] = 2007;
$config['year_range'] = 20;

/* End of file config_app.php */
/* Location: ./application/config/config_app.php */
