<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class MY_Model extends CI_Model {

    protected $sTable, $bDeletado = FALSE;

    function __construct() {
        parent::__construct();
    }

    function getAll($vDados = array(), $sOrderBy = NULL, $nLimit = NULL) {
        if ($this->bDeletado) {
            if (is_array($vDados))
                $vDados['deletado'] = 0;
            else
                $vDados .= (empty($vDados) ? "" : " AND ") . "deletado = 0";
        }

        if (!empty($nLimit))
            $this->db->limit($nLimit);

        if (!empty($sOrderBy))
            $this->db->order_by($sOrderBy);

        return $this->db
                        ->where($vDados)
                        ->get($this->sTable)
                        ->result();
    }

    function get($nId, $sCampo = 'id') {
        $vDados = array($sCampo => $nId);
        if ($this->bDeletado)
            $vDados['deletado'] = 0;

        return $this->db
                        ->get_where($this->sTable, $vDados)
                        ->row(0);
    }

    function getCampo($vDados, $sCampo) {
        if ($this->bDeletado)
            $vDados['deletado'] = 0;

        return $this->db
                        ->select($sCampo, FALSE)
                        ->where($vDados)
                        ->get($this->sTable)
                        ->row($sCampo);
    }

    function getAllSelect($vDados = array(), $sCampo = 'nome', $sCampoConsulta = 'id', $sOrderBy = NULL, $nLimit = NULL) {
        if ($this->bDeletado)
            $vDados['deletado'] = 0;

        if (stripos($sCampo, ' as ') !== FALSE)
            $sCampo2 = trim(end(preg_split('/ (as|AS){1} /', $sCampo)));
        else
            $sCampo2 = $sCampo;

        if (!empty($nLimit))
            $this->db->limit($nLimit);

        if (empty($sOrderBy))
            $sOrderBy = $sCampo2;

        $vArray = array();
        $vvRow = $this->db
                ->select($sCampoConsulta . ', ' . $sCampo, FALSE)
                ->where($vDados)
                ->order_by($sOrderBy)
                ->get($this->sTable)
                ->result_array();

        if (empty($vvRow) == false) {
            foreach ($vvRow as $vsRow) {
                $vArray[$vsRow[$sCampoConsulta]] = $vsRow[$sCampo2];
            }
        }

        return $vArray;
    }

    function insert($vDados) {
        try {
            $this->saveLog("Adicionar", $vDados);
            return $this->db->insert($this->sTable, $vDados);
        } catch (Exception $exc) {
            return false;
        }
    }

    function update($vDados, $nId, $sCampo = 'id') {
        try {
            $this->saveLog("Alterar", $vDados);
            return $this->db->update($this->sTable, $vDados, array($sCampo => $nId));
        } catch (Exception $exc) {
            return false;
        }
    }

    function delete($nId, $sCampo = 'id') {
        $row = $this->db
                ->get_where($this->sTable, array($sCampo => $nId))
                ->row_array(0);
        $this->saveLog("Excluir", $row);
        return $this->db->delete($this->sTable, array($sCampo => $nId));
    }

    function remove($vId, $sCampo = 'id') {
        $this->saveLog("Excluir", array('Itens' => $vId));

        if (is_string($vId))
            $vId = explode(',', $vId);

        return $this->db
                        ->where_in($sCampo, $vId)
                        ->update($this->sTable, array('deletado' => 1));
    }

    function saveLog($sTitulo, $dados, $bForceSave = FALSE) {
        $vPainel = $this->session->userdata('painel');

        if ((!empty($dados) AND ( !empty($vPainel)) OR $bForceSave)) {
            $sDescricao = "";

            if (isset($dados['senha']))
                unset($dados['senha']);

            $dados = array_filter($dados);

            if (!empty($dados)) {
                foreach ($dados as $sIndice => $sDados) {
                    $sDados = Util::substr($sDados, 200);
                    $sDescricao .= Util::trataNome($sIndice) . ": $sDados\n";
                }

                if (!empty($sDescricao)) {
                    $vLog = array(
                        'nome' => $sTitulo,
                        'acesso' => $this->router->fetch_module() . "/" . $this->router->class . "/" . $this->router->method,
                        'descricao' => $sDescricao,
                        'id_usuario' => isset($vPainel['id']) ? $vPainel['id'] : NULL,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                    );

                    $this->db->insert('usu_log', $vLog);
                }
            }
        }
    }

}

?>
