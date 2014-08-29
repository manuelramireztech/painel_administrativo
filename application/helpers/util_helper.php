<?

class Util {

    static function decimalParaBanco($valor) {
        return str_replace(",", ".", str_replace(".", "", str_replace('R$', '', trim($valor))));
    }

    static function decimalParaPagina($valor, $decimals = 2) {
        return number_format($valor, $decimals, ",", ".");
    }

    static function removeAcentuacao($string) {
        $characteres = array(
            'Ð' => 'Dj', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
        );
        return strtr($string, $characteres);
    }

    static function getSemana($var) {
        // Usar funcao date('w'); do php
        switch ($var) {
            case"0": return $var = "Domingo";
                break;
            case"1": return $var = "Segunda-Feira";
                break;
            case"2": return $var = "Ter&ccedil;a-Feira";
                break;
            case"3": return $var = "Quarta-Feira";
                break;
            case"4": return $var = "Quinta-Feira";
                break;
            case"5": return $var = "Sexta-Feira";
                break;
            case"6": return $var = "S&aacute;bado";
                break;
        }
    }

    static function getSemanaCurto($var) {
        // Usar funcao date('w'); do php
        switch ($var) {
            case"0": return $var = "Dom";
                break;
            case"1": return $var = "Seg";
                break;
            case"2": return $var = "Ter";
                break;
            case"3": return $var = "Qua";
                break;
            case"4": return $var = "Qui";
                break;
            case"5": return $var = "Sex";
                break;
            case"6": return $var = "Sab";
                break;
        }
    }

    static function getMes($var) {
        // Usar funcao date('n'); do php
        switch ($var) {
            case"1": return $var = "Janeiro";
                break;
            case"2": return $var = "Fevereiro";
                break;
            case"3": return $var = "Mar&ccedil;o";
                break;
            case"4": return $var = "Abril";
                break;
            case"5": return $var = "Maio";
                break;
            case"6": return $var = "Junho";
                break;
            case"7": return $var = "Julho";
                break;
            case"8": return $var = "Agosto";
                break;
            case"9": return $var = "Setembro";
                break;
            case"10": return $var = "Outubro";
                break;
            case"11": return $var = "Novembro";
                break;
            case"12": return $var = "Dezembro";
                break;
        }
    }

    static function getMesCurto($var) {
        // Usar funcao date('n'); do php
        switch ($var) {
            case"1": return $var = "jan";
                break;
            case"2": return $var = "fev";
                break;
            case"3": return $var = "mar";
                break;
            case"4": return $var = "abr";
                break;
            case"5": return $var = "mai";
                break;
            case"6": return $var = "jun";
                break;
            case"7": return $var = "jul";
                break;
            case"8": return $var = "ago";
                break;
            case"9": return $var = "set";
                break;
            case"10": return $var = "out";
                break;
            case"11": return $var = "nov";
                break;
            case"12": return $var = "dez";
                break;
        }
    }

