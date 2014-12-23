/*
 * --------------------------------------------------------------------------------------------------------------------
 * main navigation toggling
 * --------------------------------------------------------------------------------------------------------------------
 */

var confirmacao = false;
var atencao = false;
var notify = false;

(function () {
    $(document).ready(function () {
        $("#menu-navegacao > li > a").each(function () {
            var vModulo = $(this).data("modulo");
            var vClass = $(this).data("class");
            var vMethod = $(this).data("method");
            var bActive= false;

            if (!empty(vModulo)) {
                vModulo = vModulo.split(",");
                if (!empty(vClass)) {
                    vClass = vClass.split(",");

                    if (!empty(vMethod)) {
                        if ($.inArray(modulo, vModulo) !== -1 && $.inArray(classe, vClass) !== -1 && $.inArray(method, vMethod) !== -1)
                            bActive = true;
                    } else {
                        if ($.inArray(modulo, vModulo) !== -1 && $.inArray(classe, vClass) !== -1)
                            bActive = true;
                    }
                }
            }

            if (bActive === true) {
                $(this).addClass('active');
                $(this).parent().find('ul.nav').addClass('in');
            }
        });
        
        var body, click_event, content, nav, nav_toggler;
        nav_toggler = $("header .toggle-nav");
        nav = $("#main-nav");
        content = $("#content");
        body = $("body");
        click_event = (jQuery.support.touch ? "tap" : "click");
        $("#main-nav .dropdown-collapse").on(click_event, function (e) {
            var link, list;
            e.preventDefault();
            link = $(this);
            list = link.parent().find("> ul");
            if (list.is(":visible")) {
                if (body.hasClass("main-nav-closed") && link.parents("li").length === 1) {
                    false;
                } else {
                    link.removeClass("in");
                    list.slideUp(300, function () {
                        return $(this).removeClass("in");
                    });
                }
            } else {
                if (list.parents("ul.nav.nav-stacked").length === 1) {
                    $(document).trigger("nav-open");
                }
                link.addClass("in");
                list.slideDown(300, function () {
                    return $(this).addClass("in");
                });
            }
            return false;
        });
        if (jQuery.support.touch) {
            nav.on("swiperight", function (e) {
                return $(document).trigger("nav-open");
            });
            nav.on("swipeleft", function (e) {
                return $(document).trigger("nav-close");
            });
        }
        nav_toggler.on(click_event, function () {
            if (nav_open()) {
                $(document).trigger("nav-close");
            } else {
                $(document).trigger("nav-open");
            }
            return false;
        });
        $(document).bind("nav-close", function (event, params) {
            var nav_open;
            body.removeClass("main-nav-opened").addClass("main-nav-closed");
            $.get(base_url + "painel/main/painel_nav/0");
            return nav_open = false;
        });
        return $(document).bind("nav-open", function (event, params) {
            var nav_open;
            body.addClass("main-nav-opened").removeClass("main-nav-closed");
            $.get(base_url + "painel/main/painel_nav/1");
            return nav_open = true;
        });
    });

    this.nav_open = function () {
        return $("body").hasClass("main-nav-opened") || $("#main-nav").width() > 50;
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * plugin initializations
     * --------------------------------------------------------------------------------------------------------------------
     */


    $(document).ready(function () {
        var touch;
        setTimeAgo();
        setScrollable();
        setSortable($(".sortable"));
        setSelect2();
        setAutoSize();
        setCharCounter();
        setMaxLength();
        setValidateForm();
        setMaskInput();
        setMaskMoney();
        setTinyMce();

        /*
         * --------------------------------------------------------------------------------------------------------------------
         * removes .box after click on .box-remove button
         * --------------------------------------------------------------------------------------------------------------------
         */

        $(".box .box-remove").on("click", function (e) {
            $(this).parents(".box").first().remove();
            e.preventDefault();
            return false;
        });
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * collapse .box after click on .box-collapse button
         * --------------------------------------------------------------------------------------------------------------------
         */

        $(".box .box-collapse").on("click", function (e) {
            var box;
            box = $(this).parents(".box").first();
            box.toggleClass("box-collapsed");
            e.preventDefault();
            return false;
        });
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * password strength
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().pwstrength) {
            $('.pwstrength').pwstrength({
                showVerdicts: false
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * check all checkboxes in table with class only-checkbox
         * --------------------------------------------------------------------------------------------------------------------
         */

        $(".check-all").on("click", function (e) {
            return $(this).parents("table:eq(0)").find(".only-checkbox :checkbox").attr("checked", this.checked);
        });
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up responsive tabs
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().tabdrop) {
            $('.nav-responsive.nav-pills, .nav-responsive.nav-tabs').tabdrop();
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up datatables
         * --------------------------------------------------------------------------------------------------------------------
         */

        setDataTable($(".data-table"));
        setDataTable($(".data-table-column-filter"));
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up basic wysiwyg
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().wysihtml5) {
            $('.wysihtml5').wysihtml5();
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up sortable list
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().nestable) {
            $('.dd-nestable').nestable();
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * affixing main navigation
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (!$("body").hasClass("fixed-header")) {
            if (jQuery().affix) {
                $('#main-nav.main-nav-fixed').affix({
                    offset: 40
                });
            }
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up bootstrap popovers
         * --------------------------------------------------------------------------------------------------------------------
         */

        touch = false;
        if (window.Modernizr) {
            touch = Modernizr.touch;
        }
        if (!touch) {
            $("body").on("mouseenter", ".has-popover", function () {
                var el;
                el = $(this);
                if (el.data("popover") === undefined) {
                    el.popover({
                        placement: el.data("placement") || "top",
                        container: "body"
                    });
                }
                return el.popover("show");
            });
            $("body").on("mouseleave", ".has-popover", function () {
                return $(this).popover("hide");
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting up bootstrap tooltips
         * --------------------------------------------------------------------------------------------------------------------
         */

        touch = false;
        if (window.Modernizr) {
            touch = Modernizr.touch;
        }
        if (!touch) {
            $("body").on("mouseenter", ".has-tooltip", function () {
                var el;
                el = $(this);
                if (el.data("tooltip") === undefined) {
                    el.tooltip({
                        placement: el.data("placement") || "top",
                        container: "body"
                    });
                }
                return el.tooltip("show");
            });
            $("body").on("mouseleave", ".has-tooltip", function () {
                return $(this).tooltip("hide");
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * replacing svg images for png fallback
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (window.Modernizr && Modernizr.svg === false) {
            $("img[src*=\"svg\"]").attr("src", function () {
                return $(this).attr("src").replace(".svg", ".png");
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * color pickers
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().colorpicker) {
            $(".colorpicker-hex").colorpicker({
                format: "hex"
            });
            $(".colorpicker-rgb").colorpicker({
                format: "rgb"
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * datetimepickers
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().datepicker) {
            $(".datepicker").datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                icons: {
                    time: "icon-time",
                    date: "icon-calendar",
                    up: "icon-arrow-up",
                    down: "icon-arrow-down"
                }
            });

            $(".data-range-start").datepicker({
                onClose: function (selectedDate) {
                    var target = $(this).data('target');
                    $(target).datepicker("option", "minDate", selectedDate);
                }
            });
            $(".data-range-end").datepicker({
                onClose: function (selectedDate) {
                    var target = $(this).data('target');
                    $(target).datepicker("option", "maxDate", selectedDate);
                }
            });
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * setting bootstrap file input
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (jQuery().bootstrapFileInput) {
            $('input[type=file]').bootstrapFileInput();
        }
        /*
         * --------------------------------------------------------------------------------------------------------------------
         * modernizr fallbacks
         * --------------------------------------------------------------------------------------------------------------------
         */

        if (window.Modernizr) {
            if (!Modernizr.input.placeholder) {
                $("[placeholder]").focus(function () {
                    var input;
                    input = $(this);
                    if (input.val() === input.attr("placeholder")) {
                        input.val("");
                        return input.removeClass("placeholder");
                    }
                }).blur(function () {
                    var input;
                    input = $(this);
                    if (input.val() === "" || input.val() === input.attr("placeholder")) {
                        input.addClass("placeholder");
                        return input.val(input.attr("placeholder"));
                    }
                }).blur();
                return $("[placeholder]").parents("form").submit(function () {
                    return $(this).find("[placeholder]").each(function () {
                        var input;
                        input = $(this);
                        if (input.val() === input.attr("placeholder")) {
                            return input.val("");
                        }
                    });
                });
            }
        }

        confirmacao = function (text, redirect) {
            $('#modal-confirm .modal-body').html("<p>" + text + "</p>");
            $('#modal-confirm .modal-footer a.btn:eq(1)').attr('href', redirect);
            $('#modal-confirm').modal('show');
        };

        atencao = function (text) {
            $('#modal-atention .modal-title').html("Atenção");
            $('#modal-atention .modal-body').html("<p>" + text + "</p>");
            $('#modal-atention').modal('show');
        };

        alerta = function (title, text) {
            $('#modal-atention .modal-title').html(title);
            $('#modal-atention .modal-body').html("<p>" + text + "</p>");
            $('#modal-atention').modal('show');
        };
    });

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * max length counter
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setMaxLength = function (selector) {
        if (selector == null) {
            selector = $(".char-max-length");
        }
        if (jQuery().maxlength) {
            return selector.maxlength();
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * character counter
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setCharCounter = function (selector) {
        if (selector == null) {
            selector = $(".char-counter");
        }
        if (jQuery().charCount) {
            return selector.charCount({
                allowed: selector.data("char-allowed"),
                warning: selector.data("char-warning"),
                cssWarning: "text-warning",
                cssExceeded: "text-error"
            });
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * autosize feature for expanding textarea elements
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setAutoSize = function (selector) {
        if (selector == null) {
            selector = $(".autosize");
        }
        if (jQuery().autosize) {
            return selector.autosize();
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * timeago feature converts static time to dynamically refreshed
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setTimeAgo = function (selector) {
        if (selector == null) {
            selector = $(".timeago");
        }
        if (jQuery().timeago) {
            jQuery.timeago.settings.allowFuture = true;
            jQuery.timeago.settings.refreshMillis = 60000;
            selector.timeago();
            return selector.addClass("in");
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * scrollable boxes
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setScrollable = function (selector) {
        if (selector == null) {
            selector = $(".scrollable");
        }
        if (jQuery().slimScroll) {
            return selector.each(function (i, elem) {
                return $(elem).slimScroll({
                    height: $(elem).data("scrollable-height"),
                    start: $(elem).data("scrollable-start") || "top"
                });
            });
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * jquery ui sortable
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setSortable = function (selector) {
        if (selector == null) {
            selector = null;
        }
        if (jQuery().sortable) {
            if (selector) {
                return selector.sortable({
                    axis: selector.data("sortable-axis"),
                    connectWith: selector.data("sortable-connect")
                });
            }
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * select 2 selects
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setSelect2 = function (selector) {
        if (jQuery().select2) {
            $("select").not("[multiple]").not(".no-select2").select2();
        }
    };

    /*
     * --------------------------------------------------------------------------------------------------------------------
     * datatables
     * --------------------------------------------------------------------------------------------------------------------
     */


    this.setDataTable = function (selector) {
        if (jQuery().dataTable) {
            return selector.each(function (i, elem) {
                var dt, sdom;
                if ($(elem).data("pagination-top-bottom") === true) {
                    sdom = "<'row datatables-top'<'col-sm-6'l><'col-sm-6 text-right'pf>r>t<'row datatables-bottom'<'col-sm-6'i><'col-sm-6 text-right'p>>";
                } else if ($(elem).data("pagination-top") === true) {
                    sdom = "<'row datatables-top'<'col-sm-6'l><'col-sm-6 text-right'pf>r>t<'row datatables-bottom'<'col-sm-6'i><'col-sm-6 text-right'>>";
                } else {
                    sdom = "<'row datatables-top'<'col-sm-6'l><'col-sm-6 text-right'f>r>t<'row datatables-bottom'<'col-sm-6'i><'col-sm-6 text-right'p>>";
                }
                dt = $(elem).dataTable({
                    sDom: sdom,
                    sPaginationType: "bootstrap",
                    "iDisplayLength": $(elem).data("pagination-records") || 10,
                    oLanguage: {
                        sLengthMenu: "_MENU_ records per page"
                    },
                    fnDrawCallback: function (oSettings) {
                        $(this).closest('.dataTables_wrapper').find('div[id$=_filter] input').css("width", "200px");
                        return $(this).closest('.dataTables_wrapper').find('div[id$=_filter] input').addClass("form-control input-sm").attr('placeholder', $(this).closest('.dataTables_wrapper').find('div[id$=_filter] label').text().replace(":", "..."));
                    }
                });
                if ($(elem).hasClass("data-table-column-filter")) {
                    return dt.columnFilter();
                }
            });
        }
    };

    this.setMaskMoney = function () {
        if (jQuery().maskMoney) {
            $(".decimal").maskMoney({
                symbol: "R$",
                decimal: ",",
                thousands: "."
            });

            $(".float").maskMoney({
                symbol: "",
                decimal: ",",
                thousands: "."
            });
        }
    };

    this.setMaskInput = function () {
        if (jQuery().mask) {
            $(".datepicker").mask("99/99/9999");
            $(".data").mask("99/99/9999");
            $(".time").mask("99:99");
            $(".cep").mask("99999-999");
            $(".cpf").mask("999.999.999-99");
            $(".cnpj").mask("99.999.999/9999-99");
            $(".telefone").mask("(99)99999999?9");
        }
    };

    this.setTinyMce = function () {
        if (jQuery().tinymce) {
            if ($('textarea.tinymce-fullpage').length > 0) {
                $('textarea.tinymce-fullpage').tinymce({
                    language: 'pt',
                    // Location of TinyMCE script
                    script_url: base_url + 'resources/painel/assets/javascripts/plugins/tiny_mce/tiny_mce.js',
                    // General options
                    width: "100%",
                    height: "500px",
                    theme: "advanced",
                    plugins: "fullpage,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,imagemanager",
                    convert_urls: false,
                    // Theme options
                    theme_advanced_buttons1: "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,insertimage,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4: "",
                    theme_advanced_toolbar_location: "top",
                    theme_advanced_toolbar_align: "left",
                    theme_advanced_statusbar_location: "bottom",
                    theme_advanced_resizing: true,
                    element_format: "html",
                    toolbar: "fullpage"
                });
            }

            if ($('textarea.tinymce').length > 0) {
                $('textarea.tinymce').tinymce({
                    language: 'pt',
                    // Location of TinyMCE script
                    script_url: base_url + 'resources/painel/assets/javascripts/plugins/tiny_mce/tiny_mce.js',
                    // General options
                    width: "100%",
                    height: "500px",
                    theme: "advanced",
                    plugins: "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,imagemanager",
                    convert_urls: false,
                    // Theme options
                    theme_advanced_buttons1: "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,insertimage,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4: "",
                    theme_advanced_toolbar_location: "top",
                    theme_advanced_toolbar_align: "left",
                    theme_advanced_statusbar_location: "bottom",
                    theme_advanced_resizing: true,
                    element_format: "html"
                });
            }
        }
    };

    this.setValidateForm = function (selector) {
        if (selector == null) {
            selector = $(".form-validate");
        }

        if (jQuery().validate) {
            return selector.each(function (i, elem) {
                var $form = $(this);

                if ($form.length) {
                    if ($form.find("div.errors").length == 0)
                        $form.prepend($("<div>").addClass("errors alert alert-danger text-center").html("Por favor verifique o(s) campo(s) em destaque abaixo:").hide());

                    var api = $form.validate({
                        errorContainer: "div.errors",
                        invalidHandler: function () {
                            var errors = api.numberOfInvalids();
                            if (errors > 0)
                                $("div.errors", api).html("Por favor informe corretamente " + (errors == 1 ? "o campo" : "os " + errors + " campos") + " abaixo:").show();
                            else
                                $("div.errors", api).hide();
                        },
                        errorPlacement: function (error, element) {
                            var errors = api.numberOfInvalids();
                            if (errors > 0)
                                $("div.errors", $form).html("Por favor informe corretamente " + (errors == 1 ? "o campo" : "os " + errors + " campos") + " abaixo:").show();
                            else
                                $("div.errors", api).hide();
                        },
                        highlight: function (element, errorClass) {
                            var label = $(element).parents(".form-group:eq(0)").find("label");
                            $(element).parent().removeClass('has-success').addClass('has-error');
                            label.css({
                                "color": "#FF0000"
                            });
                        },
                        unhighlight: function (element, errorClass) {
                            var label = $(element).parents(".form-group:eq(0)").find("label");

                            $(element).parent().removeClass('has-error').addClass('has-success');
                            $(element).parents(".form-group:eq(0)").find("label").css({
                                "color": "#FF0000"
                            });
                            if (label.css("color") == 'rgb(255, 0, 0)') {
                                label.css("color", "#00AA00");
                            }
                        },
                        success: function () {
                            $("div.errors", api).hide();
                        }
                    });
                }
            });
        }
    };

}).call(this);

/*IS EMPTY?*/
function empty(mixed_var) {
    var key;
    if (mixed_var === '' || mixed_var === 0 || mixed_var === '0' || mixed_var === null || mixed_var === false || typeof mixed_var === 'undefined' || mixed_var === '0,00' || mixed_var === '0,000' || mixed_var === '0,0000' || mixed_var === '0,00000')
        return true;
    if (typeof mixed_var == 'object') {
        for (key in mixed_var)
            return false;
        return true;
    }
    return false;
}