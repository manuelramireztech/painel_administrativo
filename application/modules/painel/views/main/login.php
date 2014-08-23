<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        
        <link href="<?php echo base_url(); ?>resources/painel/assets/stylesheets/bootstrap/bootstrap.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>resources/painel/assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>resources/painel/assets/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
          <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
          <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class='contrast-fb login contrast-background'>
        <div class='middle-container'>
            <div class='middle-row'>
                <div class='middle-wrapper'>
                    <div class='login-container-header'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='text-center'>
                                        <?php echo NOME_CLIENTE; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='login-container'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-sm-4 col-sm-offset-4'>
                                    <h1 class='text-center title'>Login</h1>
                                    
                                    <?php $this->sys_mensagem_model->exibirMensagem(); ?>
                                    <form action='<?php echo base_url(); ?>painel/main/dologin' class='form-validate' method='post'>
                                        <div class='form-group'>
                                            <div class='controls with-icon-over-input'>
                                                <input value="" placeholder="Login" class="form-control" data-rule-required="true" name="user" type="text" />
                                                <i class='icon-user text-muted'></i>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='controls with-icon-over-input'>
                                                <input value="" placeholder="Senha" class="form-control" data-rule-required="true" name="pass" type="password" />
                                                <i class='icon-lock text-muted'></i>
                                            </div>
                                        </div>
                                        <button class='btn btn-block'>Login</button>
                                    </form>
                                    <div class='text-center'>
                                        <hr class='hr-normal'>
                                        <a data-toggle="modal" href="#myModal" href='javascript:;'>Esqueceu sua senha?</a>
                                    </div>

                                    <!-- Modal -->
                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                        <div class="modal-dialog">
                                            <form class="form-validate" method="POST" action="<?php echo base_url(); ?>painel/main/recupera">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Esqueceu sua senha?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Informe seu login para recuperar por e-mail sua senha.</p>
                                                        <input type="text" name="user" required placeholder="Login" autocomplete="off" class="form-control placeholder-no-fix">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                                        <button class="btn btn-success" type="submit">Recuperar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='login-container-footer'></div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/theme.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/messages_pt_BR.js" type="text/javascript"></script>


    </body>
</html>

<!-- Localized -->