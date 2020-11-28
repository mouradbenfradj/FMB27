$(document).ready(function () {
    $('.ladda-button').ladda('bind');
    Ladda.bind('.progress-demo .ladda-button', {
        callback: function (instance) {
            var progress = 0;
            var interval = setInterval(function () {
                progress = Math.min(progress + 0.1, document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value);
                instance.setProgress(progress);
                if (progress === document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value) {
                    instance.stop();
                    clearInterval(interval);
                }
            }, document.getElementById("ss_fmbbundle_preparationlanterne_nombre").value);
        }
    });
    var l = $('.ladda-button-demo').ladda();
    l.click(function () {
        l.ladda('start');
        setTimeout(function () {
            l.ladda('stop');
        }, 12000)
    });
    jQuery('#ss_fmbbundle_preparationlanterne_date').datepicker({language: 'fr'});
    var tabQte = [];
    var tablLotQte = [];
    jQuery('#ss_fmbbundle_preparationlanterne_Parc').ready(function () {
        jQuery('#ss_fmbbundle_preparationlanterne_libStock').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_qte').hide();
        jQuery('#totalqte').hide();
        jQuery('#divqteenstocks').hide();
        jQuery('#envoie').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').hide();
        stockContent(jQuery("#ss_fmbbundle_preparationlanterne_Parc").val());
        choixLanterne(jQuery("#ss_fmbbundle_preparationlanterne_Parc").val());
    }).change(function () {
        jQuery('#ss_fmbbundle_preparationlanterne_libStock').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_qte').hide();
        jQuery('#totalqte').hide();
        jQuery('#divqteenstocks').hide();
        jQuery('#envoie').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').hide();
        jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').hide();
        stockContent(jQuery("#ss_fmbbundle_preparationlanterne_Parc").val());
        choixLanterne(jQuery("#ss_fmbbundle_preparationlanterne_Parc").val());
        validation(jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationlanterne_qte').val(), $('#ss_fmbbundle_preparationlanterne_nombre').val());

    });
    jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').change(function () {
        afficheQuantiter(jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').val());
    });
    jQuery('#ss_fmbbundle_preparationlanterne_refArticle').change(function () {
        listeLotArticle(jQuery('#ss_fmbbundle_preparationlanterne_libStock').val(), jQuery('#ss_fmbbundle_preparationlanterne_refArticle').val());
    });
    jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').change(function () {
        afficheLotQTE(jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').val());
    });


});


function stockContent(parc) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parcstock', {parc_id: parc}),
        beforeSend: function () {
            jQuery('#loadlanterne').show();
            jQuery('#loadstock').show();
            jQuery('#loadlot').show();
            jQuery('#loadqte').show();
            jQuery('#envoie').hide();
            jQuery('#ss_fmbbundle_preparationlanterne_libStock').hide();
            jQuery('#ss_fmbbundle_preparationlanterne_libStock').html('');
        },
        success: function (data) {
            jQuery.each(data, function (k, v) {
                jQuery('#ss_fmbbundle_preparationlanterne_libStock').append('<option value="' + v + '">' + k + '</option>');
            });
        },
        complete: function () {
            jQuery('#loadlanterne').hide();
            jQuery('#loadstock').hide();
            jQuery('#loadlot').hide();
            jQuery('#loadqte').hide();
            jQuery('#ss_fmbbundle_preparationlanterne_libStock').show();
            listeLotArticle(jQuery('#ss_fmbbundle_preparationlanterne_libStock').val(), jQuery('#ss_fmbbundle_preparationlanterne_refArticle').val());
        }
    });
}


function choixLanterne(parc) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parclanterne', {parc_id: parc}),
        beforeSend: function () {
            jQuery('#loadlanterne').show();
            jQuery('#loadqtelstock').show();
            jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').html('');
            jQuery('#divqteenstocks').hide();
            jQuery('#envoie').hide();
            jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').hide();
            tabQte = [];
        },
        success: function (data) {
            jQuery.each(data, function (v, k) {
                jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').append('<option value="' + v + '">' + k.nomLanterne + '</option>');
                tabQte[v] = k.nombreEnStocks;
            });
            jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').show();
            jQuery('#divqteenstocks').show();
            jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').show();
        },
        complete: function () {
            jQuery('#loadlanterne').hide();
            jQuery('#loadqtelstock').hide();
            afficheQuantiter(jQuery('#ss_fmbbundle_preparationlanterne_nomLanterne').val());
        }
    });
}

function afficheQuantiter(idQte) {
    jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').val(tabQte[idQte]);
    validation(jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationlanterne_qte').val(), $('#ss_fmbbundle_preparationlanterne_nombre').val());


}

function listeLotArticle(stock, article) {
    jQuery('#ss_fmbbundle_preparationlanterne_refArticle').ready(function () {
        jQuery.ajax({
            type: "POST",
            url: Routing.generate('ssfmb_articlestock', {
                stock_id: stock,
                article: article
            }),
            beforeSend: function () {
                jQuery('#loadlot').show();
                jQuery('#loadqte').show();
                jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').hide();
                jQuery('#ss_fmbbundle_preparationlanterne_qte').hide();
                jQuery('#totalqte').hide();
                jQuery('#envoie').hide();
                jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').html('');
                tabLotQte = [];
            },
            success: function (data) {
                jQuery('#ss_fmbbundle_preparationlanterne_qte').val('0');
                jQuery.each(data, function (k, v) {
                    jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').append('<option value="' + k + '">' + k + '</option>');
                    tabLotQte[k] = v;
                });
            },
            complete: function () {
                jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').show();
                afficheLotQTE(jQuery('#ss_fmbbundle_preparationlanterne_numeroSerie').val());
                jQuery('#ss_fmbbundle_preparationlanterne_qte').show();
                jQuery('#totalqte').show();
                jQuery('#loadlot').hide();
                jQuery('#loadqte').hide();
            }
        });
    });
}

function validation(qteContainer, qteArticle, qteChoisie, nombreAF) {
    console.log(qteContainer + ' ' + qteArticle + ' ' + qteChoisie + ' ' + nombreAF);
    if ((parseInt(nombreAF) >= 1) && ((parseInt(nombreAF) * parseInt(qteChoisie)) <= parseInt(qteArticle)) && (parseInt(qteContainer) >= 1) && (parseInt(qteChoisie) >= 1) && (parseInt(nombreAF) <= parseInt(qteContainer))) {
        jQuery('#envoie').show();
    } else {
        jQuery('#envoie').hide();
    }
}

function afficheLotQTE(sn) {
    jQuery('#totalqte').val(tabLotQte[sn]);
    jQuery('#ss_fmbbundle_preparationlanterne_qte').show();
    validation(jQuery('#ss_fmbbundle_preparationlanterne_quantiterEnStock').val(), jQuery('#totalqte').val(), jQuery('#ss_fmbbundle_preparationlanterne_qte').val(), $('#ss_fmbbundle_preparationlanterne_nombre').val());
}