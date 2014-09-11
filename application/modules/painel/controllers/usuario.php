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

    public function index() {
        $vPaginate = $this->usuario_model->getPaginate(base_url() . "painel/usuario/index/?");
        $data['sPaginacao'] = $vPaginate['links'];
        $data['roUsuario'] = $vPaginate['result'];

        $data['conteudo'] = "usuario/main";
        $data['title'] = "(" . $vPaginate['total'] . ") - Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    public function adicionar() {
        if (count($_POST)) {
            if ($this->validation()) {
                $this->usuario_model->save();
                redirect('painel/usuario', 'refresh');
                return;
            }
        }

        $data['vsGrupoUsuario'] = array('' => 'Selecione') + $this->grupo_usuario_model->getAllSelect();
        $data['action'] = "adicionar";
        $data['migalha'] = array('painel/usuario' => 'Usuário');
        $data['conteudo'] = "usuario/save";
        $data['title'] = "Adicionar Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    public function alterar() {
        if (count($_POST)) {
            if ($this->validation()) {
                $this->usuario_model->save();
                redirect('painel/usuario', 'refresh');
                return;
            }
        }

        $nId = $this->security->xss_clean($this->uri->segment(4));
        $data['oUsuario'] = $this->usuario_model->get($nId);

        if (empty($data['oUsuario'])) {
            $this->sys_mensagem_model->setFlashData(7);
            redirect('painel/usuario', 'refresh');
        } else {
            $data['vsGrupoUsuario'] = array('' => 'Selecione') + $this->grupo_usuario_model->getAllSelect();
            $data['action'] = "alterar/" . $nId;
            $data['migalha'] = array('painel/usuario' => 'Usuário');
            $data['conteudo'] = "usuario/save";
            $data['title'] = "Alterar Usuário";
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    public function remover() {
        $nId = $this->security->xss_clean($this->input->get('id', true));

        if (empty($nId)) {
            $this->sys_mensagem_model->setFlashData(2);
        } else {
            if ($this->usuario_model->remove($nId))
                $this->sys_mensagem_model->setFlashData(8);
            else
                $this->sys_mensagem_model->setFlashData(1);
        }

        redirect('painel/usuario', 'refresh');
    }

    function meus_dados() {
        if (count($_POST)) {
            if ($this->validation_meus_dados()) {
                $this->usuario_model->save_meus_dados();
                redirect('/painel/usuario/meus_dados', 'refresh');
                return;
            }
        }

        $vPainel = $this->session->userdata('painel');
        $data['usuario'] = $this->usuario_model->get($vPainel['id']);
        $data['conteudo'] = "usuario/meus_dados";
        $data['title'] = "Alterar meus dados de acesso";
        $this->loadTemplatePainel(NULL, $data);
    }

    private function validation() {
        $this->my_form_validation->set_rules('id_grupo_usuario', 'Grupo usuário', 'required|max_length[10]');
        $this->my_form_validation->set_rules('nome', 'Nome', 'required|max_length[200]');
        $this->my_form_validation->set_rules('login', 'Login', 'required|max_length[100]');
        $this->my_form_validation->set_rules('senha', 'Senha', 'max_length[200]');
        $this->my_form_validation->set_rules('email', 'Email', 'required|max_length[100]|valid_email');
        $this->my_form_validation->set_rules('ativo', 'Ativo', '');
        $this->my_form_validation->set_rules('deletado', 'Deletado', '');
        return $this->my_form_validation->run();
    }
    
    private function validation_meus_dados() {
        $this->my_form_validation->set_rules('nome', 'Nome', 'required|max_length[200]');
        $this->my_form_validation->set_rules('login', 'Login', 'required|max_length[100]');
        $this->my_form_validation->set_rules('email', 'Email', 'required|max_length[100]|valid_email');
        return $this->my_form_validation->run();
    }

}

?>
