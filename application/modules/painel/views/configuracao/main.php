<?php
/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
?>

<?php echo form_open('painel/configuracao', 'class="form-horizontal form-validate" role="form"'); ?>
<h4>GERAL</h4>
<div class="form-group">
    <label for="configuracao[EMAIL_CONTATO]" class="col-sm-2">E-mail de Contato no site: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_CONTATO]', $vConfiguracao['EMAIL_CONTATO'], 'size="10" class="form-control" id="configuracao[EMAIL_CONTATO]"'); ?>
    </div>
</div>

<h4>ENVIO DE E-MAIL</h4>
<div class="form-group">
    <label for="configuracao[EMAIL_SMTP]" class="col-sm-2">SMTP: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_SMTP]', $vConfiguracao['EMAIL_SMTP'], 'size="10" id="configuracao[EMAIL_SMTP]" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_USERNAME]" class="col-sm-2">Usuário (SMTP): </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_USERNAME]', $vConfiguracao['EMAIL_USERNAME'], 'size="10" id="configuracao[EMAIL_USERNAME]" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_PASSWORD]" class="col-sm-2">Senha (SMTP): </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_PASSWORD]', $vConfiguracao['EMAIL_PASSWORD'], 'size="10" id="configuracao[EMAIL_PASSWORD]" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_FROM]" class="col-sm-2">E-mail Remetente: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_FROM]', $vConfiguracao['EMAIL_FROM'], 'size="10" id="configuracao[EMAIL_FROM]" class="form-control email"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_FROM_NAME]" class="col-sm-2">Nome Remetente: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_FROM_NAME]', $vConfiguracao['EMAIL_FROM_NAME'], 'size="10" id="configuracao[EMAIL_FROM_NAME]" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_SECURE]" class="col-sm-2">Segurança: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_SECURE]', $vConfiguracao['EMAIL_SECURE'], 'size="10" id="configuracao[EMAIL_PORT]" class="form-control"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="configuracao[EMAIL_PORT]" class="col-sm-2">Porta: </label>
    <div class="col-sm-10">
        <?php echo form_input('configuracao[EMAIL_PORT]', $vConfiguracao['EMAIL_PORT'], 'size="10" id="configuracao[EMAIL_PORT]" class="form-control digits"'); ?>
    </div>
</div>

<div class="form-actions form-actions-padding text-right">
    <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
</div>
<?php echo form_close(); ?>