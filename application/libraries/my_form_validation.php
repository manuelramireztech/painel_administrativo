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

        public function date_br($sDate) {
            $sDate = substr($sDate, 0, 10);// 00/00/0000
            list ( $nDia, $nMes, $nAno ) = explode('/', $sDate);
            return checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno);
        }

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

        public function is_unique_custom($str, $field) {
            list($field, $param, $valor) = explode(',', $field);
            list($table, $field) = explode('.', $field);

            if (!empty($param))
                $this->CI->db->where($param . " !=", $valor);

            $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
            return $query->num_rows() === 0;
        }

        public function opcoes($str, $field) {
            return in_array($str, explode(',', $field));
        }

    }
}