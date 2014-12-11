<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class main extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function index() {
        $vPainel = $this->_vPainel;
        if (empty($vPainel)) {
            redirect('/painel/main/login', 'refresh');
        } else {
            $data['conteudo'] = "main/main";
            $data['title'] = "Bem vindo!";
            $this->loadTemplatePainel(NULL, $data);
        }
    }

    function login() {
        $this->load->view('main/login');
    }

    function page_not_found() {
        $this->load->view('main/404');
    }

    function sempermissao() {
        $this->load->view('main/sempermissao');
    }

    function dologin() {
        $this->load->library('encrypt');
        $this->form_validation->set_rules('user', 'login', 'required');
        $this->form_validation->set_rules('pass', 'Senha', 'required|callback_check_login_senha[' . $this->_vPost['user'] . ']');

        if ($this->form_validation->run()) {
            $usuario = $this->input->post('user', true);
            $senha = $this->input->post('pass', true);
            $oUsuario = $this->usuario_model->getLogin($usuario, $senha);

            $login = array(
                'id' => $oUsuario->id,
                'nome' => $oUsuario->nome,
                'email' => $oUsuario->email,
                'id_grupo_usuario' => $oUsuario->id_grupo_usuario,
                'logged' => 1,
                'datalogin' => date("Y-m-d h:i:s")
            );

            $this->session->set_userdata(array('painel' => $login));
            $this->session->set_userdata('painel_nav', 1);
            $this->sys_mensagem_model->setFlashData(3);
            $this->log_model->saveLog(array('id' => $oUsuario->id, 'nome' => $oUsuario->nome, 'emil' => $oUsuario->email, 'id_grupo_usuario' => $oUsuario->id_grupo_usuario));
            redirect('/painel', 'refresh');
        } else {
            $this->login();
        }
    }
    
    function painel_nav() {
        $nId = (INT) $this->uri->segment(4);
        $this->session->set_userdata('painel_nav', $nId);
    }

    function logout() {
        $this->session->unset_userdata('painel');
        redirect('/painel/main/login', 'refresh');
    }

    function recupera_senha() {
        $this->load->view('main/recupera_senha');
    }

    function recupera() {
        $sLogin = $this->input->post('user', true);
        if (!empty($sLogin)) {
            $oUsuario = $this->usuario_model->get($sLogin, 'login');

            //checa se o usuario exite no banco
            if (!empty($oUsuario)) {
                $this->load->library('encrypt');
                $sSenha = $this->encrypt->decode($oUsuario->senha);
                $this->load->library('envia_email');
                $sMensagem = '<p>Segue abaixo seu acesso ao painel do(a) ' . NOME_CLIENTE . ':</p>';
                $sMensagem .= '<p>Login: ' . $oUsuario->login . '<br />';
                $sMensagem .= 'Senha: ' . $sSenha . '</p>';

                $this->envia_email->enviar($oUsuario->email, 'Recuperação de senha', $sMensagem);
                $this->sys_mensagem_model->setFlashData(13);
            } else {
                $this->sys_mensagem_model->setFlashData(14);
            }
        } else {
            $this->sys_mensagem_model->setFlashData(12);
        }

        redirect('/painel/main/login', 'refresh');
    }

    function check_login_senha($sSenhaInput, $sLogin) {
        $sSenha = $this->usuario_model->getCampo(array('login' => $sLogin, 'ativo' => 1), 'senha');
        
        if (!empty($sSenha)) {
            $sSenha = $this->encrypt->decode($sSenha);

            if (strcmp($sSenha, $sSenhaInput) !== 0) {
                $this->form_validation->set_message('check_login_senha', 'Senha informada não é válida.');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('check_login_senha', 'Login informado não existe.');
            return FALSE;
        }

        return TRUE;
    }
}
