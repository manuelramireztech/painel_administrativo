<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
interface Crud_Painel {

    public function index();

    public function adicionar();

    public function alterar();

    public function remover();

    public function save();
}
