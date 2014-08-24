<a class="btn btn-warning" href="<?php echo base_url(); ?>painel/usuario/adicionar"><i class="icon-plus-sign"></i> Adicionar</a><hr />

<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th>Grupo usuário</th>
            <th>Nome</th>
            <th>Login</th>
            <th>Ativo</th>
            <th>Data cadastro</th>
            <th>&ensp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($voUsuario as $oUsuario) {
            ?>
            <tr>
                <td><?php echo $oUsuario->grupo_usuario ?></td>
                <td><?php echo $oUsuario->nome ?></td>
                <td><?php echo $oUsuario->login ?></td>
                <td><?php echo ($oUsuario->ativo ? 'Sim' : 'N&atilde;o') ?></td>
                <td><?php echo Util::converteDataParaPagina($oUsuario->data_cadastro) ?></td>
                <td class="opcoes">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>painel/usuario/alterar/<?php echo $oUsuario->id; ?>"><i class="icon-edit"></i> Alterar</a>
                    <a class="btn btn-danger" href="javascript:;" onclick="confirmacao('Você tem certeza que deseja excluir este item?', '<?php echo base_url(); ?>painel/usuario/remover/?id=<?php echo $oUsuario->id; ?>');"><i class="icon-trash"></i> Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $paginacao; ?>