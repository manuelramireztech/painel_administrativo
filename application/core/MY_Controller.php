<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
(defined('BASEPATH')) OR exit('No direct script access allowed');

require_once APPPATH . 'interfaces/Crud_Painel.php';

class MY_Controller extends CI_Controller {

    protected $_vPost, $_vGet, $_vPainel;

    function __construct() {
        parent::__construct();
        $this->_vPost = $this->input->post(NULL, TRUE);
        $this->_vGet = $this->input->get(NULL, TRUE);
        $this->_vPainel = $this->session->userdata('painel');
    }

    protected function loadTemplatePainel($view = NULL, $vars = array(), $return = FALSE) {
        if (empty($view))
            $view = 'template/painel';

        if (!isset($vars['title']))
            $vars['title'] = NOME_CLIENTE;

        $vars['_vPost'] = $this->_vPost;
        $vars['_vGet'] = $this->_vGet;
        $vars['_vPainel'] = $this->_vPainel;
        $vars['bPainelNav'] = $this->session->userdata('painel_nav');
        $vars['vPainelPermissao'] = $this->metodo_model->getPermissao($this->_vPainel['id_grupo_usuario']);
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
