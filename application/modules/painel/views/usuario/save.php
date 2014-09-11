<?php echo form_open('painel/usuario/' . $action, 'class="form-horizontal form-validate" role="form"'); ?>
<?php echo form_hidden('id', set_value('id', isset($oUsuario) ? $oUsuario->id : '')); ?>

<div class="form-group">
    <label for="id_grupo_usuario" class="col-sm-2">Grupo de Usuário: </label>
    <div class="col-sm-10">
        <?php echo form_dropdown('id_grupo_usuario', $vsGrupoUsuario, set_value('id_grupo_usuario', (isset($oUsuario) ? $oUsuario->id_grupo_usuario : 0)), 'id="id_grupo_usuario" class="required form-control "'); ?>
    </div>
</div>
<div class="form-group">
    <label for="nome" class="col-sm-2">Nome: </label>
    <div class="col-sm-10">
        <?php echo form_input('nome', (isset($oUsuario) ? $oUsuario->nome : ''), 'size="70" id="nome" class="required form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="login" class="col-sm-2">Login: </label>
    <div class="col-sm-10">
        <?php echo form_input('login', (isset($oUsuario) ? $oUsuario->login : ''), 'size="70" id="login" class="required form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-2">Email: </label>
    <div class="col-sm-10">
        <?php echo form_input('email', (isset($oUsuario) ? $oUsuario->email : ''), 'size="70" id="email" class="required email form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="senha" class="col-sm-2">Senha: </label>
    <div class="col-sm-10">
        <?php echo form_password('senha', '', 'size="30" id="senha" data-rule-minlength="4" class="form-control ' . (isset($oUsuario) ? '' : 'required') . '"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="confirmar_senha" class="col-sm-2">Confirmar Senha: </label>
    <div class="col-sm-10">
        <?php echo form_password('confirmar_senha', '', 'size="30" id="confirmar_senha" class="form-control" data-rule-equalTo="#senha"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="ativo" class="col-sm-2">Ativo: </label>
    <div class="col-sm-10">
        <?php echo form_radio('ativo', 1, (isset($oUsuario) ? (BOOL) $oUsuario->ativo : true), 'class=""'); ?> Sim 
        <?php echo form_radio('ativo', 0, (isset($oUsuario) ? (BOOL) !$oUsuario->ativo : false), 'class=""'); ?> Não
    </div>
</div>
<div class="form-actions form-actions-padding text-right">
    <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>