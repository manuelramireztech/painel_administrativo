<script src="<?php echo base_url(); ?>resources/javascripts/plugins/validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>resources/javascripts/plugins/validation/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>resources/javascripts/plugins/validation/messages_pt_BR.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#form-contato').validate();
    });
</script>
<style>
    .error {
        color: #cd0000;
    }
    .valid {
        border: 1px solid #05B319;
    }
</style>
<?php echo form_open('pages/envia_contato', 'class="form-horizontal form-validate" id="form-contato""'); ?>
<input name="campo-isca" id="campo-isca" value="" style="position: absolute; top: -10000px;left: -100000px" />
<div class="form-group">
    <label for="nome">Nome: </label>
    <div class="controls">
        <?php echo form_input('nome', set_value('nome'), 'size="70" id="nome" class="form-control required "'); ?>
    </div>
</div>
<div class="form-group">
    <label for="email">E-mail: </label>
    <div class="controls">
        <?php echo form_input('email', set_value('email'), 'size="70" id="email" class="form-control required email"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="assunto">Assunto: </label>
    <div class="controls">
        <?php echo form_input('assunto', set_value('assunto'), 'size="70" id="assunto" class="form-control required"'); ?>
    </div>
</div>
<div class="form-group">
    <label for="mensagem">Mensagem: </label>
    <div class="controls">
        <?php echo form_textarea('mensagem', set_value('mensagem'), 'id="mensagem" class="form-control required" rows="3"'); ?>
    </div>
</div>
<div class="form-group">
    <label></label>
    <div class="controls">
        <button class="btn" type="submit">Enviar</button>
    </div>
</div>
<?php echo form_close(); ?>