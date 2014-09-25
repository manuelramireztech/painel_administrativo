<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class configuracao extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('configuracao_model');
    }

    function index() {
        if (!empty($this->_vPost)) {
            $this->save();
        } else {
            $data['conteudo'] = "configuracao/main";
            $data['title'] = "Configuração";
            $data['vConfiguracao'] = $this->configuracao_model->getAllSelect(array(), 'valor', 'nome');
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    private function save() {
        if (!empty($this->_vPost)) {
            foreach ($this->_vPost['configuracao'] as $sNome => $sValor) {
                $this->configuracao_model->salvar($sNome, $sValor);
            }
            $this->sys_mensagem_model->setFlashData(9);
        } else
            $this->sys_mensagem_model->setFlashData(1);

        redirect('/painel/configuracao', 'refresh');
    }

}

?>
