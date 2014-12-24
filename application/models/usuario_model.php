<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
class usuario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'usu_usuario';
        $this->bDeletado = TRUE;
    }

    function getLogin($sLogin, $sSenha) {
        $oRow = $this->db
                ->select($this->sTable . ".*")
                ->join("usu_grupo_usuario", "usu_grupo_usuario.id = " . $this->sTable . ".id_grupo_usuario")
                ->get_where($this->sTable, array('login' => $sLogin, 'usu_grupo_usuario.deletado' => 0, "" . $this->sTable . ".deletado" => 0, 'ativo' => 1))
                ->row(0);

        if (!empty($oRow)) {
            if ($this->encrypt->decode($oRow->senha) == $sSenha) {
                return $oRow;
            }
        }

        return NULL;
    }

    public function getPaginate($sUrl, $vDados = array()) {
        $vDados['deletado'] = 0;
        $nTotal = $this->db->select('COUNT(*) AS total')
                ->where($vDados)
                ->get_where($this->sTable)
                ->row('total');

        $nPerPage = 30;
        $nPaginas = (INT) $this->input->get('per_page');

        $result = $this->db
                ->select('*')
                ->select("(SELECT nome FROM usu_grupo_usuario WHERE {$this->sTable}.id_grupo_usuario = usu_grupo_usuario.id) AS grupo_usuario")
                ->order_by('id', 'DESC')
                ->where($vDados)
                ->get($this->sTable, $nPerPage, $nPaginas);

        $this->load->library('paginacao', array('total_rows' => $nTotal, 'base_url' => $sUrl, 'per_page' => $nPerPage, 'cur_page' => $nPaginas));
        $sLinks = $this->paginacao->painel();
        return array('result' => $result, 'links' => $sLinks, 'total' => $nTotal);
    }

    public function save($vDados) {
        $vReg = array(
            'id_grupo_usuario' => $vDados["id_grupo_usuario"],
            'nome' => $vDados["nome"],
            'login' => $vDados["login"],
            'email' => $vDados["email"],
            'ativo' => $vDados["ativo"]
        );

        $this->load->library('encrypt');
        if (!empty($vDados['senha']))
            $vReg['senha'] = $this->encrypt->encode($vReg['senha']);
        
        return parent::save($vReg);
    }

    public function save_meus_dados($vDados, $nIdUsuario) {
        $vReg = array(
            'id' => $this->uri->segment(4),
            'nome' => $vDados["nome"],
            'login' => $vDados["login"],
            'email' => $vDados["email"],
        );

        if (!empty($vDados['senha']))
            $vReg['senha'] = $this->encrypt->encode($vDados['senha']);

        if ($this->usuario_model->update($vReg, $nIdUsuario)) {
            $this->sys_mensagem_model->setFlashData(9);
        } else {
            $this->sys_mensagem_model->setFlashData(2);
        }
    }

}
