<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Content -->
        <div class="container-fluid">
            <!-- Top Cards -->
            <?php require('src/Assets/layout/dashboard/tarjetas.php') ?>

            <!-- Middle Section -->
            <div class="row g-4 mt-2">
                <!-- Left Vertical Card (Placeholder) -->


                <!-- Center Column -->
                <div class="col-md-9">
                    <!-- Top Row of Center -->
                    <div class="row g-4 mb-4">
                        <!-- Tortas más vendidas -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: 15px;">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Tortas más vendidas</h5>
                                    <div id="tortasChart" style="min-height: 150px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Top Compradores -->
                        <div class="col-md-6">
                            <div class="card h-100" style="border-radius: 15px; overflow: hidden;">
                                <div class="card-body p-0">
                                    <div class="row g-0 h-100">
                                        <!-- Left Side: Top Buyers List -->
                                        <div class="col-7 p-3 border-end border-secondary">
                                            <h5 class="card-title text-center mb-3" style="text-decoration: underline; font-size: 1rem;">Top compradores</h5>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($topCompradores as $index => $comprador): ?>
                                                    <li class="d-flex justify-content-between align-items-center mb-2">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="material-symbols-sharp" style="color: #FFD700; font-size: 1.2rem;">crown</span>
                                                            <small class="text-muted"><?= $index + 1 ?></small>
                                                        </div>
                                                        <span class="small fw-bold"><?= $comprador->nombre ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>

                                        <!-- Right Side: Creative Content (Cliente del Mes) -->
                                        <div class="col-5 p-3 d-flex flex-column align-items-center justify-content-center text-center bg-dark-subtle">
                                            <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Cliente del Mes</h6>
                                            <div class="position-relative mb-2">
                                                <span class="material-symbols-sharp text-warning" style="font-size: 3rem; filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));">emoji_events</span>
                                            </div>
                                            <div class="badge bg-gradient-primary text-white mb-1 px-3" style="font-size: 0.8rem;">VIP</div>
                                            <small class="text-white fw-bold">Juan P.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flujo del Capital -->
                    <div class="card card-custom mb-4 mt-4">
                        <div class="card-header-custom d-flex justify-content-between align-items-center">
                            <span id="chartTitle">Fluctuación de Capital (USD)</span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary active" id="btnUsd" onclick="toggleCurrency('USD')">USD</button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btnBs" onclick="toggleCurrency('BS')">BS</button>
                            </div>
                        </div>
                        <div class="card-body-custom">
                            <div id="capitalChart" style="min-height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Producto sin stock -->
                <div class="col-md-3 mt-4 mb-4">
                    <div class="card h-100" style="border-radius: 15px;">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Producto sin stock</h5>

                            <style>
                                .stock-card {
                                    transition: all 0.3s ease;
                                    cursor: default;
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                }

                                .stock-card:hover {
                                    transform: translateY(-2px);
                                    background-color: rgba(255, 255, 255, 0.05) !important;
                                    border-color: rgba(255, 255, 255, 0.2);
                                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                                }
                            </style>
                            <div class="d-flex flex-column gap-3">
                                <?php if (isset($productosBajoStock) && !empty($productosBajoStock)): ?>
                                    <?php foreach ($productosBajoStock as $prod): ?>
                                        <?php
                                        // Determine style based on stock level
                                        // Critical (0-1): Red
                                        // Warning (2-3): Yellow
                                        // Stable (>3): Green/Success

                                        $stock = $prod->total_stock;

                                        if ($stock <= 1) {
                                            $colorClass = 'text-danger';
                                            $bgClass = 'rgba(220, 53, 69, 0.1)';
                                            $borderClass = '#dc3545';
                                            $shadowColor = 'rgba(220, 53, 69, 0.3)';
                                            $iconName = 'warning'; // or 'report'
                                        } elseif ($stock <= 3) {
                                            $colorClass = 'text-warning';
                                            $bgClass = 'rgba(255, 193, 7, 0.1)';
                                            $borderClass = '#ffc107';
                                            $shadowColor = 'rgba(255, 193, 7, 0.3)';
                                            $iconName = 'warning';
                                        } else {
                                            // Stable / OK
                                            $colorClass = 'text-success';
                                            $bgClass = 'rgba(25, 135, 84, 0.1)';
                                            $borderClass = '#198754';
                                            $shadowColor = 'rgba(25, 135, 84, 0.3)';
                                            $iconName = 'check_circle';
                                        }
                                        ?>
                                        <div class="stock-card d-flex align-items-center bg-dark-subtle p-2 rounded-4 shadow-sm">
                                            <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                                <img src="<?= RUTA_BASE ?>src/Assets/img/icono.ico" alt="Torta" style="width: 35px; height: 35px; object-fit: contain;">
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-0 fw-semibold text-light" style="font-size: 0.95rem; letter-spacing: 0.5px;"><?= $prod->nombre ?></h6>
                                            </div>
                                            <div class="d-flex align-items-center gap-3 me-2">
                                                <div class="d-flex align-items-center justify-content-center <?= $colorClass ?>" style="width: 22px; height: 22px; border: 2px solid <?= $borderClass ?>; border-radius: 50%; background: <?= $bgClass ?>;">
                                                    <span class="fw-bold" style="font-size: 0.7rem;"><?= $stock ?></span>
                                                </div>
                                                <span class="material-symbols-sharp <?= $colorClass ?>" style="font-size: 1.6rem; text-shadow: 0 0 10px <?= $shadowColor ?>;"><?= $iconName ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center text-muted py-4">
                                        <span class="material-symbols-sharp mb-2" style="font-size: 2rem;">check_circle</span>
                                        <p class="mb-0 small">Todo el inventario está estable.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Facturas Completadas -->
            <div class="mt-4">
                <?php require('src/Assets/layout/dashboard/ordenes.php') ?>
            </div>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>

    <script>
        // --- Capital Chart Global Variables ---
        var chart; // Global chart instance
        var chartDataUsd = <?= $chartData ?>;
        var chartDataBs = <?= $chartDataBs ?>;
        var currentCurrency = 'USD';

        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. Tortas más vendidas (Pie Chart) ---
            var productosPro = <?= $productosMasVendidos ?>;
            var labels = productosPro.map(function(e) {
                return e.nombre;
            });
            var series = productosPro.map(function(e) {
                return parseInt(e.total_vendido); // Ensure numbers
            });

            var tortasOptions = {
                series: series,
                chart: {
                    type: 'pie',
                    height: 250,
                    background: 'transparent'
                },
                labels: labels,
                theme: {
                    mode: 'dark'
                },
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: false
                }
            };
            var tortasChart = new ApexCharts(document.querySelector("#tortasChart"), tortasOptions);
            tortasChart.render();


            // --- 2. Capital Chart Initialization ---
            initChart(chartDataUsd, 'USD');

        });

        // --- Capital Chart Functions ---

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