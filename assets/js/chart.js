const $ = require('jquery');
const Highcharts = require('highcharts/highstock');

var chart = Highcharts.chart('chart', {
    global: {
        useUTC: false,
    },
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'BTC to USD exchange rate'
    },

    xAxis: {
        type: 'datetime',
    },
    yAxis: {
        title: {
            text: 'Exchange rate'
        }
    },
    legend: {
        enabled: true
    },
    plotOptions: {
        area: {
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            marker: {
                radius: 2
            },
            lineWidth: 1,
            states: {
                hover: {
                    lineWidth: 1
                }
            },
            threshold: null
        },
        series: {
            showInNavigator: true,
        }
    },
    rangeSelector: {
        inputBoxWidth: 120,
        inputDateFormat: '%Y-%d-%m %H:%M',
        inputEditDateFormat: '%Y-%d-%m %H:%M',
        selected: 4,
        enabled: true,
        inputEnabled: true,
        verticalAlign: 'bottom',
        buttons: [{
            type: 'hour',
            count: 12,
            text: '12h'
        }, {
            type: 'day',
            count: 1,
            text: '1d'
        }, {
            type: 'week',
            count: 1,
            text: '1w'
        }, {
            type: 'month',
            count: 1,
            text: '1m'
        }, {
            type: 'year',
            count: 1,
            text: '1y'
        }, {
            type: 'all',
            text: 'All'
        }]
    },

});

$.getJSON(
    '/statistic?currencyCode=USD',
    function (data) {
        chart.addSeries({
            type: 'area',
            name: 'BTC to USD',
            mode: 'USD',
            data: data.map(function (el) {
                return [el.time * 1000, el.average];
            }),
        });
    }
);
$.getJSON(
    '/statistic?currencyCode=EUR',
    function (data) {
        chart.addSeries({
            type: 'area',
            name: 'BTC to EUR',
            mode: 'EUR',
            data: data.map(function (el) {
                return [el.time * 1000, el.average];
            })
        });
    }
);
