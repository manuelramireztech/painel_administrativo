<a class="btn btn-warning" href="<?php echo base_url(); ?>painel/pagina/adicionar"><i class="icon-plus-sign"></i> Adicionar</a><hr />

<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th>Pagina</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Url</th>
            <th>Ativo</th>
            <th>Data de cadastro</th>
            <th>&ensp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($voPagina as $oPagina) {
            ?>
            <tr>
                <td><?php echo $oPagina->pagina ?></td>
                <td><?php echo $oPagina->nome ?></td>
                <td><?php echo ucfirst($oPagina->tipo) ?></td>
                <td><?php echo $oPagina->url ?></td>
                <td><?php echo ($oPagina->ativo ? 'Sim' : 'N&atilde;o') ?></td>
                <td><?php echo Util::converteDataParaPagina($oPagina->data_cadastro) ?></td>
                <td class="opcoes">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>painel/pagina/alterar/<?php echo $oPagina->id; ?>"><i class="icon-edit"></i> Alterar</a>
                    <a class="btn btn-red" href="javascript:;" onclick="confirmacao('Você tem certeza que deseja remover este item?', '<?php echo base_url(); ?>painel/pagina/remover/?id=<?php echo $oPagina->id; ?>');"><i class="icon-trash"></i> Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $paginacao; ?>