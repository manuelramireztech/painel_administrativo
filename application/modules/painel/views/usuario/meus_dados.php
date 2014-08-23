<?php echo form_open('painel/usuario/save_meus_dados', 'class="form-horizontal form-validate" id="form"'); ?>
<div class="form-group">
    <label for="nome" class="col-sm-2">Nome: </label>
    <div class="col-sm-10">
        <?php echo form_input('nome', set_value('nome', isset($usuario) ? $usuario->nome : ''), 'size="80" id="nome" class="required form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-2">E-mail: </label>
    <div class="col-sm-10">
        <?php echo form_input('email', set_value('email', isset($usuario) ? $usuario->email : ''), 'size="50" id="email" class="required email form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="login" class="col-sm-2">Login: </label>
    <div class="col-sm-10">
        <?php echo form_input('login', set_value('login', isset($usuario) ? $usuario->login : ''), 'size="30" id="login" class="required form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="senha" class="col-sm-2">Senha: </label>
    <div class="col-sm-10">
        <?php echo form_password('senha', '', 'size="30" id="senha" data-rule-minlength="4" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="confirmar_senha" class="col-sm-2">Confirmar Senha: </label>
    <div class="col-sm-10">
        <?php echo form_password('confirmar_senha', '', 'size="30" id="confirmar_senha" data-rule-equalTo="#senha" class="form-control"'); ?>
    </div>
</div>
<div class="form-actions form-actions-padding text-right">
    <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>