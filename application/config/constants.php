<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('NOME_CLIENTE', 'EMPRESA');
define('ESTADOS', 'a:27:{s:2:"AC";s:4:"Acre";s:2:"AL";s:7:"Alagoas";s:2:"AM";s:8:"Amazonas";s:2:"AP";s:6:"Amapá";s:2:"BA";s:5:"Bahia";s:2:"CE";s:6:"Ceará";s:2:"DF";s:16:"Distrito Federal";s:2:"ES";s:15:"Espírito Santo";s:2:"GO";s:6:"Goiás";s:2:"MA";s:9:"Maranhão";s:2:"MT";s:11:"Mato Grosso";s:2:"MS";s:18:"Mato Grosso do Sul";s:2:"MG";s:12:"Minas Gerais";s:2:"PA";s:5:"Pará";s:2:"PB";s:8:"Paraíba";s:2:"PR";s:7:"Paraná";s:2:"PE";s:10:"Pernambuco";s:2:"PI";s:6:"Piauí";s:2:"RJ";s:14:"Rio de Janeiro";s:2:"RN";s:19:"Rio Grande do Norte";s:2:"RO";s:9:"Rondônia";s:2:"RS";s:17:"Rio Grande do Sul";s:2:"RR";s:7:"Roraima";s:2:"SC";s:14:"Santa Catarina";s:2:"SE";s:7:"Sergipe";s:2:"SP";s:10:"São Paulo";s:2:"TO";s:9:"Tocantins";}');
define('DIAS_SEMANA', 'a:7:{i:0;s:7:"Domingo";i:1;s:13:"Segunda-Feira";i:2;s:12:"Terça-Feira";i:3;s:12:"Quarta-Feira";i:4;s:12:"Quinta-Feira";i:5;s:11:"Sexta-Feira";i:6;s:7:"Sábado";}');
define('IS_LOCALHOST', strpos($_SERVER['SERVER_NAME'], 'localhost') === FALSE ? FALSE : TRUE);
/* End of file constants.php */
/* Location: ./application/config/constants.php */