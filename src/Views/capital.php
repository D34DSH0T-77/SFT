<?php require('src/Assets/layout/head.php') ?>

<!-- Add ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Capital</h2>
            </div>

            <!-- Stats Cards Overview -->
            <div class="row g-4 mb-4">
                <!-- Ingresos -->
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3 class="text-success">$<?= number_format($totalIngresosUsd, 2) ?></h3>
                            <p class="text-muted mb-0">Total Ingresos (Ventas)</p>
                            <small class="text-muted">Bs <?= number_format($totalIngresosBs, 2) ?></small>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">trending_up</span>
                        </div>
                    </div>
                </div>

                <!-- Egresos -->
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3 class="text-danger">$<?= number_format($totalEgresosUsd, 2) ?></h3>
                            <p class="text-muted mb-0">Total Egresos (Entradas)</p>
                            <small class="text-muted">Bs <?= number_format($totalEgresosBs, 2) ?></small>
                        </div>
                        <div class="stats-icon bg-pastel-orange">
                            <span class="material-symbols-sharp">trending_down</span>
                        </div>
                    </div>
                </div>

                <!-- Capital Neto -->
                <div class="col-md-4">
                    <div class="stats-card" style="border: 2px solid <?= $capitalNetoUsd >= 0 ? 'var(--pastel-mint)' : 'var(--pastel-red)' ?>;">
                        <div class="stats-info">
                            <h3 class="<?= $capitalNetoUsd >= 0 ? 'text-success' : 'text-danger' ?>">$<?= number_format($capitalNetoUsd, 2) ?></h3>
                            <p class="text-muted mb-0">Capital Neto (Ganancia)</p>
                            <small class="<?= $capitalNetoUsd >= 0 ? 'text-success' : 'text-danger' ?>">Bs <?= number_format($capitalNetoBs, 2) ?></small>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">account_balance_wallet</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="card card-custom mb-4">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <span id="chartTitle">Fluctuación de Capital (USD)</span>
                    <div class="btn-group" role="group" aria-label="Moneda">
                        <button type="button" class="btn btn-sm btn-primary active" id="btnUsd" onclick="toggleCurrency('USD')">USD</button>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnBs" onclick="toggleCurrency('BS')">BS</button>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div id="capitalChart" style="min-height: 400px;"></div>
                </div>
            </div>

        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>

    <script>
        var chart; // Global chart instance
        var chartDataUsd = <?= $chartData ?>;
        var chartDataBs = <?= $chartDataBs ?>;
        var currentCurrency = 'USD';

        document.addEventListener('DOMContentLoaded', function() {
            initChart(chartDataUsd, 'USD');
        });

        function toggleCurrency(currency) {
            if (currentCurrency === currency) return;
            currentCurrency = currency;

            if (currency === 'USD') {
                document.getElementById('btnUsd').classList.add('active', 'btn-primary');
                document.getElementById('btnUsd').classList.remove('btn-outline-primary');
                document.getElementById('btnBs').classList.remove('active', 'btn-primary');
                document.getElementById('btnBs').classList.add('btn-outline-primary');
                document.getElementById('chartTitle').innerText = 'Fluctuación de Capital (USD)';
                updateChart(chartDataUsd, 'USD');
            } else {
                document.getElementById('btnBs').classList.add('active', 'btn-primary');
                document.getElementById('btnBs').classList.remove('btn-outline-primary');
                document.getElementById('btnUsd').classList.remove('active', 'btn-primary');
                document.getElementById('btnUsd').classList.add('btn-outline-primary');
                document.getElementById('chartTitle').innerText = 'Fluctuación de Capital (BS)';
                updateChart(chartDataBs, 'BS');
            }
        }

        function initChart(data, currency) {
            var options = getChartOptions(data, currency);
            chart = new ApexCharts(document.querySelector("#capitalChart"), options);
            chart.render();
        }

        function updateChart(data, currency) {
            chart.updateOptions({
                title: {
                    text: 'Fluctuación de Capital (' + currency + ')'
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return (currency === 'USD' ? "$ " : "Bs ") + value.toFixed(2);
                        }
                    }
                }
            });
            chart.updateSeries([{
                data: data
            }]);
        }

        function getChartOptions(data, currency) {
            return {
                series: [{
                    name: 'Capital',
                    data: data
                }],
                chart: {
                    type: 'candlestick',
                    height: 400,
                    background: 'transparent',
                    toolbar: {
                        show: true
                    },
                    locales: [{
                        "name": "es",
                        "options": {
                            "months": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                            "shortMonths": ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            "days": ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                            "shortDays": ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                            "toolbar": {
                                "exportToSVG": "Descargar SVG",
                                "exportToPNG": "Descargar PNG",
                                "exportToCSV": "Descargar CSV",
                                "menu": "Menú",
                                "selection": "Selección",
                                "selectionZoom": "Zoom de Selección",
                                "zoomIn": "Acercar",
                                "zoomOut": "Alejar",
                                "pan": "Desplazamiento",
                                "reset": "Reiniciar Zoom"
                            }
                        }
                    }],
                    defaultLocale: 'es'
                },
                theme: {
                    mode: 'dark'
                },
                title: {
                    text: 'Fluctuación de Capital (' + currency + ')',
                    align: 'left',
                    style: {
                        color: '#fff'
                    }
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        style: {
                            colors: '#8c98a5'
                        }
                    }
                },
                yaxis: {
                    tooltip: {
                        enabled: true
                    },
                    labels: {
                        formatter: function(value) {
                            return (currency === 'USD' ? "$ " : "Bs ") + value.toFixed(2);
                        },
                        style: {
                            colors: '#8c98a5'
                        }
                    }
                },
                plotOptions: {
                    candlestick: {
                        colors: {
                            upward: '#00cc66',
                            downward: '#ff3333'
                        },
                        wick: {
                            useFillColor: true
                        }
                    }
                },
                tooltip: {
                    theme: 'dark',
                    custom: function({
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        var o = w.globals.seriesCandleO[seriesIndex][dataPointIndex];
                        var h = w.globals.seriesCandleH[seriesIndex][dataPointIndex];
                        var l = w.globals.seriesCandleL[seriesIndex][dataPointIndex];
                        var c = w.globals.seriesCandleC[seriesIndex][dataPointIndex];
                        var currSym = currentCurrency === 'USD' ? "$ " : "Bs ";

                        function f(val) {
                            return currSym + val.toFixed(2);
                        }

                        return (
                            '<div class="arrow_box" style="padding: 10px; background: #333; color: #fff; border: 1px solid #555; border-radius: 5px;">' +
                            '<div><strong>Apertura: </strong>' + f(o) + '</div>' +
                            '<div><strong>Máximo: </strong>' + f(h) + '</div>' +
                            '<div><strong>Mínimo: </strong>' + f(l) + '</div>' +
                            '<div><strong>Cierre: </strong>' + f(c) + '</div>' +
                            '</div>'
                        );
                    }
                }
            };
        }
    </script>
</body>

</html>