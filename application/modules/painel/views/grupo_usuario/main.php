<?php 

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */

?>
<a class="btn btn-warning" href="<?php echo base_url(); ?>painel/grupo_usuario/adicionar"><i class="icon-plus-sign"></i> Adicionar</a><hr />
<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>&ensp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($voGrupoUsuario as $oGrupoUsuario) {
            ?>
            <tr>
                <td><?php echo $oGrupoUsuario->nome ?></td>
                <td class="opcoes text-center">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>painel/grupo_usuario/alterar/<?php echo $oGrupoUsuario->id; ?>"><i class="icon-edit"></i> Alterar</a>
                    <a class="btn btn-danger" href="javascript:;" onclick="confirmacao('Você tem certeza que deseja remover este item?', '<?php echo base_url(); ?>painel/grupo_usuario/remover/?id=<?php echo $oGrupoUsuario->id; ?>');"><i class="icon-trash"></i> Excluir</a>
                    <br />
                    <a class="btn btn-warning" href="<?php echo base_url(); ?>painel/permissoes/index/<?php echo $oGrupoUsuario->id; ?>" style="margin-top: 3px; width: 124px;"><i class="icon-check"></i> Permissão</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $paginacao; ?>