<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    protected function loadTemplatePainel($view = NULL, $vars = array(), $return = FALSE) {
        if (empty($view))
            $view = 'template/painel';

        if (!isset($vars['title']))
            $vars['title'] = NOME_CLIENTE;

        $vars['vPainelPermissao'] = $this->auth->vPermissaoPainel;
        $vars['vPainel'] = $this->session->userdata('painel');
        $vars['bPainelNav'] = $this->session->userdata('painel_nav');
        $this->load->view($view, $vars, $return);
    }

    protected function loadTemplateSite($view = NULL, $vars = array(), $return = FALSE) {
        if (empty($view))
            $view = 'template/site';

        if (!isset($vars['title']))
            $vars['title'] = NOME_CLIENTE;

        $this->load->view($view, $vars, $return);
    }

}
