<?php 

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */

?>

<section class="panel">
    <header class="panel-heading tab-bg-dark-navy-blue">
        <ul class="nav nav-tabs nav-justified ">
            <li class="active">
                <a href="#tabs-geral" data-toggle="tab">Geral</a>
            </li>
            <li>
                <a href="#tabs-email" data-toggle="tab">E-mail</a>
            </li>
        </ul>
    </header>

    <div class="panel-body">
        <div class="tab-content tasi-tab">
            <div class="tab-pane active" id="tabs-geral">
                <article class="media">
                    <div class="media-body">
                        <?php echo form_open('painel/configuracao/save', 'class="form-horizontal form-validate" role="form"'); ?>
                        <div class="form-group">
                            <label for="configuracao[EMAIL_CONTATO]" class="col-sm-2">E-mail de Contato no site: </label>
                            <div class="col-sm-10">
                                <?php echo form_input('configuracao[EMAIL_CONTATO]', $vConfiguracao['EMAIL_CONTATO'], 'size="10" class="form-control" id="configuracao[EMAIL_CONTATO]"'); ?>
                            </div>
                        </div>

                        <div class="form-actions form-actions-padding text-right">
                            <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </article>
            </div>
            <div class="tab-pane" id="tabs-email">
                <article class="media">
                    <div class="media-body">
                        <?php echo form_open('painel/configuracao/save', 'class="form-horizontal form-validate"'); ?>
                        <div class="form-group">
                            <label for="configuracao[EMAIL_SMTP]" class="col-sm-2">SMPT: </label>
                            <div class="col-sm-10">
                                <?php echo form_input('configuracao[EMAIL_SMTP]', $vConfiguracao['EMAIL_SMTP'], 'size="10" id="configuracao[EMAIL_SMTP]" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="configuracao[EMAIL_USERNAME]" class="col-sm-2">Usuário ou E-mail: </label>
                            <div class="col-sm-10">
                                <?php echo form_input('configuracao[EMAIL_USERNAME]', $vConfiguracao['EMAIL_USERNAME'], 'size="10" id="configuracao[EMAIL_USERNAME]" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="configuracao[EMAIL_PASSWORD]" class="col-sm-2">Senha: </label>
                            <div class="col-sm-10">
                                <?php echo form_input('configuracao[EMAIL_PASSWORD]', $vConfiguracao['EMAIL_PASSWORD'], 'size="10" id="configuracao[EMAIL_PASSWORD]" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="configuracao[EMAIL_PORT]" class="col-sm-2">Porta: </label>
                            <div class="col-sm-10">
                                <?php echo form_input('configuracao[EMAIL_PORT]', $vConfiguracao['EMAIL_PORT'], 'size="10" id="configuracao[EMAIL_PORT]" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-actions form-actions-padding text-right">
                            <?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>