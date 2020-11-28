var tabFormulaire = [];
function validation() {
    if (parseInt($('#quantit').val()) < 0) {
        alert("vous avez demander de mettre un nombre superieur de assemblage que celle preparé");
        return false;
    } else {
        check = confirm('vous confirmer les données (date de retrait, article , lot que vous avez choisie');
        if (check == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

$(document).ready(function () {
    $('input:checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#quantit').val(parseInt($('#quantit').val()) - 1);
        } else {
            $('#quantit').val(parseInt($('#quantit').val()) + 1);
        }
    });


    $('#assemblagechoix').ready(function () {
        }
    ).change(function () {
            $("input:checkbox").each(function () {
                $(this).prop('checked', false);
            });
        }
    );
});
function chercherDatePreparer(assemblage) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parcDateCPreparer', {assemblage: assemblage}),
        beforeSend: function () {
            tabFormulaire = [];
            $('#dateAssemblageChoix').hide();
            $('#articlechoix').hide();
            $('#articlelotchoix').hide();
            $('#articlecyclechoix').hide();
            $('#quantierchoix').hide();
            $('input[type="submit"]').hide();
            $('loadquantit').show();
            $('#dateAssemblageChoix').empty();
            $('#articlechoix').empty();
            $('input[type="submit"]').hide();

            $('#quantit').val(0);
            $('#loadquantit').show();
            $('input:checkbox').hide();
            $('.cochage').hide();
        },
        success: function (data) {
            tabFormulaire = data;
            if (tabFormulaire.length != 0) {
                $.each(tabFormulaire, function (k, v) {
                    $('#dateAssemblageChoix').append('<option value="' + k + '">' + k + '</option>');
                });
            }
        },
        complete: function () {
            $('#dateAssemblageChoix').show();
            if (tabFormulaire.length != 0) {
                $('#dateAssemblageChoix').change(function () {
                    trouveArticle($('#dateAssemblageChoix option:selected').val());
                    $("input:checkbox").each(function () {
                        $(this).prop('checked', false);
                    });
                });

                trouveArticle($('#dateAssemblageChoix option:selected').val());
            } else {
                $('#quantit').val(0);
                $('#loadquantit').hide();
                $('input:checkbox').hide();
                $('.cochage').hide();
            }
        }
    });
}
function trouveArticle(date) {
    $('#articlechoix').empty();
    $.each(tabFormulaire[date], function (k, v) {
        $('#articlechoix').append('<option value="' + k + '">' + k + '</option>');
    });
    $('#articlechoix').show();
    $('#articlechoix').change(function () {
        afficheLot($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val());
        cycleArticle($('#articlechoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    cycleArticle($('#articlechoix').val());
    afficheLot($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val());
}
function afficheLot(datec, article) {
    $('#articlelotchoix').empty();
    $.each(tabFormulaire[datec][article], function (k, v) {
        $('#articlelotchoix').append('<option value="' + k + '">' + k + '</option>');
    });

    $('#articlelotchoix').show();
    $('#articlelotchoix').change(function () {
        affichageQte($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    affichageQte($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val());
}
function affichageQte(datec, article, lot) {
    $('#quantierchoix').empty();
    $.each(tabFormulaire[datec][article][lot], function (k, v) {
        $('#quantierchoix').append('<option value="' + k + '">' + k + '</option>');
    });
    $('#quantierchoix').change(function () {
        affichageNombreDispo($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val(), $('#quantierchoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    $('#quantierchoix').show();
    affichageNombreDispo($('#dateAssemblageChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val(), $('#quantierchoix').val());
}
function affichageNombreDispo(datec, article, lot, qte) {
    $('#quantit').val(tabFormulaire[datec][article][lot][qte]);
    $('#loadquantit').hide();
    $('input[type="submit"]').show();
    $('input:checkbox').show();
    $('.cochage').show();
}
function cycleArticle(article) {
    $.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_articlecyclechoix', {sarticle: article}),
        beforeSend: function () {
            $('#loadquantit').show();
        },
        success: function (data) {
            if ($.trim(data)) {
                $('#articlecyclechoix').show();
                $('#articlecyclechoix').html('');
                $.each(data, function (k, v) {
                    $('#articlecyclechoix').append('<option value="' + k + '">' + v + '</option>');
                });
            }
        },
        complete: function () {
            $('#loadquantit').hide();
        }
    });
}
function fillCheckbox(containerID, fill) {
    var checkbox = $('#' + containerID);
    var checkbox = checkbox.find('input[type="checkbox"]');
    checkbox.each(function () {
        switch (fill) {
            case '0':
                if (this.checked == true)
                    $('#quantit').val(parseInt($('#quantit').val()) + 1);
                this.checked = false;
                break;
            case '1':
                if (this.checked == false)
                    $('#quantit').val(parseInt($('#quantit').val()) - 1);
                this.checked = true;
                break;
            case 2:
                this.checked = !this.checked;
                break;
        }
    });
}


