<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class configuracao_model extends abstract_model {

    function __construct() {
        parent::__construct();
        $this->sTable = 'sys_configuracao';
    }

    function salvar($sNome, $sValor) {
        $this->db->update($this->sTable, array('valor' => $sValor), array('nome' => $sNome));
    }

    function getValor($sNome) {
        return $this->db
                        ->select('valor')
                        ->get_where($this->sTable, array('nome' => $sNome))
                        ->row('valor');
    }

}