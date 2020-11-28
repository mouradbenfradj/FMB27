$('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
$(document).ready(function () {
    $('#blockPoche').hide();
    $("input[name='parc']").change(function () {
        choixCorde(this);
    });
    $("input[name='parcP']").change(function () {
        $('#blockPoche').show();

    });
    $('#valeurCorde').change(function () {
        quantiterCordeEnStock($(this).val());
        $('#affichageParcCorde').empty();
        $('#affichageParcCorde').text($('#valeurCorde option:selected').text())
    });
    $('input[name="nbrCordeAssemblage"]').blur(function () {
        $('#creation').empty();
        $('#creation').text(' Assemblage de ' + $('input[name="nbrCordeAssemblage"]').val())
    });
    $('input[name="dateAssemblage"]').blur(function () {
        $('#dateAss').empty();
        $('#dateAss').text(' le ' + $('input[name="dateAssemblage"]').val())
    });

});


function choixPoche(obj) {
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_parcPoch', {parc_id: obj})
        , beforeSend: function () {
            $('#valeurPoche0').empty();
            $('#valeurPoche1').empty();
            $('#valeurPoche2').empty();
            $('#nbrPoche').empty();
        }, success: function (data) {
            jQuery.each(data, function (k, v) {
                $('#valeurPoche0').append('<option value="' + k + '">' + v.poche + '</option>');
            });
        },
        complete: function () {
            if ($('#valeurPoche0').val() != null) {
                datepochePreparer($('#valeurPoche0').val());
            }
            $('#valeurPoche0').change(function () {
                datepochePreparer($('#valeurPoche0').val());
            });
        }
    });
}
function datepochePreparer(idPoche) {
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_datePochPreparer', {poche_id: idPoche})
        , beforeSend: function () {
            $('#valeurPoche1').empty();
            $('#valeurPoche2').empty();
            $('#nbrPoche').empty();
        }, success: function (data) {
            jQuery.each(data, function (k, v) {
                $('#valeurPoche1').append('<option value="' + k + '">' + v + '</option>');

            });
        }, complete: function () {
            $('#valeurPoche1').change(function () {
                pochePreparer($('#valeurPoche0').val(), $('#valeurPoche1').val());
            });
            pochePreparer($('#valeurPoche0').val(), $('#valeurPoche1').val());
        }
    });
}
function nombrePochePreparer(idPoche, qte) {
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_nombrePochPreparer', {poche_id: idPoche, qte: qte})
        , beforeSend: function () {
            $('#nbrPoche').empty();
        }, success: function (data) {
            $('#nbrPoche').text(data);
        }
    });
}

function pochePreparer(idPoche, date) {
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_PochPreparer', {poche_id: idPoche, date: date})
        , beforeSend: function () {
            $('#valeurPoche2').empty();
            $('#nbrPoche').empty();
        }, success: function (data) {
            jQuery.each(data, function (k, v) {
                $('#valeurPoche2').append('<option value="' + k + '">' + v + '</option>');
            });
        }, complete: function () {
            $('#valeurPoche2').change(function () {
                nombrePochePreparer($('#valeurPoche0').val(), $('#valeurPoche2').val());
            });
            nombrePochePreparer($('#valeurPoche0').val(), $('#valeurPoche2').val());

        }
    });
}
function choixCorde(obj) {
    choix = $(obj);
    $('#valeurCorde').empty();
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_parcCorde', {parc_id: choix.attr('value')})
        , beforeSend: function () {
            $('#nbrCorde').empty();
            $('#valeurCorde').empty();
        }, success: function (data) {
            jQuery.each(data, function (k, v) {
                $('#valeurCorde').append('<option value="' + k + '">' + v.nomCorde + '</option>');
            });
        },
        complete: function () {
            if ($('#valeurCorde').val() != null) {
                quantiterCordeEnStock($('#valeurCorde').val());
                $('#affichageParcCorde').empty();
                $('#affichageParcCorde').text($('#valeurCorde option:selected').text())
            }
        }
    });
}
function quantiterCordeEnStock(idCorde) {
    jQuery.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_quantiterCordeEnStock', {cordeId: idCorde}),
        beforeSend: function () {
            $('#nbrCorde').empty();
        },
        success: function (data) {
            $('#nbrCorde').empty();
            jQuery.each(data, function (k, v) {
                $('#nbrCorde').append(v);
            });
        }
    });
}