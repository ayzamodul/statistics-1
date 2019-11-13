@extends('yonetim.layouts.master')
@section('title', 'Menü Yönetimi')
@section('content')

    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Başlangıç</h2>
        </div>
    </header>

    <section class="dashboard-header">
        <div class="container-fluid">
            <div class="row">


                <!-- Line Chart            -->
                <div class="chart col-lg-6 col-12">
                    <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <div id="user-types-charts" class="col-12"></div>

                    </div>
                </div>
                <div class="chart col-lg-6 col-12">
                    <!-- Bar Chart   -->
                    <div class="bar-chart has-shadow bg-white"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <div id="browser-statistics" class="col-12"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="chart  col-12" style="margin-top: 50px;">
                    <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <div id="site-statistics" class="col-12"></div>

                    </div>
                </div>
                <div class="chart  col-12" style="margin-top: 50px;">
                    <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <div id="site-local-statistics" class="col-12"  style="height: 400px"></div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script>
        var siteis_date     = [],
            siteis_visitor = [],
            siteis_views    = [],
            siteis_visitor_total = 0,
            siteis_views_total    = 0,
            siteis_citys          = [],
            siteis_citys_data     = [];
    </script>

    @foreach($analytics['site'] as $row)
        <script>
            siteis_date.push("{{$row['date']}}");
            siteis_visitor.push({{$row['visitors']}});
            siteis_views.push({{$row['pageViews']}});
            siteis_visitor_total        += parseInt('{{$row['visitors']}}');
            siteis_views_total        += parseInt('{{$row['pageViews']}}');
        </script>
    @endforeach

    <script>
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });

        // Create the chart
        Highcharts.chart('user-types-charts', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'En Etkin Yönlendirmeler'
            },

            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> defa<br/>',
            },

            "series": [
                {
                    "name": "Tarayıcı",
                    "colorByPoint": true,
                    "data": [
                            @foreach($analytics['top_referers'] as $row)
                        {
                            "name": "{{$row['url']}}",
                            "y": {{$row['pageViews']}}
                        },
                        @endforeach
                    ]
                }
            ],
        });

        // Build the chart
        Highcharts.chart('browser-statistics', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Tarayıcı İstatistiği'
            },

            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    connectorColor: 'silver',
                    dataLabels: {
                        enabled: false,

                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Tarayıcı',
                colorByPoint: true,
                data: [
                        @foreach($analytics['browser'] as $row)
                    {
                        name: "{{$row['browser']}}",
                        y: {{$row['sessions']}},
                        sliced: true,
                        selected: true
                    },
                    @endforeach

                ]
            }]
        });

        Highcharts.chart('site-statistics', {

            title: {

                text: 'Ziyaretçi İstatistiği'
            },
            xAxis: [{
                categories: siteis_date,
                crosshair: true
            }],
            yAxis: {
                title: {
                    text: ''
                }

            },
            labels: {
                items: [{
                    html: 'Genel Toplam',
                    style: {
                        left: '75px',
                        top: '18px',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'Ziyaretçi',
                color: {
                    linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
                    stops: [
                        [0, '#003399'],
                        [1, '#3366AA']
                    ]
                },
                data: siteis_visitor
            }, {
                type: 'column',
                name: 'Sayfa görüntülenmesi',
                data: siteis_views
            },{
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                },
                name: 'Toplam',
                data: [{
                    name: 'Ziyaretçi',
                    y: siteis_visitor_total,
                    color: Highcharts.getOptions().colors[0] // Jane's color
                },{
                    name: 'Sayfa görüntülenmesi',
                    y: siteis_views_total,
                    color: Highcharts.getOptions().colors[1] // Joe's color
                }],
                center: [100, 80],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });

        Highcharts.chart('site-local-statistics', {
            chart: {
                type: 'bar',
                marginLeft: 80
            },
            title: {
                text: 'Ziyaretçi Şehir İstatistiği',

            },
            xAxis: {
                type: 'category',
                title: {
                    text: null
                },

                min: 0,
                max : 7,
                scrollbar: {
                    enabled: true
                },
            },
            yAxis: {
                title: {
                    text: 'Görüntülenme',
                    align: 'high'
                },

                tickLength: 0
            },
            tooltip: {
                pointFormat: 'Görüntülenme : <b>{point.y}</b>'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Votes',
                data: [
                        @foreach($analytics['location']['rows'] as $row)
                    ["{{$row[0]}}", {{$row[1]}}],
                    @endforeach

                ]
            }]
        });

    </script>


@endsection
