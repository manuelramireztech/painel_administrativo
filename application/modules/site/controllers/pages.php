<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pages extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['conteudo'] = "pages/main";
        $data['title'] = "Bem vindo!";
        self::loadTemplateSite(NULL, $data);
    }

    function pagina() {
        $this->load->model('pagina_model');
        $nId = (INT) $this->uri->segment(3);
        $data['oPagina'] = $this->pagina_model->get($nId);

        if (!empty($data['oPagina'])) {
            $data['conteudo'] = "pages/pagina";
            self::loadTemplateSite(NULL, $data);
        } else {
            $this->pagina_nao_encontrada();
        }
    }

    function pagina_nao_encontrada() {
        $data['conteudo'] = "pages/404";
        self::loadTemplateSite(NULL, $data);
    }

    function contato() {
        $data['conteudo'] = "pages/contato";
        self::loadTemplateSite(NULL, $data);
    }

    function captcha() {
        $this->load->library('securimage/securimage');
        $this->securimage->charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $this->securimage->code_length = rand(4, 5);
//        $this->securimage->display_value = Util::gerarSenha(5, false, true, true, false);
        $this->securimage->num_lines = rand(7, 11);
        $this->securimage->case_sensitive = false;
        $this->securimage->noise_level = rand(2, 5);
        $this->securimage->perturbation = rand(7, 13) / 10;
        $this->securimage->case_sensitive = false;
//        $this->securimage->background_directory = APPPATH . 'libraries/securimage/backgrounds/';
        $this->securimage->show(APPPATH . 'libraries/securimage/backgrounds/bg4.jpg');
    }

    function envia_contato() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('assunto', 'Assunto', 'required');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'required');
        //$this->form_validation->set_rules('code', 'Código de Segurança', 'required|callback_code_check');

        if ($this->validar_envio('envia_contato')) {
            if ($this->form_validation->run()) {
                $vDados = $this->input->post();
                $vDados = $this->security->xss_clean($vDados);

                $sMensagem = "<p>Segue abaixo os dados de contato:</p>    
                        <p>
                            Nome: {$vDados['nome']}<br />
                            E-mail: {$vDados['email']}<br />
                            Assunto: {$vDados['assunto']}<br />
                            IP: {$_SERVER['REMOTE_ADDR']}<br />
                            Navegador: {$_SERVER['HTTP_USER_AGENT']}<br />
                            Mensagem: " . nl2br($vDados['mensagem']) . "<br />
                        </p>";
                $this->load->library('envia_email');
                $sContato = $this->configuracao_model->getValor('EMAIL_CONTATO');
                $this->envia_email->enviar($sContato, 'Dados de Contato', $sMensagem);
                $this->session->set_flashdata('site_msg', array('msg' => 'E-mail enviado com sucesso!', 'type' => 'success'));
                redirect('/site/pages/contato', 'refresh');
            } else {
                $this->contato();
            }
        } else {
            $this->session->set_flashdata('site_msg', array('msg' => 'Estamos com problema para enviar os dados de contato. Por favor tente novamente em alguns minutos!', 'type' => 'warning'));
            redirect('pages/contato', 'refresh');
        }
    }

    function code_check($sCode) {
        $this->load->library('securimage/securimage');
        if ($this->securimage->check($sCode)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('code_check', 'Código de segurança informao não é válido');
            return FALSE;
        }
    }

    private function validar_envio($sSessao, $nCount = 5) {
        $sIp = $_SERVER['REMOTE_ADDR'];
        $sUserAgente = $_SERVER['HTTP_USER_AGENT'];
        $sIsca = $this->input->post("campo-isca");

        if (!empty($sIp) AND ! empty($sUserAgente) AND empty($sIsca)) {
            $vEmail = $this->session->userdata($sSessao);
            if (empty($vEmail))
                $vEmail = array('count' => 0, 'ip' => $sIp, 'timestamp' => time());

            $vEmail['count'] ++;
            $nTimestamp = time() - $vEmail['timestamp'];

            if (($nTimestamp / (60 * 60)) > 1) // Se passar de 1h atualiza o contador para 0
                $vEmail['count'] = 0;

            $this->session->set_userdata($sSessao, $vEmail);
            return $vEmail['count'] <= $nCount;
        } else {
            return false;
        }
    }

}
