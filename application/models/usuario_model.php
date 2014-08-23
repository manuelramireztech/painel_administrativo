<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class usuario_model extends abstract_model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'usu_usuario';
        $this->bDeletado = TRUE;
    }

    function getLogin($sLogin, $sSenha) {
        $oRow = $this->db
                ->get_where($this->sTable, array('login' => $sLogin, 'deletado' => 0, 'ativo' => 1))
                ->row(0);

        if (!empty($oRow)) {
            if ($this->encrypt->decode($oRow->senha) == $sSenha) {
                return $oRow;
            }
        }

        return NULL;
    }

    function getPaginate($sUrl, $vDados = array()) {
        $vDados['deletado'] = 0;
        $nTotal = $this->db->select('COUNT(*) AS total')
                ->get_where($this->sTable, $vDados)
                ->row('total');

        $nPerPage = 30;
        $nPaginas = (INT) $this->input->get('per_page');

        $result = $this->db
                ->select('*')
                ->select("(SELECT nome FROM usu_grupo_usuario WHERE {$this->sTable}.id_grupo_usuario = usu_grupo_usuario.id) AS grupo_usuario")
                ->order_by('id DESC')
                ->limit($nPerPage, $nPaginas)
                ->get_where($this->sTable, $vDados)
                ->result();

        $this->load->library('paginacao', array('total_rows' => $nTotal, 'base_url' => $sUrl, 'per_page' => $nPerPage, 'cur_page' => $nPaginas));
        $sLinks = $this->paginacao->painel();
        return array('data' => $result, 'links' => $sLinks);
    }

}
