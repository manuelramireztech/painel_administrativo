<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
(defined('BASEPATH')) OR exit('No direct script access allowed');

require_once APPPATH . 'interfaces/Model_Painel.php';

class MY_Model extends CI_Model {

    protected $sTable = NULL;
    private $bDeletado = FALSE;

    /**
     * Constructor
     *
     * @access public
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Aplica nas consultas o valor 0 a coluna deletado. OBS: Os métodos filhos de MY_Model deverão aplicar nas consultas o valor 0 para o campo deletado.
     */
    protected function setDeletado() {
        $this->bDeletado = TRUE;
    }

    /**
     * Recupera todos da tabela $sTable
     *
     * @param	array Parâmetros de consulta (where)
     * @param	string [coluna] ASC ou DESC
     * @param	interger Quantidade de resultados. (limit)
     * @return	result 
     */
    public function getAll($vDados = array(), $sOrderBy = NULL, $nLimit = NULL) {
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
                        ->get($this->sTable);
    }

    /**
     * Recupera primeiro resultado da consulta
     *
     * @param	interger
     * @param	string coluna de referência para consulta. Default "id"
     * @return	object
     */
    public function get($nId, $sCampo = 'id') {
        $vDados = array($sCampo => $nId);
        if ($this->bDeletado)
            $vDados['deletado'] = 0;

        return $this->db
                        ->limit(1)
                        ->get_where($this->sTable, $vDados)
                        ->row(0);
    }

    /**
     * Recupera o campo específico da consulta
     *
     * @param	array Parâmetros de consulta (where)
     * @param	string Campo desejado. Ex: nome, COUNT(*), MAX(id), GROUP_CONCAT(id)
     * @return	string
     */
    public function getCampo($vDados, $sCampo) {
        if ($this->bDeletado)
            $vDados['deletado'] = 0;

        return $this->db
                        ->select($sCampo, FALSE)
                        ->where($vDados)
                        ->get($this->sTable)
                        ->row($sCampo);
    }

