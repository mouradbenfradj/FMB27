$(document).ready(function () {
    for (i = 0; i < 6; i++) {
        var somme = 0;
        $(".qte" + i).each(function () {
            somme += parseInt($(this).text());
        });
        $('#qteu' + i).text((Math.round(somme * 100) / 100 ) + ' u');
        $('#qtedz' + i).text((Math.round((somme / 12 ) * 100) / 100) + ' dz');
    }

    for (j = 0; j < 13; j++) {
        var somme2 = 0;
        $(".qtec" + j).each(function () {
            somme2 += parseInt($(this).text());
        });
        $('#qtecu' + j).text((Math.round(somme2 * 100) / 100 ) + ' u');
        $('#qtecdz' + j).text((Math.round((somme2 / 12) * 100) / 100) + ' dz');
    }

});
