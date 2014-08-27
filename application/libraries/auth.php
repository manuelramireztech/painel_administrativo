<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class auth {

    private $ci;
    public $vPermissaoPainel;

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->model('grupo_usuario_model');
        $this->ci->load->model('metodo_model');

        $module = $this->ci->router->fetch_module();
        if ($module == "painel" OR $module == "psg") {
            $this->check_logged_painel($this->ci->router->fetch_module(), $this->ci->router->class, $this->ci->router->method);
        }
    }

    function check_logged_painel($module, $classe, $metodo) {
        /*
         * Buscando a classe e método da tabela sys_métodos
         */

        $result = $this->ci->db
                ->get_where('usu_metodo', array('modulo' => $module, 'classe' => $classe, 'metodo' => $metodo))
                ->result();
        //Se este método ainda não existir na tabela, será cadastrado   
        
        if (empty($result)) {
            redirect('painel/main/sempermissao', 'refresh');
        }
        //Se já existir traz as informações de público ou privado
        else {
            $vPainel = $this->ci->session->userdata('painel');
            if (!empty($vPainel['id_grupo_usuario']))
                $this->vPermissaoPainel = $this->ci->metodo_model->getPermissao($vPainel['id_grupo_usuario']);
            else
                $this->vPermissaoPainel = array();

            if ($result[0]->privado) {
                //Se for privado, verifica o login
                $nIdMetodos = $result[0]->id;

                //Se o usuário estiver logado vai verificar se tem permissão na tabela
                if (!empty($vPainel) AND $nIdMetodos) {
                    $bExist = $this->ci->metodo_model->validarPermissao($vPainel['id_grupo_usuario'], $nIdMetodos);
                    
                    //Se não vier nenhum resultado da consulta, manda para a página de
                    //usuário sem permissão
                    if (!$bExist) {
                        redirect('painel/main/sempermissao', 'refresh');
                    } else {
                        $oGrupoUsuario = $this->ci->grupo_usuario_model->get($vPainel['id_grupo_usuario']);

                        if (empty($oGrupoUsuario)) {
                            $this->ci->sys_mensagem_model->setFlashData(10);
                            redirect('painel/main/login', 'refresh');
                        } else {
                            if ($oGrupoUsuario->deletado == 1) {
                                $this->ci->sys_mensagem_model->setFlashData(10);
                                redirect('painel/main/login', 'refresh');
                            }
                        }
                    }
                } else { //Se não estiver logado, será redirecionado para o login
                    redirect('painel/main/login', 'refresh');
                }
            }
        }
    }

}
