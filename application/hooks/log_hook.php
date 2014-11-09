<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/profile/view?id=260417728&trk=spm_pic
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
class log_hook {

    private $ci;

    public function __construct() {
        $this->ci = &get_instance();
    }

    function registrar() {
        $sModule = $this->ci->router->fetch_module();
        $sClass = $this->ci->router->class;
        $sMethod = $this->ci->router->method;
        $roMetodo = $this->ci->metodo_model->getAll(array('modulo' => $sModule, 'classe' => $sClass, 'metodo' => $sMethod));

        if ($roMetodo->num_rows() > 0) {
            $oMetodo = $roMetodo->row(0);
            if ($oMetodo->privado) {
                $vDados = $this->ci->input->post(NULL, TRUE);
                if (isset($vDados['senha']))
                    unset($vDados['senha']);
                if (isset($vDados['confirmar_senha']))
                    unset($vDados['confirmar_senha']);
                
                $this->ci->log_model->saveLog($vDados);
            }
        }
    }

}
