<?php

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */


class paginacao {

    private $CI, $vConfig = array();

    public function __construct($vParam) {
        $this->CI = &get_instance();
        $this->CI->load->library('pagination');
        
        $this->vConfig['page_query_string'] = TRUE;
        $this->vConfig['query_string_segment'] = 'per_page';
        $this->vConfig['num_links'] = 4;
        $this->vConfig['first_link'] = 'Primeira';
        $this->vConfig['last_link'] = 'Última';
        
        $this->vConfig = array_merge($this->vConfig, $vParam);
    }

    function painel() {
        $this->vConfig['full_tag_open'] = '<div class="dataTables_paginate paging_bootstrap pagination"><ul>';
        $this->vConfig['full_tag_close'] = '<ul/><div/>';
        $this->vConfig['first_tag_open'] = '<li>';
        $this->vConfig['first_tag_close'] = '</li>';
        $this->vConfig['last_tag_open'] = '<li>';
        $this->vConfig['last_tag_close'] = '</li>';
        $this->vConfig['next_tag_open'] = '<li>';
        $this->vConfig['next_tag_close'] = '</li>';
        $this->vConfig['prev_tag_open'] = '<li>';
        $this->vConfig['prev_tag_close'] = '</li>';
        $this->vConfig['cur_tag_open'] = '<li class="active"><a href="javascript: void(0)">';
        $this->vConfig['cur_tag_close'] = '</a></li>';
        $this->vConfig['num_tag_open'] = '<li>';
        $this->vConfig['num_tag_close'] = '</li>';

        $this->CI->pagination->initialize($this->vConfig);
        return $this->CI->pagination->create_links();
    }

    function bootstrap() {
        $this->vConfig['full_tag_open'] = '<div class="pagination"><ul>';
        $this->vConfig['full_tag_close'] = '</ul></div>';
        $this->vConfig['first_tag_open'] = '<li>';
        $this->vConfig['first_tag_close'] = '</li>';
        $this->vConfig['last_tag_open'] = '<li>';
        $this->vConfig['last_tag_close'] = '</li>';
        $this->vConfig['next_tag_open'] = '<li>';
        $this->vConfig['next_tag_close'] = '</li>';
        $this->vConfig['prev_tag_open'] = '<li>';
        $this->vConfig['prev_tag_close'] = '</li>';
        $this->vConfig['cur_tag_open'] = '<li class="active"><a href="javascript: void(0)">';
        $this->vConfig['cur_tag_close'] = '</a></li>';
        $this->vConfig['num_tag_open'] = '<li>';
        $this->vConfig['num_tag_close'] = '</li>';

        $this->CI->pagination->initialize($this->vConfig);
        return $this->CI->pagination->create_links();
    }

}

?>
