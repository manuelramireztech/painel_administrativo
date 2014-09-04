<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class grupo_usuario extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('grupo_usuario_model');
    }

    function index() {
        $data['conteudo'] = "grupo_usuario/main";
        $data['title'] = "Grupo Usuário";
        $vPaginate = $this->grupo_usuario_model->getPaginate(base_url() . "painel/grupo_usuario/index/?");
        $data['paginacao'] = $vPaginate['links'];
        $data['voGrupoUsuario'] = $vPaginate['data'];
        $this->loadTemplatePainel(NULL, $data);
    }

    function adicionar() {
        $data['migalha'] = array('painel/grupo_usuario' => 'Grupo Usuário');
        $data['conteudo'] = "grupo_usuario/save";
        $data['title'] = "Adicionar Grupo Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    function alterar() {
        $nId = $this->security->xss_clean($this->uri->segment(4));
        $data['oGrupoUsuario'] = $this->grupo_usuario_model->get($nId);

        if (empty($data['oGrupoUsuario'])) {
            $this->sys_mensagem_model->setFlashData(7);
            redirect('/painel/grupo_usuario', 'refresh');
        } else {
            $data['migalha'] = array('painel/grupo_usuario' => 'Grupo Usuário');
            $data['conteudo'] = "grupo_usuario/save";
            $data['title'] = "Alterar Grupo Usuário";
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    function remover() {
        $sId = $this->security->xss_clean($this->input->get('id', true));

        if (empty($sId)) {
            $this->sys_mensagem_model->setFlashData(2);
        } else {
            if ($this->grupo_usuario_model->remove($sId))
                $this->sys_mensagem_model->setFlashData(8);
            else
                $this->sys_mensagem_model->setFlashData(1);
        }

        redirect('/painel/grupo_usuario', 'refresh');
    }

    function save() {
        $vDados = $this->input->post();
        $vDados = $this->security->xss_clean($vDados);

        if (!empty($vDados)) {
            $vReg = array(
                'nome' => $vDados["nome"]
            );

            if ((INT) $vDados['id']) {
                if ($this->grupo_usuario_model->update($vReg, $vDados['id'])) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            } else {
                if ($this->grupo_usuario_model->insert($vReg)) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            }

            redirect('/painel/grupo_usuario', 'refresh');
        }
        else
            $this->sys_mensagem_model->setFlashData(1);
    }

}

?>
