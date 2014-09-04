<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario extends MY_Controller implements Crud_Painel {

    function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('grupo_usuario_model');
    }

    function index() {
        $data['conteudo'] = "usuario/main";
        $data['title'] = "Usuário";
        $vPaginate = $this->usuario_model->getPaginate(base_url() . "painel/usuario/index/?");
        $data['paginacao'] = $vPaginate['links'];
        $data['voUsuario'] = $vPaginate['data'];
        $this->loadTemplatePainel(NULL, $data);
    }

    function adicionar() {
        $data['migalha'] = array('painel/usuario' => 'Usuário');
        $data['grupo_usuario'] = array('' => 'Selecione') + $this->grupo_usuario_model->getAllSelect();
        $data['conteudo'] = "usuario/save";
        $data['title'] = "Adicionar Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    function alterar() {
        $nId = $this->security->xss_clean($this->uri->segment(4));
        $data['oUsuario'] = $this->usuario_model->get($nId);

        if (empty($data['oUsuario'])) {
            $this->sys_mensagem_model->setFlashData(7);
            redirect('/painel/usuario', 'refresh');
        } else {
            $data['migalha'] = array('painel/usuario' => 'Usuário');
            $data['grupo_usuario'] = array('' => 'Selecione') + $this->grupo_usuario_model->getAllSelect();
            $data['conteudo'] = "usuario/save";
            $data['title'] = "Alterar Usuário";
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    function remover() {
        $sId = $this->security->xss_clean($this->input->get('id', true));

        if (empty($sId)) {
            $this->sys_mensagem_model->setFlashData(2);
        } else {
            if ($this->usuario_model->remove($sId))
                $this->sys_mensagem_model->setFlashData(8);
            else
                $this->sys_mensagem_model->setFlashData(1);
        }

        redirect('/painel/usuario', 'refresh');
    }

    function save() {
        $vDados = $this->input->post();
        $vDados = $this->security->xss_clean($vDados);

        if (!empty($vDados)) {
            $vReg = array(
                'id_grupo_usuario' => $vDados["id_grupo_usuario"],
                'nome' => $vDados["nome"],
                'login' => $vDados["login"],
                'email' => $vDados["email"],
                'ativo' => $vDados["ativo"],
            );

            $this->load->library('encrypt');
            if ((INT) $vDados['id']) {
                if (!empty($vDados['senha']))
                    $vReg['senha'] = $this->encrypt->encode($vDados['senha']);

                if ($this->usuario_model->update($vReg, $vDados['id'])) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            } else {
                $vReg['senha'] = $this->encrypt->encode($vDados['senha']);

                if ($this->usuario_model->insert($vReg)) {
                    $this->sys_mensagem_model->setFlashData(9);
                } else {
                    $this->sys_mensagem_model->setFlashData(2);
                }
            }

            redirect('/painel/usuario', 'refresh');
        } else
            $this->sys_mensagem_model->setFlashData(1);
    }

    function meus_dados() {
        $vPainel = $this->session->userdata('painel');
        $data['usuario'] = $this->usuario_model->get($vPainel['id']);
        $data['conteudo'] = "usuario/meus_dados";
        $data['title'] = "Alterar meus dados de acesso";
        $this->loadTemplatePainel(NULL, $data);
    }

    function save_meus_dados() {
        $vPainel = $this->session->userdata('painel');
        $vDados = $this->input->post();
        $vDados = $this->security->xss_clean($vDados);

        if (!empty($vDados)) {
            $vReg = array(
                'nome' => $vDados['nome'],
                'login' => $vDados['login'],
                'email' => $vDados['email']
            );

            if (!empty($vDados['senha']))
                $vReg['senha'] = $this->encrypt->encode($vDados['senha']);

            if ($this->usuario_model->update($vReg, $vPainel['id'])) {
                $this->sys_mensagem_model->setFlashData(9);
            } else {
                $this->sys_mensagem_model->setFlashData(2);
            }

            redirect('/painel/usuario/meus_dados', 'refresh');
        } else
            $this->sys_mensagem_model->setFlashData(1);
    }

}

?>
