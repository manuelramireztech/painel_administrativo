<script>
    $(function () {
        $(".ver-dados").click(function () {
            var text = $(this).parent().find('.descricao').html();
            $("#myModalDados .modal-body").html(text);
            $("#myModalDados").modal('show');
        });
    });
</script>

<a class="btn btn-info" data-toggle="modal" data-target="#modalFiltro" href="javascript:;"><i class="fa fa-search"></i> Filtrar</a>

<div class="modal fade" id="modalFiltro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('painel/log/index', 'class="form-horizontal" role="form" method="get"'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Filtro</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="ip" class="col-sm-4">IP: </label>
                    <div class="col-sm-8">
                        <?php echo form_input('ip', $this->input->get("ip", true), 'id="ip" class=" form-control "'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="acesso" class="col-sm-4">Ação: </label>
                    <div class="col-sm-8">
                        <?php echo form_input('acesso', $this->input->get("acesso", true), 'id="acesso" class=" form-control "'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao" class="col-sm-4">Dados: </label>
                    <div class="col-sm-8">
                        <?php echo form_input('descricao', $this->input->get("descricao", true), 'id="descricao" class=" form-control "'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="data" class="col-sm-4">Data da Atividade: </label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-xs-6"><?php echo form_input('data_inicio', $this->input->get("data_inicio", true), 'id="data_inicio" class="datapicker form-control "'); ?></div>
                            <div class="col-xs-6"><?php echo form_input('data_fim', $this->input->get("data_fim", true), 'id="data_fim" class="datapicker form-control "'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-info">Filtrar</button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<table cellspacing="0" cellpadding="0" class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Ação</th>
            <th>IP</th>
            <th>Data cadastro</th>
            <th>&ensp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($voLog as $oLog) {
            ?>
            <tr>
                <td><?php echo $oLog->usuario ?></td>
                <td><?php echo $oLog->acesso ?></td>
                <td><?php echo $oLog->ip ?><?php echo!empty($oLog->usuario_ip) ? "<br />({$oLog->usuario_ip})" : "" ?></td>
                <td><?php echo Util::converteDataParaPagina($oLog->data_cadastro) ?></td>
                <td class="opcoes">
                    <a class="btn btn-info ver-dados" href="javascript:;"><i class="fa fa-search-plus"></i><span class="hidden-sm hidden-xs"> Ver Dados</span></a>
                    <div style="display: none;" class="descricao">
                        <?php
                        $vDados = (ARRAY) unserialize($oLog->descricao);
                        if (isset($vDados['dados_sessao']['auth'])) {
                            $vDados['dados_sessao']['auth'] = ellipsize($vDados['dados_sessao']['auth'], 10, 0.5);
                        }
                        Util::printR($vDados);
                        ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php echo $paginacao; ?>

<!-- Modal -->
<div class="modal fade" id="myModalDados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Dados do Log</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>