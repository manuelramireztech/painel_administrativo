<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class log extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model('usuario_model');
        }

    function index() {
        $data['conteudo'] = "log/main";
        $data['title'] = "Log";
        $vPaginate = $this->log_model->getPaginate(base_url() . "painel/log/index/?");
        $data['paginacao'] = $vPaginate['links'];
        $data['voLog'] = $vPaginate['data'];
        self::loadTemplatePainel(NULL, $data);
    }

}

?>
