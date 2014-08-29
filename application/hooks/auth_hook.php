<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_hook {

    private $ci;

    public function __construct() {
        $this->ci = &get_instance();
    }

    function check() {
        $module = $this->ci->router->fetch_module();

        if ($module == "painel")
            $this->check_logged_painel($module, $this->ci->router->class, $this->ci->router->method);
    }

    protected function check_logged_painel($module, $classe, $metodo) {
        $this->ci->load->model('metodo_model');
        $result = $this->ci->metodo_model->getAll(array('modulo' => $module, 'classe' => $classe, 'metodo' => $metodo));

        //Se este método ainda não existir na tabela, será cadastrado   
        if (empty($result)) {
            redirect('painel/main/sempermissao', 'refresh');
        }
        //Se já existir traz as informações de público ou privado
        else {
            $vPainel = $this->ci->session->userdata('painel');

            if ($result[0]->privado) {
                //Se for privado, verifica o login
                $nIdMetodos = $result[0]->id;

                //Se o usuário estiver logado vai verificar se tem permissão na tabela
                if (!empty($vPainel) AND $nIdMetodos) {
                    $bExist = $this->ci->metodo_model->validarPermissao($vPainel['id_grupo_usuario'], $nIdMetodos);

                    //Se não vier nenhum resultado da consulta, manda para a página de usuário sem permissão
                    if ($bExist == 0)
                        redirect('painel/main/sempermissao', 'refresh');
                } else { //Se não estiver logado, será redirecionado para o login
                    redirect('painel/main/login', 'refresh');
                }
            }
        }
    }

}
