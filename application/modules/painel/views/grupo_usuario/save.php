<?php echo form_open('painel/grupo_usuario/save', 'class="form-horizontal form-validate" role="form"'); ?>
<?php echo form_hidden('id', set_value('id', isset($oGrupoUsuario) ? $oGrupoUsuario->id : '')); ?>

<div class="form-group">
    <label for="nome" class="col-sm-2">Nome: </label>
    <div class="col-sm-10">
        <?php echo form_input('nome', (isset($oGrupoUsuario) ? $oGrupoUsuario->nome : ''), 'size="45" id="nome" class="required form-control"'); ?>
    </div>
</div>
<div class="form-actions form-actions-padding text-right">
    <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>