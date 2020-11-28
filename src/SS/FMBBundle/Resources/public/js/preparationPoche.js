$(document).ready(function () {
    $('.ladda-button').ladda('bind');
    Ladda.bind('.progress-demo .ladda-button', {
        callback: function (instance) {
            var progress = 0;
            var interval = setInterval(function () {
                progress = Math.min(progress + 0.1, document.getElementById("ss_fmbbundle_preparationpoche_nombre").value);
                instance.setProgress(progress);
                if (progress === document.getElementById("ss_fmbbundle_preparationpoche_nombre").value) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, document.getElementById("ss_fmbbundle_preparationpoche_nombre").value);
        }
    });
    var l = $('.ladda-button-demo').ladda();
    l.click(function () {
        l.ladda('start');
        setTimeout(function () {
            l.ladda('stop');
        }, 12000)
    });
    jQuery('#ss_fmbbundle_preparationpoche_date').datepicker({language: 'fr'});
    var tabQte = [];
    var tablLotQte = [];
    jQuery('#ss_fmbbundle_preparationpoche_Parc').ready(function () {
        jQuery('#ss_fmbbundle_preparationpoche_libStock').hide();
        jQuery('#ss_fmbbundle_preparationpoche_nomPoche').hide();
        jQuery('#ss_fmbbundle_preparationpoche_qte').hide();
        jQuery('#totalqte').hide();
        jQuery('#divqteenstocks').hide();
        jQuery('#envoie').hide();
        jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').hide();
        jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').hide();
        stockContent(jQuery("#ss_fmbbundle_preparationpoche_Parc").val());
        choixPoche(jQuery("#ss_fmbbundle_preparationpoche_Parc").val());
    }).change(function () {
        jQuery('#ss_fmbbundle_preparationpoche_libStock').hide();
        jQuery('#ss_fmbbundle_preparationpoche_nomPoche').hide();
        jQuery('#ss_fmbbundle_preparationpoche_qte').hide();
        jQuery('#totalqte').hide();
        jQuery('#divqteenstocks').hide();
        jQuery('#envoie').hide();
        jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').hide();
        jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').hide();
        stockContent(jQuery("#ss_fmbbundle_preparationpoche_Parc").val());
        choixPoche(jQuery("#ss_fmbbundle_preparationpoche_Parc").val());
        validation(jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationpoche_qte').val(), $('#ss_fmbbundle_preparationpoche_nombre').val());
    });
    jQuery('#ss_fmbbundle_preparationpoche_nomPoche').change(function () {
        afficheQuantiter(jQuery('#ss_fmbbundle_preparationpoche_nomPoche').val());
    });
    jQuery('#ss_fmbbundle_preparationpoche_refArticle').change(function () {
        listeLotArticle(jQuery('#ss_fmbbundle_preparationpoche_libStock').val(), jQuery('#ss_fmbbundle_preparationpoche_refArticle').val());
    });
    jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').change(function () {
        afficheLotQTE(jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').val());
    });
});


function stockContent(parc) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parcstock', {parc_id: parc}),
        beforeSend: function () {
            jQuery('#loadpoche').show();
            jQuery('#loadstock').show();
            jQuery('#loadlot').show();
            jQuery('#loadqte').show();
            jQuery('#envoie').hide();
            jQuery('#ss_fmbbundle_preparationpoche_libStock').hide();
            jQuery('#ss_fmbbundle_preparationpoche_libStock').html('');
        },
        success: function (data) {
            jQuery.each(data, function (k, v) {
                jQuery('#ss_fmbbundle_preparationpoche_libStock').append('<option value="' + v + '">' + k + '</option>');
            });
        },
        complete: function () {
            jQuery('#loadpoche').hide();
            jQuery('#loadstock').hide();
            jQuery('#loadlot').hide();
            jQuery('#loadqte').hide();
            jQuery('#ss_fmbbundle_preparationpoche_libStock').show();
            listeLotArticle(jQuery('#ss_fmbbundle_preparationpoche_libStock').val(), jQuery('#ss_fmbbundle_preparationpoche_refArticle').val());
        }
    });
}


function choixPoche(parc) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parcpoche', {parc_id: parc}),
        beforeSend: function () {
            jQuery('#loadpoche').show();
            jQuery('#loadqtelstock').show();
            jQuery('#ss_fmbbundle_preparationpoche_nomPoche').html('');
            jQuery('#divqteenstocks').hide();
            jQuery('#envoie').hide();
            jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').hide();
            tabQte = [];
        },
        success: function (data) {
            jQuery.each(data, function (v, k) {
                jQuery('#ss_fmbbundle_preparationpoche_nomPoche').append('<option value="' + v + '">' + k.poche + '</option>');
                tabQte[v] = k.quantiter;
            });
            jQuery('#ss_fmbbundle_preparationpoche_nomPoche').show();
            jQuery('#divqteenstocks').show();
            jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').show();
        },
        complete: function () {
            jQuery('#loadpoche').hide();
            jQuery('#loadqtelstock').hide();
            afficheQuantiter(jQuery('#ss_fmbbundle_preparationpoche_nomPoche').val());
        }
    });
}

function afficheQuantiter(idQte) {
    jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').val(tabQte[idQte]);
    validation(jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationpoche_qte').val(), $('#ss_fmbbundle_preparationpoche_nombre').val());
}

function listeLotArticle(stock, article) {
    jQuery('#ss_fmbbundle_preparationpoche_refArticle').ready(function () {
        jQuery.ajax({
            type: "POST",
            url: Routing.generate('ssfmb_articlestock', {
                stock_id: stock,
                article: article
            }),
            beforeSend: function () {
                jQuery('#loadlot').show();
                jQuery('#loadqte').show();
                jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').hide();
                jQuery('#ss_fmbbundle_preparationpoche_qte').hide();
                jQuery('#totalqte').hide();
                jQuery('#envoie').hide();
                jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').html('');
                tabLotQte = [];
            },
            success: function (data) {
                jQuery('#ss_fmbbundle_preparationpoche_qte').val('0');
                jQuery.each(data, function (k, v) {
                    jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').append('<option value="' + k + '">' + k + '</option>');
                    tabLotQte[k] = v;
                });
            },
            complete: function () {
                jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').show();
                afficheLotQTE(jQuery('#ss_fmbbundle_preparationpoche_numeroSerie').val());
                jQuery('#ss_fmbbundle_preparationpoche_qte').show();
                jQuery('#totalqte').show();
                jQuery('#loadlot').hide();
                jQuery('#loadqte').hide();
            }
        });
    });
}

function validation(qteContainer, qteArticle, qteChoisie, nombreAF) {
    if ((parseInt(nombreAF) >= 1) && ((parseInt(nombreAF) * parseInt(qteChoisie)) <= parseInt(qteArticle)) && (parseInt(qteContainer) >= 1) && (parseInt(qteChoisie) >= 1) && (parseInt(nombreAF) <= parseInt(qteContainer))) {
        jQuery('#envoie').show();
    } else {
        jQuery('#envoie').hide();
    }
}

function afficheLotQTE(sn) {
    jQuery('#totalqte').val(tabLotQte[sn]);
    jQuery('#ss_fmbbundle_preparationpoche_qte').show();
    validation(jQuery('#ss_fmbbundle_preparationpoche_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationpoche_qte').val(), $('#ss_fmbbundle_preparationpoche_nombre').val());
}