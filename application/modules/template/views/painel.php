<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>

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

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>resources/painel/assets/stylesheets/plugins/jquery-ui/jquery-ui.min.css" media="all" rel="stylesheet" type="text/css" />

        <script>
            var base_url = "<?php echo base_url(); ?>";
            var nome_cliente = "<?php echo NOME_CLIENTE ?>";
            var title = "<?php echo $title ?>";

            var modulo = "<?php echo $this->router->fetch_module() ?>";
            var classe = "<?php echo $this->router->class ?>";
            var method = "<?php echo $this->router->method ?>";

            $(function() {
                $('#menu-navegacao ul.nav-stacked').each(function(indice, obj) {
                    if ($('li', obj).length == 0) {
                        $(obj).parent().remove();
                    }
                });
            });
        </script>
    </head>

    <body class="contrast-fb <?php echo $bPainelNav ? "" : "main-nav-closed" ?>">
        <div id="modal-confirm" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Confirmação</h3>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Não</a>
                        <a href="#" class="btn btn-primary">Sim</a>
                    </div>
                </div>
            </div>
        </div>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal-atention" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Atenção</h3>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</a>
                    </div>
                </div>
            </div>
        </div>

        <header>
            <nav class='navbar navbar-default'>
                <a class='navbar-brand' href='<?php echo base_url('painel'); ?>'>
                    <?php echo NOME_CLIENTE; ?>
                </a>
                <a class='toggle-nav btn pull-left' href='#'>
                    <i class='icon-reorder'></i>
                </a>
                <ul class='nav'>
                    <li class='dropdown dark user-menu'>
                        <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                            <span class='user-name'><?php echo $_vPainel['nome']; ?></span>
                            <b class='caret'></b>
                        </a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='<?php echo base_url(); ?>painel/usuario/meus_dados'>
                                    <i class='icon-user'></i>
                                    Meus Dados
                                </a>
                            </li>
                            <li class='divider'></li>
                            <li>
                                <a href='<?php echo base_url(); ?>painel/main/logout'>
                                    <i class='icon-signout'></i>
                                    Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <div id='wrapper'>
            <div id='main-nav-bg'></div>
            <nav id='main-nav'>
                <div class='navigation'>
                    <ul class='nav nav-stacked' id="menu-navegacao">
                        <li class="active"><a href="<?php echo base_url(); ?>painel"><i class="icon-home"></i> <span>Home</span></a></li>
                        <li>
                            <a class="dropdown-collapse" href="javascript:;" data-modulo="painel" data-class="grupo_usuario,usuario,configuracao,log,permissoes">
                                <i class="icon-wrench"></i>
                                <span>Administrar</span>
                                <i class='icon-angle-down angle-down'></i>
                            </a>
                            <ul class='nav nav-stacked'>
                                <?php
                                if (isset($vPainelPermissao['painel/grupo_usuario/index'])) {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>painel/grupo_usuario"><i class="icon-caret-right"></i> <span>Grupo de Usuários</span></a></li>
                                    <?php
                                }
                                if (isset($vPainelPermissao['painel/usuario/index'])) {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>painel/usuario"><i class="icon-caret-right"></i> <span>Usuários</span></a></li>
                                    <?php
                                }
                                if (isset($vPainelPermissao['painel/configuracao/index'])) {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>painel/configuracao"><i class="icon-caret-right"></i> <span>Configuração</span></a></li>
                                    <?php
                                }
                                if (isset($vPainelPermissao['painel/log/index'])) {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>painel/log"><i class="icon-caret-right"></i> <span>Log</span></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <section id='content'>
                <div class='container-fluid'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='page-header'>
                                        <h1 class='pull-left'>
                                            <span><?php echo $title; ?></span>
                                        </h1>
                                        <div class='pull-right'>
                                            <ul class="breadcrumb">
                                                <li><a href="<?php echo base_url(); ?>painel"><i class="fa fa-home"></i> Home</a></li>
                                                <li class='separator'>
                                                    <i class='icon-angle-right'></i>
                                                </li>
                                                <?php
                                                if (isset($migalha)) {
                                                    if (is_array($migalha)) {
                                                        foreach ($migalha as $linkMigalha => $nomeMigalha) {
                                                            ?>
                                                            <li><a href="<?php echo base_url() . $linkMigalha; ?>"><?php echo $nomeMigalha; ?></a></li>
                                                            <li class='separator'>
                                                                <i class='icon-angle-right'></i>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }

                                                if (isset($title)) {
                                                    ?>
                                                    <li class="active">
                                                        <?php echo $title; ?>
                                                    </li>
                                                    <?
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12'>
                                    <?php $this->sys_mensagem_model->exibirMensagem(); ?>
                                    <?php
                                    $sValidationError = validation_errors('<div>', '</div>');
                                    if (!empty($sValidationError)) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <button class="close" data-dismiss="alert" type="button">×</button>
                                            <?php echo $sValidationError; ?>
                                        </div>
                                        <?
                                    }
                                    ?>

                                    <?php $this->load->view($conteudo); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer id='footer'>
                        <div class='footer-wrapper'>
                            <div class='row'>
                                <div class='col-sm-12 text-center'>
                                    Copyright &copy; <?php echo date('Y'); ?> <?php echo NOME_CLIENTE; ?> - Todos os direitos reservados.
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </section>
        </div>


        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery-ui/jquery.ui.datepicker-pt-BR.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/maskedinput/jquery.maskedinput.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/maskmoney/jquery.maskMoney.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/validate/messages_pt_BR.js" type="text/javascript"></script>

        <link href="<?php echo base_url(); ?>resources/painel/assets/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/theme.js" type="text/javascript"></script>
    </body>
</html>
<!-- Localized -->