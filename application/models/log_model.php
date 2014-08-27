<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class log_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'usu_log';
    }

    function getPaginate($sUrl, $vDados = array()) {
        $nTotal = $this->db->select('COUNT(*) AS total')
                ->get_where($this->sTable, $vDados)
                ->row('total');

        $nPerPage = 30;
        $nPaginas = (INT) $this->input->get('per_page');

        $result = $this->db
                ->select('*')
                ->select("(SELECT nome FROM usu_usuario WHERE {$this->sTable}.id_usuario = usu_usuario.id) AS usuario")
                ->order_by('id DESC')
                ->limit($nPerPage, $nPaginas)
                ->get_where($this->sTable, $vDados)
                ->result();

        $this->load->library('paginacao', array('total_rows' => $nTotal, 'base_url' => $sUrl, 'per_page' => $nPerPage, 'cur_page' => $nPaginas));
        $sLinks = $this->paginacao->painel();
        return array('data' => $result, 'links' => $sLinks);
    }

}