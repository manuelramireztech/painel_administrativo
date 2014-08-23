<?php echo form_open('painel/permissoes/save', 'class="" id="form"'); ?>
<?php echo form_button(array("type" => "submit"), '<i class="icon-save"></i> Salvar', 'class="btn btn-primary"'); ?>

<script>
    $(function() {
        $("#selecionar-todos").click(function() {
            var checked = $(this).prop('checked');

            $('.permissao').each(function(indice, obj) {
                if (checked) {
                    $(obj).prop('checked', true);
                } else {
                    $(obj).removeProp('checked');
                }
            });

            $('.selecionar-metodo').each(function(indice, obj) {
                if (checked) {
                    $(obj).prop('checked', true);
                } else {
                    $(obj).removeProp('checked');
                }
            });
        });

        $(".selecionar-metodo").click(function() {
            var checked = $(this).prop('checked');
            var apelido = $(this).val();

            $('.' + apelido).each(function(indice, obj) {
                if (checked) {
                    $(obj).prop('checked', true);
                } else {
                    $(obj).removeProp('checked');
                }
            });
        });

        if ($('.permissao:checked').length) {
            $('#selecionar-todos').prop('checked', true);
        }

        $('.selecionar-metodo').each(function(indice, obj) {
            var apelido = $(this).val();

            if ($('.' + apelido + ":checked").length) {
                $(obj).prop('checked', true);
            }
        });
    });
</script>

<input type="hidden" name="id_grupo_usuario" value="<?php echo $nIdGrupoUsuario; ?>" />
<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th style="width: 50px;" style="text-align: right;"><input type="checkbox" value="1" id="selecionar-todos" /></th>
            <th style="width: 250px;">Classe</th>
            <th>Metodo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sClasse = "";
        foreach ($voMetodo as $oMetodo) {
            if ($sClasse != $oMetodo->classe) {
                $sClasse = $oMetodo->classe;
                ?>
                <tr style="background-color: #EEE;">
                    <td style="text-align: left;"><input type="checkbox" value="<?php echo $oMetodo->modulo . "-" . $oMetodo->classe; ?>" class="selecionar-metodo" /></td>
                    <td><?php echo $oMetodo->area ?></td>
                    <td>&ensp;</td>
                </tr>
                <?
            }
            ?>
            <tr>
                <td style="text-align: right;"><?php echo form_checkbox('id_metodo[]', $oMetodo->id, (BOOL) $oMetodo->permissao, "class='permissao {$oMetodo->modulo}-{$oMetodo->classe}'"); ?></td>
                <td>&ensp;</td>
                <td><?php echo $oMetodo->apelido ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo form_close(); ?>