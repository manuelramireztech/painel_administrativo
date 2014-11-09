<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/profile/view?id=260417728&trk=spm_pic
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/libraries/phpmailer/class.phpmailer.php';
require_once APPPATH . '/libraries/phpmailer/class.smtp.php';

class envia_email {

    private $configEmail, $CI;

    public function __construct($vParams = array()) {
        $this->CI = &get_instance();
        $this->CI->load->model('configuracao_model');

        $sFrom = $this->CI->configuracao_model->getValor('EMAIL_FROM');
        $sFromName = $this->CI->configuracao_model->getValor('EMAIL_FROM_NAME');

        $sSmtp = $this->CI->configuracao_model->getValor('EMAIL_SMTP');
        $nPort = (INT) $this->CI->configuracao_model->getValor('EMAIL_PORT');
        $sSecure = $this->CI->configuracao_model->getValor('EMAIL_SECURE');

        $sUserName = $this->CI->configuracao_model->getValor('EMAIL_USERNAME');
        $sPassword = $this->CI->configuracao_model->getValor('EMAIL_PASSWORD');

        $this->configEmail = new PHPMailer();

        if (!empty($sSmtp)) {
            $this->configEmail->IsSMTP(); // Define que a mensagem será SMTP
            $this->configEmail->Host = $sSmtp; // Endereço do servidor SMTP

            if (!empty($sUserName) AND ! empty($sPassword)) {
                $this->configEmail->SMTPAuth = TRUE; // Usa autenticação SMTP? (opcional)
                $this->configEmail->Username = $sUserName; // Usuário do servidor SMTP
                $this->configEmail->Password = $sPassword; // Senha do servidor SMTP
            }

            if (!empty($sSecure)) {
                $this->configEmail->SMTPSecure = $sSecure;
            }
        }

        $this->configEmail->From = $sFrom;
        $this->configEmail->FromName = $sFromName;

        if (isset($vParams['SMTPDebug'])) {
            $this->configEmail->Debugoutput = 'html';
            $this->configEmail->SMTPDebug = $vParams['SMTPDebug'];
        }

        $this->configEmail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $this->configEmail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
        $this->configEmail->Port = !empty($nPort) ? $nPort : 25; // Charset da mensagem (opcional)
    }

    function enviar($sPara, $sAssunto, $sMensagem) {
        if (!empty($sPara) AND ! empty($sAssunto) AND ! empty($sMensagem)) {
            if (is_array($sPara)) {
                foreach ($sPara as $para) {
                    $this->configEmail->AddAddress(trim($para));
                }
            } else {
                $this->configEmail->AddAddress(trim($sPara));
            }

            $this->configEmail->Subject = strip_tags($sAssunto) . " - " . NOME_CLIENTE;
            return $this->send($sMensagem, $sAssunto);
        } else {
            return false;
        }
    }

    private function send($sMensagem, $sAssunto) {
        $vVars = array(
            'mensagem' => $sMensagem,
            'assunto' => $sAssunto
        );
        $this->configEmail->Body = $this->CI->load->view('template/email', $vVars, true);
        $enviado = $this->configEmail->Send();
        $this->configEmail->ClearAllRecipients();
        $this->configEmail->ClearAttachments();

        return $enviado;
    }

}

?>
