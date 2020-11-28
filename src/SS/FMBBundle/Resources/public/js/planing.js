jQuery(document).ready(function () {
    //urg
    var somme = 0;
    $(".qteunilanturg").each(function () {
        somme += parseInt($(this).text());
    });
    $('#sommelanturg').text(somme + ' u');
    $('#sommelanturgdz').text(somme / 12 + ' dz');
    var somme2 = 0;
    $(".qteunicrdurg").each(function () {
        somme2 += parseInt($(this).text());
    });
    $('#sommecrdurg').text(somme2 + ' u');
    $('#sommecrdurgdz').text(somme2 / 12 + ' dz');
    var somme3 = 0;
    $(".qteunicrdurgaw").each(function () {
        somme3 += parseInt($(this).text());
    });
    $('#sommecrdurgaw').text(somme3 + ' u');
    $('#sommecrdurgdzaw').text(somme3 / 12 + ' dz');
    //af
    var sommeaf = 0;
    $(".qteunilantaf").each(function () {
        sommeaf += parseInt($(this).text());
    });
    $('#sommelantaf').text(sommeaf + ' u');
    $('#sommelantafdz').text(sommeaf / 12 + ' dz');
    var sommeaf2 = 0;
    $(".qteunicrdaf").each(function () {
        sommeaf2 += parseInt($(this).text());
    });
    $('#sommecrdaf').text(sommeaf2 + ' u');
    $('#sommecrdafdz').text(sommeaf2 / 12 + ' dz');
    var sommeaf3 = 0;
    $(".qteunicrdafaw").each(function () {
        sommeaf3 += parseInt($(this).text());
    });
    $('#sommecrdafaw').text(sommeaf3 + ' u');
    $('#sommecrdafdzaw').text(sommeaf3 / 12 + ' dz');
    //normal
    var sommen = 0;
    $(".qteunilant").each(function () {
        sommen += parseInt($(this).text());
    });
    $('#sommelant').text(sommen + ' u');
    $('#sommelantdz').text(sommen / 12 + ' dz');
    var sommen2 = 0;
    $(".qteunicrd").each(function () {
        sommen2 += parseInt($(this).text());
    });
    $('#sommecrd').text(sommen2 + ' u');
    $('#sommecrddz').text(sommen2 / 12 + ' dz');
    var sommen3 = 0;
    $(".qteunicrdaw").each(function () {
        sommen3 += parseInt($(this).text());
    });
    $('#sommecrdaw').text(sommen3 + ' u');
    $('#sommecrddzaw').text(sommen3 / 12 + ' dz');
});