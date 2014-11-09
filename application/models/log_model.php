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

    function filtro($vDados = array()) {
        if (isset($vDados["ip"])) {
            $this->db->like('ip', $vDados['ip']);
            unset($vDados["ip"]);
        }
        if (isset($vDados["descricao"])) {
            $this->db->like('descricao', $vDados['descricao']);
            unset($vDados["descricao"]);
        }
        if (isset($vDados["acesso"])) {
            $this->db->like('acesso', $vDados['acesso']);
            unset($vDados["acesso"]);
        }
        if (isset($vDados["data_inicio"])) {
            $this->db->where('data_cadastro >=', Util::converteDataParaBanco($vDados['data_inicio'] . ' 00:00:00'));
            unset($vDados["data_inicio"]);
        }
        if (isset($vDados["data_fim"])) {
            $this->db->where('data_cadastro <=', Util::converteDataParaBanco($vDados['data_fim'] . ' 23:59:59'));
            unset($vDados["data_fim"]);
        }

        if (!empty($vDados))
            $this->db->where($vDados);
    }

    function getPaginate($sUrl, $vDados = array()) {
        $this->filtro($vDados);
        $nTotal = $this->db->select('COUNT(*) AS total')
                ->get($this->sTable)
                ->row('total');

        $nPerPage = 30;
        $nPaginas = (INT) $this->input->get('per_page');
        $this->filtro($vDados);
        $result = $this->db
                ->select('*')
                ->select("(SELECT nome FROM usu_usuario WHERE {$this->sTable}.id_usuario = usu_usuario.id) AS usuario")
                ->order_by('id DESC')
                ->limit($nPerPage, $nPaginas)
                ->get($this->sTable)
                ->result();

        $this->load->library('paginacao', array('total_rows' => $nTotal, 'base_url' => $sUrl, 'per_page' => $nPerPage, 'cur_page' => $nPaginas));
        $sLinks = $this->paginacao->painel();
        return array('data' => $result, 'links' => $sLinks);
    }

    /**
     * <p>Registra o LOG</p>
     * <p>Também serão registrados os campos:</p>
     * <p><b>acesso</b> (módulo, controller, method);</p>
     * <p><b>id</b> do usuário caso esteja logado no painel; </p>
     * <p><b>ip</b> IP de acesso <i>$this->input->ip_address()</i>; </p>
     *
     * @param	string Titulo do LOG
     * @param	array Dados para registro do LOG
     */
    function saveLog($vDados = array()) {
        $vPainel = $this->session->userdata('painel');

        if (!empty($vDados)) {
            foreach ($vDados as $sIndice => $sValor) {
                if (is_string($sValor) AND strlen($sValor) > 50)
                    $vDados[$sIndice] = substr($sValor, 50);
            }

            $vLog = array(
                'acesso' => $this->uri->uri_string(),
                'descricao' => serialize($vDados),
                'id_usuario' => isset($vPainel['id']) ? $vPainel['id'] : NULL,
                'ip' => $this->input->ip_address(),
            );

            $this->db->insert('usu_log', $vLog);
        }
    }

}
