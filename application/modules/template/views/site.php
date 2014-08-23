<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <title>Site</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/stylesheets/bootstrap-responsive.min.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/stylesheets/bootstrap.min.css" type="text/css" media="screen" title="no title" />
        <!-- jQuery -->
        <script src="<?php echo base_url(); ?>resources/javascripts/jquery.min.js"></script>
    </head>

    <body>

        <?php
        $vMsgSite = $this->session->flashdata('site_msg');
        if (!empty($vMsgSite)) {
            ?>
                <div class="alert alert-<?php echo $vMsgSite['type'] ?>">
                    <?php echo $vMsgSite['msg']; ?>
                </div>
            <?
        }
        ?>
        <?php
            $sErrors = validation_errors('', '<br />');
            if (!empty($sErrors)) {
                ?>
                <div class="alert alert-danger">
                    <?php echo $sErrors; ?>
                </div>
                <?php
            }
        ?>

        <div id="content"><?php $this->load->view($conteudo); ?></div><!-- #content -->

        <div id="footer">
            Copyright &copy;
        </div>

        <script src="<?php echo base_url(); ?>resources/javascripts/all.js"></script>

    </body>
</html>