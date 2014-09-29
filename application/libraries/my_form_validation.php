<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!class_exists('my_form_validation')) {

    class my_form_validation extends CI_Form_validation {

        function __construct() {
            parent::__construct();
            $this->set_message("date_br", "A %s informada não é válida");
            $this->set_message("cpf", "CPF informado não é válido");
            $this->set_message("cnpj", "CNPJ informado não é válido");
            $this->set_message("is_unique_custom", "%s informado já existe");
            $this->set_message("opcoes", "%s informado não é válido");
        }

        protected function _execute($row, $rules, $postdata = NULL, $cycles = 0) {
            parent::_execute($row, $rules, $postdata, $cycles);

            //Aualiza o Objeto CI_Form_validation
            $OBJ = & _get_validation_object();
            $OBJ->_error_array = $this->_error_array;
            $OBJ->_field_data = $this->_field_data;
            $OBJ->_error_messages = $this->_error_messages;
            $OBJ->_error_prefix = $this->_error_prefix;
            $OBJ->_error_suffix = $this->_error_suffix;
            $OBJ->_safe_form_data = $this->_safe_form_data;
        }

        /**
         * <p>Valida data no padrão dd/mm/yyyy</p>
         * @example <p>$this->my_form_validation->set_rules('data_nascimento', 'Data de Nascimento', 'date_br');</p>
         *
         * @param	string data
         * @return	bool 
         */
        public function date_br($sDate) {
            list ( $nDia, $nMes, $nAno ) = explode('/', $sDate);
            return checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno);
        }

        /**
         * <p>Valida CPF</p>
         * @example <p>$this->my_form_validation->set_rules('cpf', 'CPF', 'cpf');</p>
         *
         * @param	string data
         * @return	bool 
         */
        public function cpf($sCpf) {
            $sCpf = preg_replace('/[.-]/', "", $sCpf);
            $proibidos = array('11111111111', '22222222222', '33333333333',
                '44444444444', '55555555555', '66666666666', '77777777777',
                '88888888888', '99999999999', '00000000000', '12345678909');
            if (is_numeric($sCpf) AND strlen($sCpf) == 11 AND ! in_array($sCpf, $proibidos)) {
                $a = 0;
                for ($i = 0; $i < 9; $i++) {
                    $a += ( $sCpf[$i] * (10 - $i));
                }
                $b = ($a % 11);
                $a = (($b > 1) ? (11 - $b) : 0);
                if ($a != $sCpf[9]) {
                    return false;
                }
                $a = 0;
                for ($i = 0; $i < 10; $i++) {
                    $a += ( $sCpf[$i] * (11 - $i));
                }
                $b = ($a % 11);
                $a = (($b > 1) ? (11 - $b) : 0);
                if ($a != $sCpf[10]) {
                    return false;
                }

                return true;
            } else {
                return false;
            }
        }

        /**
         * <p>Valida CNPJ</p>
         * @example <p>$this->my_form_validation->set_rules('cnpj', 'CNPJ', 'cnpj');</p>
         *
         * @param	string data
         * @return	bool 
         */
        public function cnpj($sCnpj) {
            $sCnpj = preg_replace('/[.\/-]/', "", $sCnpj);

            if (strlen($sCnpj) > 14)
                $sCnpj = substr($sCnpj, 1);

            $sum1 = 0;
            $sum2 = 0;
            $sum3 = 0;
            $calc1 = 5;
            $calc2 = 6;

            for ($i = 0; $i <= 12; $i++) {
                $calc1 = $calc1 < 2 ? 9 : $calc1;
                $calc2 = $calc2 < 2 ? 9 : $calc2;

                if ($i <= 11)
                    $sum1 += $sCnpj[$i] * $calc1;

                $sum2 += $sCnpj[$i] * $calc2;
                $sum3 += $sCnpj[$i];
                $calc1--;
                $calc2--;
            }

            $sum1 %= 11;
            $sum2 %= 11;

            return ($sum3 && $sCnpj[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $sCnpj[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $sCnpj : false;
        }

        /**
         * <p>Valida valor único no banco de dados</p>
         * <p>Similar a validação <b>is_unique</b> padrão do codeigniter. A diferença está no segundo e terceiro parâmetro passado para consulta, onde o valor é validado no banco</p>
         * @example <p>$this->my_form_validation->set_rules('login', 'Login', is_unique_custom[usuario.id,id,1]);</p><p>Resultado do Sql: SELECT * FROM `usuario` WHERE `id` != 1 AND `login` = 'administrador' LIMIT 1</p>
         * @example <p>$this->my_form_validation->set_rules('login', 'Login', is_unique_custom[usuario.id,id,1,true]);</p><p>Resultado do Sql: SELECT * FROM `usuario` WHERE `id` != 1 AND `deletado` = 0 AND `login` = 'administrador' LIMIT 1</p>
         *
         * @param	string data
         * @param	string data dividido em até 4 partes separados por vírgula [tabela.campo,campo para consulta,valor da consulta,true para considerar a exclusão lógica (não é obrigatório)]
         * @return	bool 
         */
        public function is_unique_custom($str, $field) {
            $nSeparador = substr_count($field, ',');

            if ($nSeparador < 2)
                return FALSE;
            elseif ($nSeparador < 3)
                $field .= ",";

            list($field, $param, $valor, $bDeletado) = explode(',', $field);
            list($table, $field) = explode('.', $field);

            if (!empty($param))
                $this->CI->db->where($param . " !=", $valor);

            if (!empty($bDeletado))
                $this->CI->db->where("deletado", 0);

            $query = $this->CI->db->get_where($table, array($field => $str), 1);
            echo $this->CI->db->last_query();
            exit;
            return $query->num_rows() === 0;
        }

        /**
         * <p>Valida um conjunto de opções.</p>
         * @example <p>$this->my_form_validation->set_rules('sexo', 'Sexo', 'opcoes[F,M]');</p>
         * @example <p>$this->my_form_validation->set_rules('cor', 'Cor', 'opcoes[branco,verde,azul,amarelo,preto,laranja]');</p>
         *
         * @param	string data
         * @param	string Opções separados por vírgula
         * @return	bool 
         */
        public function opcoes($str, $field) {
            return in_array($str, explode(',', $field));
        }

    }

}
