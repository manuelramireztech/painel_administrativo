/* selects encadeadas */

/*
 * 
 * @exemple:
 * $('[name="uf"]').chain({target:'[name="id_cidade"]',data: 'sOP=chain-cidades',url: '/services/'});
 * 
 */

(function($) {
    $.fn.chain = function(opts) {
        var defaults = {
            url: undefined,
            action: undefined,
            data: {},
            target: undefined,
            dataType: 'json',
            type: 'POST',
            async: false
        };

        var op = $.extend(defaults, opts);

        if (!(op.target instanceof $))
            op.target = $(op.target);

        if (op.url === undefined || empty(op.url)) {
            $.error('URL não informada!');
        } else {
            return this.each(function() {
                var $$ = this;
                $.extend($$, {'chain': op});

                $($$).change(function() {
                    var data = null;
                    var $$ = this;
                    if ($$.chain != undefined || !empty($$.chain)) {
                        var op = $$.chain;

                        if (typeof op.data == 'string') {
                            data = op.data + '&' + this.name + '=' + $($$).val();
                        } else if (typeof op.data == 'object') {
                            data = op.data;
                            data[this.name] = $($$).val();
                        }
                        $.ajax({
                            url: op.url,
                            data: data,
                            dataType: op.dataType,
                            type: op.type,
                            async: op.async,
                            beforeSend: function() {
                                op.target.html('<option class="loading" value="">Carregando</option>');
                            },
                            success: function(result_opt) {
                                var output = [];
                                output.push('<option value="">Selecione</option>');
                                for (var i in result_opt)
                                    output.push('<option value="' + i + '">' + result_opt[i] + '</option>');
                                op.target.html(output.join(''));
                            }
                        });
                    }
                });
            });
        }
    };
})(jQuery);