    /**
     * Recupera todos os registros para popular o helper form_helper do codeigniter, no método form_dropdown().
     * 
     * @link https://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
     * 
     * @param	array Parâmetros de consulta (where)
     * @param	string Campo desejado. Padrão o campo nome.
     * @param	string Campo desejado como índice. Padrão o campo id.
     * @param	string [coluna] ASC ou DESC
     * @param	interger Quantidade de resultados. (limit)
     * @return	array array(1 => "Maria", 2 => "João")
     */
    public function getAllSelect($vDados = array(), $sCampo = 'nome', $sCampoConsulta = 'id', $sOrderBy = NULL, $nLimit = NULL) {
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

    /**
     * Realiza o INSERT na tabela $sTable e registra o LOG (usu_log)
     *
     * @param	array Parâmetros de consulta (where)
     * @return	boolean
     */
    public function insert($vDados) {
        try {
            $this->saveLog("Adicionar", $vDados);
            return $this->db->insert($this->sTable, $vDados);
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Realiza o UPDATE na tabela $sTable e registra o LOG (usu_log)
     *
     * @param	array Parâmetros de consulta (where)
     * @param	string valor da coluna como parâmetro de alteração.
     * @param	string Campo desejado como para alteração. Por padrão camo <b>"id"</b>
     * @example <p>$this->table_model->update(array("nome" => "Maria"), 1, "id");</p><p>MySql: UPDATE table SET nome = "Maria" WHERE id = "1"</p>
     * @example <p>$this->table_model->update(array("nome" => "Maria"), 'maria@mail.com', "email");</p><p>MySql: UPDATE table SET nome = "Maria" WHERE email = "maria@mail.com"</p>
     * @return	boolean
     */
    public function update($vDados, $nId, $sCampo = 'id') {
        try {
            $vRow = $this->db->where(array($sCampo => $nId))->get($this->sTable)->row_array(0);
            $vLog = array();
            foreach ($vDados as $sIndice => $sValor) {
                if (isset($vRow[$sIndice]))
                    $vLog[$sIndice] = "{$vRow[$sIndice]} => {$sValor}";
            }

            $this->saveLog("Alterar", $vLog);
            return $this->db->update($this->sTable, $vDados, array($sCampo => $nId));
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Realiza o DELETE na tabela $sTable e registra o LOG (usu_log)
     *
     * @param	string valor da coluna como parâmetro de exclusão.
     * @param	string Campo desejado como para alteração. Por padrão camo <b>"id"</b>
     * @example <p>$this->table_model->delete(1, "id");</p><p>MySql: DELETE FROM table WHERE id = "1"</p>
     * @example <p>$this->table_model->delete('maria@mail.com', "email");</p><p>DELETE FROM table WHERE email = "maria@mail.com"</p>
     * @return	boolean
     */
    public function delete($nId, $sCampo = 'id') {
        $row = $this->db
                ->get_where($this->sTable, array($sCampo => $nId))
                ->row_array(0);
        $this->saveLog("Excluir", $row);
        return $this->db->delete($this->sTable, array($sCampo => $nId));
    }

    /**
     * <p>Realiza o UPDATE do campo <b>deletado</b> na tabela $sTable e registra o LOG (usu_log). Caso $bDeletado seja igual a FALSE o método delete() é chamado.</p>
     * <p></p>
     *
     * @param	string valor da coluna como parâmetro de exclusão.
     * @param	string Campo desejado como para alteração. Por padrão camo <b>"id"</b>
     * @example <p>$this->table_model->remove(1, "id");</p><p>MySql: UPDATE table SET deletado = "1" WHERE id = "1"</p>
     * @example <p>$this->table_model->remove('maria@mail.com', "email");</p><p>UPDATE table SET deletado = "1" WHERE email = "maria@mail.com"</p>
     * @return	boolean
     */
    public function remove($nId, $sCampo = 'id') {
        if ($this->bDeletado == FALSE)
            return $this->delete($nId, $sCampo);

        $row = $this->db
                ->get_where($this->sTable, array($sCampo => $nId))
                ->row_array(0);
        $this->saveLog("Excluir", $row);

        return $this->db
                        ->where($sCampo, $nId)
                        ->update($this->sTable, array('deletado' => 1));
    }

    /**
     * <p>Gera um valor rândomico não existente na tabela.</p>
     * @param	string Coluna de referência da tabela
     * @param	interger Quantidade caracteres números que serão retornados
     * @param	interger Adiciona valor no inicio
     * @return interger Valor único na tabela. <b>Obs:</b>Retorna <i>NULL</i> caso não haja valor disponível.
     */
    public function randomInterger($sCampo = "id", $nTamanho = 9, $nPrefixo = '') {
        $nValor = NULL;

        //PARA EVITAR LOOP INFINITO
        $sCach = '';
        $nControleLoop = 3;

        if (!empty($nPrefixo)) {
            $nTamanho = $nTamanho < strlen($nPrefixo) ? 0 : $nTamanho - strlen($nPrefixo);
        }

        do {
            $nValor = $nPrefixo . Util::gerarSenha($nTamanho, FALSE, FALSE, TRUE, FALSE);

            $bExiste = $this->db
                    ->select('COUNT(*) AS total')
                    ->get_where($this->sTable, array($sCampo => $nValor))
                    ->row('total');

            if (strpos($sCach, $nValor . ',') !== FALSE)
                $nControleLoop--;
            else
                $sCach .= $nValor . ',';

            if ($nControleLoop == 0)
                $nValor = NULL;
        } while ($bExiste > 0 AND $nControleLoop > 0);

        return (INT) $nValor;
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
    public function saveLog($sTitulo, $vDados) {
        $vPainel = $this->session->userdata('painel');

        if (!empty($vDados)) {
            $sDescricao = "";

            if (isset($vDados['senha']))
                unset($vDados['senha']);

            $vDados = array_filter($vDados);

            if (!empty($vDados)) {
                $this->load->helper('text');

                foreach ($vDados as $sIndice => $sDados) {
                    $sDados = character_limiter($sDados, 200);
                    $sDescricao .= Util::trataNome($sIndice) . ": $sDados\n";
                }

                if (!empty($sDescricao)) {
                    $vLog = array(
                        'nome' => $sTitulo,
                        'descricao' => $sDescricao,
                        'acesso' => $this->router->fetch_module() . "/" . $this->router->class . "/" . $this->router->method,
                        'id_usuario' => isset($vPainel['id']) ? $vPainel['id'] : NULL,
                        'ip' => $this->input->ip_address(),
                    );

                    $this->db->insert('usu_log', $vLog);
                }
            }
        }
    }

}

?>
