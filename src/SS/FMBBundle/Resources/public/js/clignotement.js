var signe = -1;
var clignotementFading = function(){
    var obj2 = document.getElementsByClassName('LblClignotant');
    var testDivs = Array.prototype.filter.call(obj2, function(obj){
        if (obj.style.opacity >= 0.96) {
            signe = -1;
        }
        if (obj.style.opacity <= 0.04) {
            signe = 1;
        }
        obj.style.opacity = (obj.style.opacity * 1) + (signe * 0.04);
    });
};


// mise en place de l appel de la fonction toutes les 0.085 secondes
// Pour arrêter le clignotement : clearInterval(periode);
periode = setInterval(clignotementFading, 33 );