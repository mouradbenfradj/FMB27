/**
 * Theme: Ubold Admin
 * Author: Coderthemes
 * Chart Nvd3 page
 */

function createCourbe(result) {

    (function ($) {
        'use strict';

        function courbe(idParc) {

            var ret = [];
            var dayarticle = [];
            for (var day in result[idParc]) {
                for (var nomCycle in result[idParc][day]['cycle']) {
                    var somme = 0;
                    if (typeof dayarticle[nomCycle] === 'undefined') {
                        dayarticle[nomCycle] = [];
                    }
                    for (var refArticle in result[idParc][day]['cycle'][nomCycle]['article']) {
                        somme = somme + result[idParc][day]['cycle'][nomCycle]['article'][refArticle]['qteEau'];
                    }
                    dayarticle[nomCycle].push(
                        {
                            x: day,
                            y: somme
                        }
                    );
                }
            }
            for (var contenu in dayarticle) {
                ret.push(
                    {
                        values: dayarticle[contenu],
                        key: contenu,
                        color: '#' + (Math.random() * 0xFFFFFF << 0).toString(16)
                    }
                );
            }

            return ret;
        }

        nv.addGraph(function () {
            var lineChart = nv.models.lineChart();
            var height = 300;
            lineChart.useInteractiveGuideline(true);
            for (var value in result) {
                var taille = result[value].length;
                lineChart.forceX([0, 0, (taille-1)]);
                d3.select('.line-chart svg').attr('perserveAspectRatio', 'xMinYMid').datum(courbe(value)).transition().duration(500).call(lineChart);
            }
            nv.utils.windowResize(lineChart.update);
            return lineChart;
        });
    })
    (jQuery);
}
