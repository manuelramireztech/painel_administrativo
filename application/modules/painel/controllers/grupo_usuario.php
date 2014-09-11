<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class grupo_usuario extends MY_Controller implements Crud_Painel {

    function __construct() {
        parent::__construct();
        $this->load->model('grupo_usuario_model');
    }

    public function index() {
        $vPaginate = $this->grupo_usuario_model->getPaginate(base_url() . "painel/grupo_usuario/index/?");
        $data['sPaginacao'] = $vPaginate['links'];
        $data['roGrupoUsuario'] = $vPaginate['result'];

        $data['conteudo'] = "grupo_usuario/main";
        $data['title'] = "(" . $vPaginate['total'] . ") - Grupo de Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    public function adicionar() {
        if (count($_POST)) {
            if ($this->validation()) {
                $this->grupo_usuario_model->save();
                redirect('painel/grupo_usuario', 'refresh');
                return;
            }
        }

        $data['action'] = "adicionar";
        $data['migalha'] = array('painel/grupo_usuario' => 'Grupo de Usuário');
        $data['conteudo'] = "grupo_usuario/save";
        $data['title'] = "Adicionar Grupo de Usuário";
        $this->loadTemplatePainel(NULL, $data);
    }

    public function alterar() {
        if (count($_POST)) {
            if ($this->validation()) {
                $this->grupo_usuario_model->save();
                redirect('painel/grupo_usuario', 'refresh');
                return;
            }
        }

        $nId = $this->security->xss_clean($this->uri->segment(4));
        $data['oGrupoUsuario'] = $this->grupo_usuario_model->get($nId);

        if (empty($data['oGrupoUsuario'])) {
            $this->sys_mensagem_model->setFlashData(7);
            redirect('painel/grupo_usuario', 'refresh');
        } else {
            $data['action'] = "alterar/" . $nId;
            $data['migalha'] = array('painel/grupo_usuario' => 'Grupo de Usuário');
            $data['conteudo'] = "grupo_usuario/save";
            $data['title'] = "Alterar Grupo de Usuário";
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    public function remover() {
        $nId = $this->security->xss_clean($this->input->get('id', true));

        if (empty($nId)) {
            $this->sys_mensagem_model->setFlashData(2);
        } else {
            if ($this->grupo_usuario_model->remove($nId))
                $this->sys_mensagem_model->setFlashData(8);
            else
                $this->sys_mensagem_model->setFlashData(1);
        }

        redirect('painel/grupo_usuario', 'refresh');
    }

    private function validation() {
        $this->my_form_validation->set_rules('nome', 'Nome', 'required|max_length[45]');
        $this->my_form_validation->set_rules('deletado', 'Deletado', '');
        return $this->my_form_validation->run();
    }

}

?>
