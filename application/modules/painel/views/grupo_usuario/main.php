<?php
/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (isset($vPainelPermissao['painel/grupo_usuario/adicionar'])) {
    ?>
    <a class="btn btn-warning" href="<?php echo base_url(); ?>painel/grupo_usuario/adicionar"><i class="icon-plus-sign"></i> Adicionar</a>
    <?php
}
?>

<?php
if ($roGrupoUsuario->num_rows()) {
    ?>
    <table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>&ensp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($roGrupoUsuario->result() as $oGrupoUsuario) {
                ?>
                <tr>
                    <td><?php echo $oGrupoUsuario->nome ?></td>
                    <td class="opcoes">
                        <?php
                        if (isset($vPainelPermissao['painel/grupo_usuario/alterar'])) {
                            ?>
                            <a class="btn btn-primary" href="<?php echo base_url(); ?>painel/grupo_usuario/alterar/<?php echo $oGrupoUsuario->id; ?>"><i class="icon-edit"></i>  <span class="hidden-xs">Alterar</span></a>
                            <?php
                        }

                        if (isset($vPainelPermissao['painel/grupo_usuario/remover'])) {
                            ?>
                            <a class="btn btn-danger" href="javascript:;" onclick="confirmacao('Você tem certeza que deseja remover este item?', '<?php echo base_url(); ?>painel/grupo_usuario/remover/?id=<?php echo $oGrupoUsuario->id; ?>');"><i class="icon-trash"></i> <span class="hidden-xs">Excluir</span></a>
                            <?php
                        }

                        if (isset($vPainelPermissao['painel/permissoes/index'])) {
                            ?>
                            <a class="btn btn-warning" href="<?php echo base_url(); ?>painel/permissoes/index/<?php echo $oGrupoUsuario->id; ?>"><i class="icon-check"></i> <span class="hidden-xs">Permissão</span></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php echo $sPaginacao; ?>
    <?php
} else {
    ?>
    <div class="text-center text-info">Não há dados cadastrados no momento.</div>
    <?
}
?>