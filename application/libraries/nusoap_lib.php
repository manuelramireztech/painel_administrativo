<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nusoap_lib
{
   function Nusoap_lib()
   {
       ini_set('include_path',ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries/nusoap/nusoap.php');
   }
}
?>