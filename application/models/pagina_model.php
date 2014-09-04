<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
class pagina_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'cms_pagina';
        $this->setDeletado();
    }

    function getPaginate($sUrl, $vDados = array()) {
        $vDados['deletado'] = 0;
        $nTotal = $this->db->select('COUNT(*) AS total')
                ->where($vDados)
                ->get_where($this->sTable)
                ->row('total');

        $nPerPage = 30;
        $nPaginas = (INT) $this->input->get('per_page');

        $result = $this->db
                ->select('*')
                ->select("(SELECT p.nome FROM cms_pagina AS p WHERE " . $this->sTable . ".id_pagina = p.id) AS pagina")
                ->order_by('id', 'DESC')
                ->limit($nPerPage, $nPaginas)
                ->where($vDados)
                ->get($this->sTable)
                ->result();

        $this->load->library('paginacao', array('total_rows' => $nTotal, 'base_url' => $sUrl, 'per_page' => $nPerPage, 'cur_page' => $nPaginas));
        $sLinks = $this->paginacao->painel();
        return array('data' => $result, 'links' => $sLinks);
    }

}
