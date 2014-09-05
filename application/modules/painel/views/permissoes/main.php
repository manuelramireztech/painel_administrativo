<?php echo form_open('painel/permissoes/save', 'class="" id="form"'); ?>
<?php echo form_button(array("type" => "submit"), 'Salvar', 'class="btn btn-primary"'); ?>

<script>
    $(function() {
        $("#selecionar-todos").click(function() {
            var checked = $(this).prop('checked');

            $('input[type=checkbox]').each(function(indice, obj) {
                if (checked) {
                    $(obj).prop('checked', true);
                } else {
                    $(obj).removeAttr('checked');
                }
            });
        });

        $(".permissao").click(function() {
            var modulo = $(this).data('modulo');
            var classe = $(this).data('classe');
            var checked = $(this).prop('checked');
            var css = modulo;

            if (classe)
                css += "-" + classe;
            console.log(css);
            $('.' + css).each(function(indice, obj) {
                if (checked) {
                    $(obj).prop('checked', true);
                } else {
                    $(obj).removeAttr('checked');
                }
            });
        });

        var dl = $("dl:eq(0)");
        dl.find("dt a").click(function() {
            var $this = $(this);
            if ($this.find("i").hasClass("icon-caret-down")) {
                $this.find("i").removeClass("icon-caret-down");
                $this.find("i").addClass("icon-caret-up");
                $this.parents('dt:eq(0)').next().show();
            } else {
                $this.find("i").removeClass("icon-caret-up");
                $this.find("i").addClass("icon-caret-down");
                $this.parents('dt:eq(0)').next().hide();
            }
        });
    });
</script>
<style>
    .dl-horizontal dt {text-align: left;}
    .dl-horizontal dd {text-align: left;}
</style>

<input type="hidden" name="id_grupo_usuario" value="<?php echo $oGrupoUsuario->id; ?>" />
<br />
<br />
<input type="checkbox" value="1" id="selecionar-todos" /> Selecionar Todos (<?php echo $nPermissaoTotal ?> Permissões)

<dl style="margin-left: 30px;">
    <?php
    foreach ($vsModulo as $sModulo) {
        ?>
        <dt class="text-left">
        <input type="checkbox" value="<?php echo $sModulo; ?>" <?php echo $vnPermissaoModulo[$sModulo]['com'] == $vnPermissaoModulo[$sModulo]['total'] ? 'checked=""' : '' ?> data-modulo="<?php echo $sModulo ?>" class="permissao <?php echo $sModulo ?>" />
        <a href="javascript:;">
            <?php echo strtoupper($sModulo); ?> (<?php echo Util::decimalParaPagina(($vnPermissaoModulo[$sModulo]['com'] * 100) / $vnPermissaoModulo[$sModulo]['total']) ?>% - <?php echo $vnPermissaoModulo[$sModulo]['com'] ?>/<?php echo $vnPermissaoModulo[$sModulo]['total'] ?>)
            <i class="icon-caret-down"></i>
        </a>
        </dt>
        <dd class="text-left" style="display: none; margin-left: 70px;">
            <?php
            foreach ($vsClasses as $sClasse => $sArea) {
                if (isset($voMetodo[$sModulo][$sClasse])) {
                    ?>
                    <dl>
                        <dt class="text-left">
                        <strong>
                            <input type="checkbox" value="<?php echo $sModulo . "-" . $sClasse; ?>" <?php echo $vnPermissaoClasse[$sModulo][$sClasse]['com'] == $vnPermissaoClasse[$sModulo][$sClasse]['total'] ? 'checked=""' : '' ?> data-modulo="<?php echo $sModulo ?>" data-classe="<?php echo $sClasse ?>" class="permissao <?php echo $sModulo ?>" />
                            <a href="javascript:;">
                                <?php echo $sArea; ?>(<?php echo Util::decimalParaPagina(($vnPermissaoClasse[$sModulo][$sClasse]['com'] * 100) / $vnPermissaoClasse[$sModulo][$sClasse]['total']) ?>% - <?php echo $vnPermissaoClasse[$sModulo][$sClasse]['com'] ?>/<?php echo $vnPermissaoClasse[$sModulo][$sClasse]['total'] ?>)
                                <i class="fa icon-caret-down"></i>
                            </a>
                        </strong>
                        </dt>
                        <dd class="text-left" style="display: none; margin-left: 70px;">
                            <?php
                            foreach ($voMetodo[$sModulo][$sClasse] as $oMetodo) {
                                $bPermissao = (BOOL) $oMetodo->permissao;
                                if ($oMetodo->default)
                                    $bPermissao = TRUE;
                                ?>
                                <div>
                                    <?php echo form_checkbox('id_metodo[]', $oMetodo->id, (BOOL) $oMetodo->permissao, "class='{$sModulo} {$sModulo}-{$sClasse}'"); ?>
                                    <?php echo $oMetodo->apelido ?>
                                    <?php
                                    if ($oMetodo->default) {
                                        ?>
                                        <em>(Default)</em>
                                        <?
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </dd>
                    </dl>
                    <?php
                }
            }
            ?>
        </dd>
        <?
    }
    ?>
</dl>


<?php echo form_close(); ?>