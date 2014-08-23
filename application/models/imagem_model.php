<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class imagem_model extends abstract_model {

    public $vConfig = array();

    function __construct() {
        parent::__construct();
        $this->sTable = 'cms_imagem';   
        
        $this->vConfig['name'] = array(
            'default' => array('root' => FCPATH . "resources/upload/name/", 'url' => base_url() . "resources/upload/name/", 'bound' => array(300, 300))
        );
    }

    function upload($vFiles, $vData, $sType, $nQualidade = 70) {
        $this->load->library('upload_imagem');

        if (isset($this->vConfig[$sType]) AND !empty($vFiles)) {
            $vsNameImage = $this->upload_imagem->doUpload($vFiles, $this->vConfig[$sType], $nQualidade);

            if (!empty($vsNameImage)) {
                foreach ($vsNameImage as $sNameImage) {
                    $vData['imagem'] = $sNameImage;
                    $vData['nome'] = $sNameImage;
                    $this->insert($vData);
                }
            }
        }
    }

    function getImage($vDados, $sType) {
        $image = $this->db
                ->select('imagem')
                ->where($vDados)
                ->get($this->sTable)
                ->row('imagem');

        $vReturn = array();
        foreach ($this->vConfig[$sType] as $sTamanho => $sInfo) {
            if (is_file($sInfo['root'] . $image)) {
                $vReturn[$sTamanho] = $sInfo['url'] . $image;
            } else {
                $vReturn[$sTamanho] = base_url() . "resources/images/nopic.gif";
            }
        }

        return $vReturn;
    }

    function deleteImage($vDados, $sType) {
        $voImagem = $this->getAll($vDados);

        if (!empty($voImagem)) {
            foreach ($voImagem as $oImagem) {
                foreach ($this->vConfig[$sType] as $sInfo) {
                    if (is_file($sInfo['root'] . $oImagem->imagem))
                        unlink($sInfo['root'] . $oImagem->imagem);
                }
            }
        }

        return $this->db->delete($this->sTable, $vDados);
    }

    function alteraDestaque($vData, $bDestaque) {
        $this->db->update($this->sTable, array('destaque' => $bDestaque), $vData);
    }

}