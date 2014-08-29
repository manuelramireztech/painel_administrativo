<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class metodo_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'usu_metodo';
    }

    function getAllComPermissao($nIdGrupoUsuario) {
        $voMetodo = $this->db
                ->order_by('classe, metodo')
                ->where(array('privado' => 1, 'default' => 0))
                ->get($this->sTable)
                ->result();

        if (!empty($voMetodo)) {
            foreach ($voMetodo as $nIndice => $oMetodo) {
                $voMetodo[$nIndice]->permissao = $this->db
                        ->select('COUNT(*) AS existe')
                        ->get_where('usu_permissoes', array('id_metodo' => $oMetodo->id, 'id_grupo_usuario' => $nIdGrupoUsuario))
                        ->row('existe');
            }
        }

        return $voMetodo;
    }

    function getPermissao($nIdGrupoUsuario) {
        $vPermissao = array();
        $voMetodo = $this->db
                ->order_by('classe, metodo')
                ->where(array('privado' => 1))
                ->get($this->sTable)
                ->result();

        if (!empty($voMetodo)) {
            foreach ($voMetodo as $oMetodo) {
                $bPermissao = (INT) $this->db
                                ->select('COUNT(*) AS existe')
                                ->get_where('usu_permissoes', array('id_metodo' => $oMetodo->id, 'id_grupo_usuario' => $nIdGrupoUsuario))
                                ->row('existe');

                if (!empty($bPermissao))
                    $vPermissao["{$oMetodo->modulo}/{$oMetodo->classe}/{$oMetodo->metodo}"] = $bPermissao;
            }
        }

        return $vPermissao;
    }

    function checkPermissao($nIdGrupoUsuario, $sApelido) {
        return $this->db
                        ->select("COUNT(*) AS existe")
                        ->were(array('usu_permissoes.id_grupo_usuario' => $nIdGrupoUsuario, 'usu_metodo.apelido' => $sApelido))
                        ->join('usu_permissoes', "usu_permissoes.id_metodo = {$this->sTable}.id")
                        ->get($this->sTable)
                        ->row('existe');
    }

    function save($nIdGrupoUsuario, $vnIdMetodo) {
        $this->db->delete('usu_permissoes', array('id_grupo_usuario' => $nIdGrupoUsuario));

        if (!empty($vnIdMetodo)) {
            foreach ($vnIdMetodo as $nIdMetodo) {
                $this->db->insert('usu_permissoes', array('id_grupo_usuario' => $nIdGrupoUsuario, 'id_metodo' => $nIdMetodo));
            }
        }

        $voMetodo = $this->db
                ->order_by('classe, metodo')
                ->where(array('default' => 1))
                ->get($this->sTable)
                ->result();

        if (!empty($voMetodo)) {
            foreach ($voMetodo as $oMetodo) {
                $this->db->insert('usu_permissoes', array('id_grupo_usuario' => $nIdGrupoUsuario, 'id_metodo' => $oMetodo->id));
            }
        }
    }

    function validarPermissao($nIdGrupoUsuario, $nIdMetodo) {
        return $this->db
                        ->select("COUNT(*) AS existe")
                        ->where(array('id_grupo_usuario' => $nIdGrupoUsuario, 'id_metodo' => $nIdMetodo, 'deletado' => 0))
                        ->join('usu_grupo_usuario', "usu_grupo_usuario.id = usu_permissoes.id_grupo_usuario")
                        ->get("usu_permissoes")
                        ->row('existe');
    }

}
