<?php 

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */

?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Permissão</title>

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
    </head>
  <body class='contrast-fb error contrast-background'>
    <div class='middle-container'>
      <div class='middle-row'>
        <div class='middle-wrapper'>
          <div class='error-container-header'>
            <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='text-center'>
                    <i class='icon-exclamation-sign'></i>
                     Ops!
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class='error-container'>
            <div class='container'>
              <div class='row'>
                <div class='col-sm-4 col-sm-offset-4'>
                  <h4 class='text-center title'>Você não tem permissão para acessar esta página!</h4>
                  <div class='text-center'>
                    <a class='btn btn-md btn-ablock' href='<?php echo base_url() ?>'>
                      <i class='icon-chevron-left'></i>
                      Voltar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class='error-container-footer'>
            <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='text-center'>
                    <?php echo NOME_CLIENTE ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery-ui/jquery.ui.datepicker-pt-BR.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>resources/painel/assets/javascripts/theme.js" type="text/javascript"></script>
    
    <!-- / END - page related files and scripts [optional] -->
  </body>
</html>

<!-- Localized -->