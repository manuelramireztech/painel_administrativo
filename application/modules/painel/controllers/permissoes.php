<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class permissoes extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('metodo_model');
        $this->load->model('grupo_usuario_model');
    }

    function index() {
        $nIdGrupoUsuario = $this->security->xss_clean($this->uri->segment(4));

        if (empty($nIdGrupoUsuario)) {
            $this->sys_mensagem_model->setFlashData(12);
            redirect('/painel/grupo_usuario', 'refresh');
        } else {
            $data['nIdGrupoUsuario'] = $nIdGrupoUsuario;
            $data['conteudo'] = "permissoes/main";
            $data['title'] = "Permissões";
            $data['voMetodo'] = $this->metodo_model->getAllComPermissao($nIdGrupoUsuario);
            self::loadTemplatePainel(NULL, $data);
        }
    }

    function save() {
        $vDados = $this->input->post();
        $vDados = $this->security->xss_clean($vDados);
        
        if (!empty($vDados)) {
            $this->metodo_model->save($vDados['id_grupo_usuario'], isset($vDados['id_metodo']) ? $vDados['id_metodo'] : NULL);
            $this->sys_mensagem_model->setFlashData(9);
            redirect('/painel/permissoes/index/' . $vDados['id_grupo_usuario'], 'refresh');
        } else
            $this->sys_mensagem_model->setFlashData(1);
    }

}

?>
