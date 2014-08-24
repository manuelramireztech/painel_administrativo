<?php 

/**
 * @author Romário Nascimento Beckman <romabeckman@gmail.com,romario@pa.senac.br>
 * @link https://www.linkedin.com/in/romabeckman
 * @link https://www.facebook.com/romabeckman
 * @link http://twitter.com/romabeckman
 */

?>
<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Nome</th>
            <th>Acesso</th>
            <th>IP</th>
            <th>Descrição</th>
            <th>Data cadastro</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($voLog as $oLog) {
            ?>
            <tr>
                <td><?php echo $oLog->usuario ?></td>
                <td><?php echo $oLog->nome ?></td>
                <td><?php echo $oLog->acesso ?></td>
                <td><?php echo $oLog->ip ?></td>
                <td><?php echo nl2br($oLog->descricao) ?></td>
                <td><?php echo Util::converteDataParaPagina($oLog->data_cadastro) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $paginacao; ?>