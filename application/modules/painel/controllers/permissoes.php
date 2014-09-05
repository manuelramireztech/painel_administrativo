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
        $this->load->model('grupo_usuario_model');
    }

    function index() {
        $nIdGrupoUsuario = $this->security->xss_clean($this->uri->segment(4));

        if (empty($nIdGrupoUsuario)) {
            $this->sys_mensagem_model->setFlashData(12);
            redirect('/painel/grupo_usuario', 'refresh');
        } else {
            $data['oGrupoUsuario'] = $this->grupo_usuario_model->get($nIdGrupoUsuario);
            $data['conteudo'] = "permissoes/main";
            $data['migalha'] = array("painel/grupo_usuario" => "Grupo de Usuário");
            $data['title'] = "Permissões - " . $data['oGrupoUsuario']->nome;

            $voMetodo = $this->metodo_model->getAllComPermissao($nIdGrupoUsuario);
            $data['voMetodo'] = array();
            foreach ($voMetodo as $oMetodo) {
                $data['vsModulo'][$oMetodo->modulo] = $oMetodo->modulo;
                $data['vsClasses'][$oMetodo->classe] = $oMetodo->area;
                $data['voMetodo'][$oMetodo->modulo][$oMetodo->classe][] = $oMetodo;

                if (!isset($data['nPermissaoTotal']))
                    $data['nPermissaoTotal'] = 0;
                if (!isset($data['vnPermissaoModulo'][$oMetodo->modulo]))
                    $data['vnPermissaoModulo'][$oMetodo->modulo] = array("com" => 0, "total" => 0);
                if (!isset($data['vnPermissaoClasse'][$oMetodo->modulo][$oMetodo->classe]))
                    $data['vnPermissaoClasse'][$oMetodo->modulo][$oMetodo->classe] = array("com" => 0, "total" => 0);
                if (!isset($data['vnPermissaoMetodo'][$oMetodo->modulo][$oMetodo->classe][$oMetodo->metodo]))
                    $data['vnPermissaoMetodo'][$oMetodo->modulo][$oMetodo->classe][$oMetodo->metodo] = array("com" => 0, "total" => 0);

                $data['nPermissaoTotal'] ++;
                $data['vnPermissaoModulo'][$oMetodo->modulo]['com'] += $oMetodo->permissao;
                $data['vnPermissaoModulo'][$oMetodo->modulo]['total'] ++;
                $data['vnPermissaoClasse'][$oMetodo->modulo][$oMetodo->classe]['com'] += $oMetodo->permissao;
                $data['vnPermissaoClasse'][$oMetodo->modulo][$oMetodo->classe]['total'] ++;
                $data['vnPermissaoMetodo'][$oMetodo->modulo][$oMetodo->classe][$oMetodo->metodo]['com'] += $oMetodo->permissao;
                $data['vnPermissaoMetodo'][$oMetodo->modulo][$oMetodo->classe][$oMetodo->metodo]['total'] ++;
            }
            $this->loadTemplatePainel(NULL, $data);
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
