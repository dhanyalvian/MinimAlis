<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = true;
$default_host = 'localhost';
$default_user = 'root';
$default_pass = 'abcd1234';

$db['default']['hostname'] = $default_host;
$db['default']['username'] = $default_user;
$db['default']['password'] = $default_pass;
$db['default']['database'] = 'minimalis';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = false;
$db['default']['db_debug'] = false;
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = true;
$db['default']['stricton'] = false;

//$db['core']['hostname'] = $default_host;
//$db['core']['username'] = $default_user;
//$db['core']['password'] = $default_pass;
//$db['core']['database'] = 'tdz_core';
//$db['core']['dbdriver'] = 'mysql';
//$db['core']['dbprefix'] = '';
//$db['core']['pconnect'] = false;
//$db['core']['db_debug'] = false;
//$db['core']['cache_on'] = false;
//$db['core']['cachedir'] = '';
//$db['core']['char_set'] = 'utf8';
//$db['core']['dbcollat'] = 'utf8_general_ci';
//$db['core']['swap_pre'] = '';
//$db['core']['autoinit'] = true;
//$db['core']['stricton'] = false;

//$db['push']['hostname'] = $default_host;
//$db['push']['username'] = $default_user;
//$db['push']['password'] = $default_pass;
//$db['push']['database'] = 'tdz_push';
//$db['push']['dbdriver'] = 'mysql';
//$db['push']['dbprefix'] = '';
//$db['push']['pconnect'] = false;
//$db['push']['db_debug'] = false;
//$db['push']['cache_on'] = false;
//$db['push']['cachedir'] = '';
//$db['push']['char_set'] = 'utf8';
//$db['push']['dbcollat'] = 'utf8_general_ci';
//$db['push']['swap_pre'] = '';
//$db['push']['autoinit'] = true;
//$db['push']['stricton'] = false;

//$db['report']['hostname'] = $default_host;
//$db['report']['username'] = $default_user;
//$db['report']['password'] = $default_pass;
//$db['report']['database'] = 'tdz_report';
//$db['report']['dbdriver'] = 'mysql';
//$db['report']['dbprefix'] = '';
//$db['report']['pconnect'] = false;
//$db['report']['db_debug'] = false;
//$db['report']['cache_on'] = false;
//$db['report']['cachedir'] = '';
//$db['report']['char_set'] = 'utf8';
//$db['report']['dbcollat'] = 'utf8_general_ci';
//$db['report']['swap_pre'] = '';
//$db['report']['autoinit'] = true;
//$db['report']['stricton'] = false;

/* End of file database.php */
/* Location: ./application/config/database.php */
