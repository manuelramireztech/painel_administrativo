<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pagina extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pagina_model');
        $this->load->model('pagina_model');
    }

    function index() {
        $data['conteudo'] = "pagina/main";
        $data['title'] = "Página";
        $vPaginate = $this->pagina_model->getPaginate(base_url() . "painel/pagina/index/?");
        $data['paginacao'] = $vPaginate['links'];
        $data['voPagina'] = $vPaginate['data'];
        self::loadTemplatePainel(NULL, $data);
    }

    function adicionar() {
        $data['pagina'] = array('' => 'Nenhum') + $this->pagina_model->getAllSelect(array('id_pagina' => NULL, 'tipo' => 'menu'));
        $data['migalha'] = array('painel/pagina' => 'Página');
        $data['conteudo'] = "pagina/save";
        $data['title'] = "Adicionar Página";
        self::loadTemplatePainel(NULL, $data);
    }

    function alterar() {
        $nId = $this->security->xss_clean($this->uri->segment(4));
        $data['oPagina'] = $this->pagina_model->get($nId);

        if (empty($data['oPagina'])) {
            $this->sys_mensagem_model->setFlashData(7);
            redirect('/painel/pagina', 'refresh');
        } else {
            $data['pagina'] = array('' => 'Nenhum') + $this->pagina_model->getAllSelect(array('id_pagina' => NULL, 'tipo' => 'menu'));
            $data['migalha'] = array('painel/pagina' => 'Página');
            $data['conteudo'] = "pagina/save";
            $data['title'] = "Alterar Página";
            self::loadTemplatePainel(NULL, $data);
        }
    }

    function remover() {
        $sId = $this->security->xss_clean($this->input->get('id', true));

        if (empty($sId)) {
            $this->sys_mensagem_model->setFlashData(2);
        } else {
            if ($this->pagina_model->remove($sId))
                $this->sys_mensagem_model->setFlashData(8);
            else
                $this->sys_mensagem_model->setFlashData(1);
        }

        redirect('/painel/pagina', 'refresh');
    }

    function save() {
        $vDados = $this->input->post();
        $vDados = $this->security->xss_clean($vDados);

        if (!empty($vDados)) {
            $vReg = array(
                'id_pagina' => $vDados["id_pagina"],
                'nome' => $vDados["nome"],
                'tipo' => $vDados["tipo"],
                'url' => $vDados["url"],
                'texto' => $vDados["texto"],
                'ativo' => $vDados["ativo"],
            );

            if (empty($vReg['id_pagina']))
                $vReg['id_pagina'] = NULL;

            switch ($vDados["tipo"]) {
                case 'conteudo':
                    unset($vReg['url']);
                    break;
                case 'link':
                    unset($vReg['texto']);
                    break;
                case 'menu':
                    unset($vReg['texto'], $vReg['url']);
                    break;
            }

            if ((INT) $vDados['id']) {
                if ($this->pagina_model->update($vReg, $vDados['id'])) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            } else {
                if ($this->pagina_model->insert($vReg)) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            }

            redirect('/painel/pagina', 'refresh');
        }
        else
            $this->sys_mensagem_model->setFlashData(1);
    }

}

?>
