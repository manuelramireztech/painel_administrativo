<?php
/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */
if (isset($vPainelPermissao['painel/usuario/adicionar'])) {
    ?>
    <a class="btn btn-warning" href="<?php echo base_url(); ?>painel/usuario/adicionar"><i class="icon-plus-sign"></i> Adicionar</a>
    <?php
}
?>

<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th class="hidden-xs hidden-sm">Grupo de Usuário</th>
            <th>Nome</th>
            <th>Login</th>
            <th class="hidden-xs">Ativo</th>
            <th class="hidden-xs hidden-sm">Data de cadastro</th>
            <th>&ensp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($roUsuario->result() as $oUsuario) {
            ?>
            <tr>
                <td class="hidden-xs hidden-sm"><?php echo $oUsuario->grupo_usuario ?></td>
                <td><?php echo $oUsuario->nome ?></td>
                <td><?php echo $oUsuario->login ?></td>
                <td class="hidden-xs"><?php echo ($oUsuario->ativo ? 'Sim' : 'N&atilde;o') ?></td>
                <td class="hidden-xs hidden-sm"><?php echo Util::converteDataParaPagina($oUsuario->data_cadastro) ?></td>
                <td class="opcoes">
                    <?php
                    if (isset($vPainelPermissao['painel/usuario/alterar'])) {
                        ?>
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>painel/usuario/alterar/<?php echo $oUsuario->id; ?>"><i class="icon-edit"></i>  <span class="hidden-xs">Alterar</span></a>
                        <?php
                    }

                    if (isset($vPainelPermissao['painel/usuario/remover'])) {
                        ?>
                        <a class="btn btn-danger" href="javascript:;" onclick="confirmacao('Você tem certeza que deseja remover este item?', '<?php echo base_url(); ?>painel/usuario/remover/?id=<?php echo $oUsuario->id; ?>');"><i class="icon-trash"></i> <span class="hidden-xs">Excluir</span></a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $sPaginacao; ?>