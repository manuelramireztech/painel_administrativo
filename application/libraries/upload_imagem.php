<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . '/libraries/wideimage/WideImage.php';

class upload_imagem {

    function upload_imagem() {
        $CI = & get_instance();
        log_message('Debug', 'WideImage class is loaded.');
    }

    function load($param = NULL) {
        return new WideImage();
    }

    function doUpload($vImage, $vvConfig, $nQualidade = 70) {
        $vsNameImage = array();

        if (isset($vImage[0])) {
            foreach ($vImage[0]['name'] as $nIndice => $sNameImagem) {
                if ($vImage['error'][$nIndice] === UPLOAD_ERR_OK) {
                    $vsImagemFile = array(
                        "name" => $sNameImagem,
                        "type" => $vImage['type'][$nIndice],
                        "tmp_name" => $vImage['tmp_name'][$nIndice],
                        "error" => $vImage['error'][$nIndice],
                        "size" => $vImage['size'][$nIndice]
                    );

                    $vsNameImage[] = self::doUploadImagem($vsImagemFile, $vvConfig, $nQualidade);
                }
            }
        } else {
            $sExtensao = strtolower(strrchr($vImage['name'], '.'));
            if ($sExtensao == '.zip') {
                $vsNameImage = self::doUploadImagemZip($vImage, FCPATH . "resources/upload/temp/", $vvConfig, $nQualidade);
            } else {
                $vsNameImage[] = self::doUploadImagem($vImage, $vvConfig, $nQualidade);
            }
        }

        return $vsNameImage;
    }

    function doUploadImagem($vImage, $vvConfig, $nQualidade = 70) {
        $sExtensao = self::VerificaExtensaoImagem($vImage['name']);
        $sName = NULL;
        
        if ($sExtensao == 'png')
            $nQualidade = ($nQualidade / 10) - 1;
        foreach ($vvConfig as $vConfig) {
            $sName = array_shift(explode('.', $vImage['name']));
            $sName = self::removeAcentuacao($sName);
            $sName = url_title($sName, '-', TRUE);
            $sName = self::validaNomeDaImagem(strtolower($sName), $sExtensao, $vConfig['root']);

            WideImage::load($vImage['tmp_name'])
                    ->resizeDown($vConfig['bound'][0], $vConfig['bound'][1])
                    ->saveToFile($vConfig['root'] . $sName, $nQualidade);
        }

        return $sName;
    }

    function doUploadImagemZip($vZip, $sDirTemp, $vvConfig, $nQualidade = 60) {
        $vsPathImages = array();
        $oZip = zip_open($vZip['tmp_name']);

        while ($vZip_entry = zip_read($oZip)) {
            $sFile = basename(zip_entry_name($vZip_entry));
            $sExtensao = strtolower(self::VerificaExtensaoImagem($sFile));

            if (preg_match("/(jpeg|jpg|png|gif)$/", $sExtensao) AND $sExtensao) {
                $sFile = iconv("UTF-8", "ISO-8859-1//IGNORE", $sFile);

                $Tmpname = $sDirTemp . basename($sFile);
                $oFp = fopen($Tmpname, "w+");

                if ($oFp) {
                    if (zip_entry_open($oZip, $vZip_entry, "r")) {
                        $sBuf = zip_entry_read($vZip_entry, zip_entry_filesize($vZip_entry));
                        zip_entry_close($vZip_entry);
                    }

                    fwrite($oFp, $sBuf);

                    $Tamanho = zip_entry_filesize($vZip_entry);

                    if (is_file($Tmpname)) {
                        if ($Tamanho > 0 && strlen($sFile) > 1 AND substr($sFile, 0, 1) !== '.') {  // verifica se tem arquivo enviado
                            foreach ($vvConfig as $vsConfiguracao) {
                                if (is_dir($vsConfiguracao["root"])) {
                                    $sFile = array_shift(explode('.', $sFile));
                                    $sFile = self::removeAcentuacao($sFile);
                                    $sFile = url_title($sFile, '-', TRUE);
                                    $sFile = self::validaNomeDaImagem(strtolower($sFile), $sExtensao, $vsConfiguracao['root']);
                                    $endFoto = $vsConfiguracao["root"] . $sFile;

                                    if (in_array($sFile, $vsPathImages) == false)
                                        $vsPathImages[] = $sFile;

                                    if ($nQualidade === -1) {
                                        if (is_uploaded_file($Tmpname))
                                            move_uploaded_file($Tmpname, $endFoto);
                                        else
                                            copy($Tmpname, $endFoto);
                                    } else {
                                        if ($sExtensao == 'png' OR $sExtensao == 'PNG')
                                            $nQualidade = ($nQualidade / 10) - 1;

                                        WideImage::load($Tmpname)
                                                ->resizeDown($vsConfiguracao["bound"][0], $vsConfiguracao["bound"][1])
                                                ->saveToFile($endFoto, $nQualidade);
                                    }
                                }
                            }
                        }
                    }

                    fclose($oFp);
                    @unlink($Tmpname);
                }
            }
        }

        return $vsPathImages;
    }

    private function verificaExtensaoImagem($verificaExtensao) {
        preg_match("/\.(jpeg|jpg|png|gif){1}$/i", $verificaExtensao, $ext);
        return isset($ext[1]) ? strtolower($ext[1]) : '';
    }

    private function validaNomeDaImagem($Nome, $sExtensao, $sRoot) { // acrescena conador na imagem caso exista nomes de imagens repetidas
        $existe = true;
        $cont = 1;
        $Nome = strtolower($Nome);
        $aux = "$Nome.$sExtensao";
        do {
            if (@file_exists($sRoot . $aux)) {
                $cont++;
                $aux = "{$Nome}-{$cont}.{$sExtensao}";
            }
            else
                $existe = false;
        }while ($existe);
        return $aux;
    }

    private function removeAcentuacao($string) {
        $characteres = array(
            '?' => 'S', '?' => 's', 'Ð' => 'Dj', '?' => 'Z', '?' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', '?' => 'f', ' ' => '-'
        );
        return strtr($string, $characteres);
    }

}

?>
