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
        $vPainel = $this->session->userdata('painel');
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
        $usuario = $this->input->post('user', true);
        $senha = $this->input->post('pass', true);

        if (!empty($usuario) AND ! empty($senha)) {
            $oUsuario = $this->usuario_model->getLogin($usuario, $senha);

            if (empty($oUsuario)) {
                $this->sys_mensagem_model->setFlashData(4);
                redirect('/painel/main/login', 'refresh');
            } else {
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
                $this->usuario_model->saveLog('Login no Painel', array('id' => $oUsuario->id, 'nome' => $oUsuario->nome, 'email' => $oUsuario->email, 'id_grupo_usuario' => $oUsuario->id_grupo_usuario));
                redirect('/painel', 'refresh');
            }
        } else {
            $this->sys_mensagem_model->setFlashData(6);
            redirect('/painel/main/login', 'refresh');
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

}