    private static function converteDmaParaAmd($sData, $sSeparador = "", $bValidate = FALSE) {
        if (!empty($sData)) {
            $sSeparadorQuebra = !is_numeric($sData[2]) ? $sData[2] : (!is_numeric($sData[4]) ? $sData[4] : "/");

            list ( $nDia, $nMes, $nAno ) = explode($sSeparadorQuebra, $sData);

            $sSeparador = $sSeparador ? $sSeparador : $sSeparadorQuebra;
            if (checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno))
                return ($nAno . $sSeparador . $nMes . $sSeparador . $nDia);
            else
                return $bValidate ? NULL : $sData;
        } else {
            return $bValidate ? NULL : $sData;
        }
    }

    static public function converteDataParaBanco($sDataHora, $bValidate = FALSE) {
        if (!empty($sDataHora)) {
            $sDataHora = explode(" ", trim($sDataHora));
            $sDataHora[0] = self::converteDmaParaAmd($sDataHora[0], "-", $bValidate);

            return !empty($sDataHora[0]) ? trim(implode(" ", $sDataHora)) : NULL;
        } else {
            return NULL;
        }
    }

    private static function converteAmdParaDma($sData, $sSeparador = "", $bValidate = FALSE) {
        if (!empty($sData)) {
            $sSeparadorQuebra = !is_numeric($sData[4]) ? $sData[4] : (!is_numeric($sData[2]) ? $sData[2] : "-");

            list ( $nAno, $nMes, $nDia ) = explode($sSeparadorQuebra, $sData);

            $sSeparador = $sSeparador ? $sSeparador : $sSeparadorQuebra;
            if (checkdate((INT) $nMes, (INT) $nDia, (INT) $nAno))
                return ($nDia . $sSeparador . $nMes . $sSeparador . $nAno);
            else
                return $bValidate ? NULL : $sData;
        } else {
            return $bValidate ? NULL : $sData;
        }
    }

    static public function converteDataParaPagina($sDataHora, $bValidate = FALSE) {
        if (!empty($sDataHora)) {
            $sDataHora = explode(" ", trim($sDataHora));
            $sDataHora[0] = self::converteAmdParaDma($sDataHora[0], "/", $bValidate);

            return !empty($sDataHora[0]) ? trim(implode(" ", $sDataHora)) : NULL;
        } else {
            return NULL;
        }
    }

    static function printR($sValor) {
        echo "\n\n<pre>\n";
        print_r($sValor);
        echo "\n</pre>\n\n";
    }

    static function varDump($sValor) {
        echo "\n\n<pre>\n";
        var_dump($sValor);
        echo "\n</pre>\n\n";
    }

    static function validaCPF($nCpf) {
        $nCpf = ereg_replace('[.-]', "", $nCpf);
        $proibidos = array('11111111111', '22222222222', '33333333333',
            '44444444444', '55555555555', '66666666666', '77777777777',
            '88888888888', '99999999999', '00000000000', '12345678909');
        if (is_numeric($nCpf) AND strlen($nCpf) == 11 AND ! in_array($nCpf, $proibidos)) {
            $a = 0;
            for ($i = 0; $i < 9; $i++) {
                $a += ( $nCpf[$i] * (10 - $i));
            }
            $b = ($a % 11);
            $a = (($b > 1) ? (11 - $b) : 0);
            if ($a != $nCpf[9]) {
                return false;
            }
            $a = 0;
            for ($i = 0; $i < 10; $i++) {
                $a += ( $nCpf[$i] * (11 - $i));
            }
            $b = ($a % 11);
            $a = (($b > 1) ? (11 - $b) : 0);
            if ($a != $nCpf[10]) {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    static function validaCNPJ($str) {
        if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
            return false;

        array_shift($matches);

        $str = implode('', $matches);
        if (strlen($str) > 14)
            $str = substr($str, 1);

        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $calc1 = 5;
        $calc2 = 6;

        for ($i = 0; $i <= 12; $i++) {
            $calc1 = $calc1 < 2 ? 9 : $calc1;
            $calc2 = $calc2 < 2 ? 9 : $calc2;

            if ($i <= 11)
                $sum1 += $str[$i] * $calc1;

            $sum2 += $str[$i] * $calc2;
            $sum3 += $str[$i];
            $calc1--;
            $calc2--;
        }

        $sum1 %= 11;
        $sum2 %= 11;

        return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $str : false;
    }

    static function gerarSenha($tamanho = 6, $maiuscula = true, $minuscula = true, $numeros = true, $codigos = false) {
        $maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $minus = "abcdefghijklmnopqrstuwxyz";
        $numer = "0123456789";
        $codig = '!@#$%&*()-+.,;?{[}]^><:|';

        $base = '';
        $base .= ($maiuscula) ? $maius : '';
        $base .= ($minuscula) ? $minus : '';
        $base .= ($numeros) ? $numer : '';
        $base .= ($codigos) ? $codig : '';

        srand((float) microtime() * 10000000);
        $senha = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= substr($base, rand(0, strlen($base) - 1), 1);
        }
        return $senha;
    }

    static function substr($sString, $nComprimento = 100, $sUltimaOcorencia = " ") {
        $sString = strip_tags($sString);

        if (strlen($sString) > $nComprimento) {
            $sString = substr($sString, 0, $nComprimento);
            $sString = substr($sString, 0, strrpos($sString, $sUltimaOcorencia));
            return $sString . " (...)";
        } else {
            return $sString;
        }
    }

    static function dateDiff($sDe, $sAte) {
        if ($sDe AND $sAte) {
            $sDe = strtotime(Util::converteDataParaBanco($sDe));
            $sAte = strtotime(Util::converteDataParaBanco($sAte));

            if ($sDe < $sAte)
                return floor(($sAte - $sDe) / 86400);
            else
                return ceil(($sAte - $sDe) / 86400);
        } else
            return false;
    }

    static function array2xml($x, $debug = false, $header = true) {
        $enterchar = "";
        if (empty($x))
            return false;

        if ($debug)
            $enterchar = "\n";

        if ($header) {
            header('Content-Type: text/xml; charset=UTF-8');
            header('Content-Disposition: inline; filename=file.xml');

            echo '<?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>' . $enterchar;
            echo '<root>' . $enterchar;
        }

        foreach ($x as $field => $value) {
            $temp = explode(' ', $field);
            $field2 = $temp[0];
            if (is_array($value)) {
                if (is_numeric($field)) {
                    $field = 'reg id="' . $field . '"';
                    $field2 = 'reg';
                }
                echo '<' . $field . '>' . $enterchar;
                array2xml($value, $debug, false);
                echo '</' . $field2 . '>' . $enterchar;
            } else {

                if (!is_numeric($field)) {
                    if ((strpos($value, '<') !== false) || (strpos($value, '>') !== false) || (strpos($value, '&') !== false)) {
                        echo '<' . $field . '><![CDATA[' . $value . ']]></' . $field2 . '>' . $enterchar;
                    } else
                        echo '<' . $field . '>' . $value . '</' . $field2 . '>' . $enterchar;
                }

                //Strip numeric keys to economize
                /*
                  if(!is_numeric($field)) {
                  if((is_numeric($value)) || empty($value) || (!$usarcdata)) echo "<$field>$value</$field2>$enterchar";
                  else echo "<$field><![CDATA[$value]]></$field2>$enterchar";
                  }
                 */
            }
        }

        if ($header)
            echo '</root>';
    }

    static function traraCpfCnpj($sValor) {
        return preg_replace('/[.\/-]/', '', $sValor);
    }

    static function tempoDecorrido($AnoMesDiaInicio, $AnoMesDiaFim = NULL) {
        if (empty($AnoMesDiaFim))
            $AnoMesDiaFim = date("Y-m-d H:i:s");

        $time = abs(strtotime($AnoMesDiaFim) - strtotime($AnoMesDiaInicio)); // to get the time since that moment

        $tokens = array(31536000 => 'ano', 2592000 => 'mês', 604800 => 'semana', 86400 => 'dia', 3600 => 'hora', 60 => 'minuto', 1 => 'segundo', 0 => 'agora');

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            if (0 == $unit)
                return 'pouco tempo'; //há ?

            $numberOfUnits = floor($time / $unit);
            $text = ($text == 'mês' && $numberOfUnits > 1) ? 'mese' : $text;
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }

    static function removeHtml($sText) {
        return htmlspecialchars(strip_tags($sText), ENT_QUOTES);
    }

    static function trataNome($sNome) {
        $sNome = str_ireplace('_', ' ', $sNome);
        $sNome = ucwords($sNome);
        
        $sNome = str_ireplace('cao', 'ção', $sNome);
        $sNome = str_ireplace('icia', 'ícia', $sNome);
        $sNome = str_ireplace('ssao', 'ssão', $sNome);
        $sNome = str_ireplace('aria', 'ária', $sNome);
        $sNome = str_ireplace('ario', 'ário', $sNome);
        $sNome = str_ireplace('encia', 'ência', $sNome);
        $sNome = str_ireplace('Numero', 'Número', $sNome);
        $sNome = str_ireplace('Endereco', 'endereço', $sNome);
        $sNome = str_ireplace('images', 'imagens', $sNome);
        $sNome = str_ireplace('cien', 'ciên', $sNome);
        $sNome = str_ireplace('metodos', 'métodos', $sNome);
        return $sNome;
    }

}

?>