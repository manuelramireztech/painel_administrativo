<script>
    $(function() {
        $("input[name=tipo]").click(function() {
            var val = $(this).val();
            $("div.tipo-link, div.tipo-conteudo").hide();
            $("div.tipo-" + val).slideDown();

        });
    });
</script>
<?php echo form_open('painel/pagina/save', 'class="form-validate form-horizontal" role="form"'); ?>
<?php echo form_hidden('id', set_value('id', isset($oPagina) ? $oPagina->id : '')); ?>

<div class="form-group">
    <label for="id_pagina" class="col-sm-2">Pagina: </label>
    <div class="col-sm-10">
        <?php echo form_dropdown('id_pagina', $vsPagina, (isset($oPagina) ? $oPagina->id_pagina : 0), 'id="id_pagina" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="nome" class="col-sm-2">Nome: </label>
    <div class="col-sm-10">
        <?php echo form_input('nome', (isset($oPagina) ? $oPagina->nome : ''), 'size="70" id="nome" class="form-control required"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="tipo" class="col-sm-2">Tipo: </label>
    <div class="col-sm-10">
        <?php echo form_radio('tipo', 'menu', (isset($oPagina) ? $oPagina->tipo == 'menu' : true), 'class="required"'); ?> Menu<br />
        <?php echo form_radio('tipo', 'conteudo', (isset($oPagina) ? $oPagina->tipo == 'conteudo' : ''), 'class="required"'); ?> Conteudo<br />
        <?php echo form_radio('tipo', 'link', (isset($oPagina) ? $oPagina->tipo == 'link' : ''), 'class="required"'); ?> Link
    </div>
</div>
<?php
$sTipo = '';
if (isset($oPagina))
    $sTipo = $oPagina->tipo;
?>
<div class="form-group tipo-link" style="display: <?php echo $sTipo == 'link' ? 'block' : 'none' ?>;">
    <label for="url" class="col-sm-2">URL: </label>
    <div class="col-sm-10">
        <?php echo form_input('url', (isset($oPagina) ? $oPagina->url : ''), 'size="70" id="url" class="form-control"'); ?>
        <br /><small><strong>%BASE_ULR%:</strong> <?php echo base_url(); ?></small>
    </div>
</div>
<div class="form-group tipo-conteudo" style="display: <?php echo $sTipo == 'conteudo' ? 'block' : 'none' ?>;">
    <label for="texto" class="col-sm-2">Texto: </label>
    <div class="col-sm-10">
        <?php echo form_textarea('texto', (isset($oPagina) ? $oPagina->texto : ''), 'class=" tinymce"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="ativo" class="col-sm-2">Ativo: </label>
    <div class="col-sm-10">
        <?php echo form_radio('ativo', 1, (isset($oPagina) ? (BOOL) $oPagina->ativo : true), 'class=""'); ?> Sim 
        <?php echo form_radio('ativo', 0, (isset($oPagina) ? (BOOL) !$oPagina->ativo : false), 'class=""'); ?> Não
    </div>
</div>
<div class="form-actions form-actions-padding text-right">
    <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>