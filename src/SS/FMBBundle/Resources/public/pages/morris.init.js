/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Morris Chart
 */

!function ($) {
    "use strict";

    var MorrisCharts = function () {
    };

    //creates line chart
    MorrisCharts.prototype.createLineChart = function (element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
        Morris.Line({
            element: element,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            fillOpacity: opacity,
            pointFillColors: Pfillcolor,
            pointStrokeColors: Pstockcolor,
            behaveLikeLine: true,
            gridLineColor: '#eef0f2',
            hideHover: 'auto',
            resize: true, //defaulted to true
            lineColors: lineColors
        });
    },
        //creates area chart
        MorrisCharts.prototype.createAreaChart = function (element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
            Morris.Area({
                element: element,
                pointSize: 0,
                lineWidth: 0,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                resize: true,
                gridLineColor: '#eef0f2',
                lineColors: lineColors
            });
        },
        //creates area chart with dotted
        MorrisCharts.prototype.createAreaChartDotted = function (element, pointSize, lineWidth, data, xkey, ykeys, labels, Pfillcolor, Pstockcolor, lineColors) {
            Morris.Area({
                element: element,
                pointSize: 3,
                lineWidth: 1,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                pointFillColors: Pfillcolor,
                pointStrokeColors: Pstockcolor,
                resize: true,
                gridLineColor: '#eef0f2',
                lineColors: lineColors
            });
        },
        //creates Bar chart
        MorrisCharts.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
            Morris.Bar({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                resize: true, //defaulted to true
                gridLineColor: '#eeeeee',
                barColors: lineColors
            });
        },
        //creates Stacked chart
        MorrisCharts.prototype.createStackedChart = function (element, data, xkey, ykeys, labels, lineColors) {
            Morris.Bar({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                stacked: true,
                labels: labels,
                hideHover: 'auto',
                resize: true, //defaulted to true
                gridLineColor: '#eeeeee',
                barColors: lineColors
            });
        },
        //creates Donut chart
        MorrisCharts.prototype.createDonutChart = function (element, data, colors) {
            Morris.Donut({
                element: element,
                data: data,
                resize: true, //defaulted to true
                colors: colors
            });
        },
        MorrisCharts.prototype.init = function () {

            var nomProcess = [];
            var randomColor = [];
            $.each($(':hidden.processus'), function (index, value) {
                nomProcess.push($(value).val());
                randomColor.push('#' + Math.floor(Math.random() * 16777215).toString(16));
            });
            var qteProcess = [];
            $.each($(':hidden.processusqte'), function (index2, value2) {
                qteProcess.push($(value2).val());
            });
            var phase = [];
            $.each($(':hidden.phase'), function (index3, value3) {
                phase.push($(value3).val());
            });


            var $barData1 = [];
            var $barData2 = [];
            var $barData3 = [];
            var op = 0;
            var etape = '';
            $.each(phase, function (index4, value4) {
                if (etape == value4) {
                    switch (op) {
                        case 1:
                            $barData1.push({y: nomProcess[index4], a: qteProcess[index4]})
                            break;
                        case 2:
                            $barData2.push({y: nomProcess[index4], a: qteProcess[index4]})

                            break;
                        case 3:
                            $barData3.push({y: nomProcess[index4], a: qteProcess[index4]})
                            break;
                    }
                } else {
                    etape = value4;
                    op++;
                    switch (op) {
                        case 1:
                            $barData1.push({y: nomProcess[index4], a: qteProcess[index4]})
                            break;
                        case 2:
                            $barData2.push({y: nomProcess[index4], a: qteProcess[index4]})

                            break;
                        case 3:
                            $barData3.push({y: nomProcess[index4], a: qteProcess[index4]})
                            break;
                    }
                }
            });


            this.createBarChart('morris-bar-example1', $barData1, 'y', ['a'], ['Series A'], ['#5fbeaa']);
            this.createBarChart('morris-bar-example2', $barData2, 'y', ['a'], ['Series A'], ['#5fbeaa']);
            this.createBarChart('morris-bar-example3', $barData3, 'y', ['a'], ['Series A'], ['#5fbeaa']);
        },
        //init
        $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
}(window.jQuery),

//initializing 
    function ($) {
        "use strict";
        $.MorrisCharts.init();
    }(window.jQuery);