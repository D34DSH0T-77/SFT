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
                                                <li class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="material-symbols-sharp" style="color: #FFD700; font-size: 1.2rem;">crown</span>
                                                        <small class="text-muted">1</small>
                                                    </div>
                                                    <span class="small fw-bold">Juan Pérez</span>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="material-symbols-sharp" style="color: #C0C0C0; font-size: 1.2rem;">crown</span>
                                                        <small class="text-muted">2</small>
                                                    </div>
                                                    <span class="small">Maria G.</span>
                                                </li>
                                                <li class="d-flex justify-content-between align-items-center mb-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="material-symbols-sharp" style="color: #CD7F32; font-size: 1.2rem;">crown</span>
                                                        <small class="text-muted">3</small>
                                                    </div>
                                                    <span class="small">Carlos R.</span>
                                                </li>
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

                <!-- Right Column: Producto sin stock -->
                <div class="col-md-3">
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
                                <!-- Item 1: Stock 3 (Yellow Warning) -->
                                <div class="stock-card d-flex align-items-center bg-dark-subtle p-2 rounded-4 shadow-sm">
                                    <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                        <img src="<?= RUTA_BASE ?>src/Assets/img/icono.ico" alt="Torta" style="width: 35px; height: 35px; object-fit: contain;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 fw-semibold text-light" style="font-size: 0.95rem; letter-spacing: 0.5px;">Cheesecake Fresa</h6>

                                    </div>
                                    <div class="d-flex align-items-center gap-3 me-2">
                                        <div class="d-flex align-items-center justify-content-center text-warning" style="width: 22px; height: 22px; border: 2px solid #ffc107; border-radius: 50%; background: rgba(255, 193, 7, 0.1);">
                                            <span class="fw-bold" style="font-size: 0.7rem;">3</span>
                                        </div>
                                        <span class="material-symbols-sharp text-warning" style="font-size: 1.6rem; text-shadow: 0 0 10px rgba(255, 193, 7, 0.3);">warning</span>
                                    </div>
                                </div>

                                <!-- Item 2: Stock 2 (Yellow Warning) -->
                                <div class="stock-card d-flex align-items-center bg-dark-subtle p-2 rounded-4 shadow-sm">
                                    <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                        <img src="<?= RUTA_BASE ?>src/Assets/img/icono.ico" alt="Torta" style="width: 35px; height: 35px; object-fit: contain;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 fw-semibold text-light" style="font-size: 0.95rem; letter-spacing: 0.5px;">Torta Chocolate</h6>

                                    </div>
                                    <div class="d-flex align-items-center gap-3 me-2">
                                        <div class="d-flex align-items-center justify-content-center text-warning" style="width: 22px; height: 22px; border: 2px solid #ffc107; border-radius: 50%; background: rgba(255, 193, 7, 0.1);">
                                            <span class="fw-bold" style="font-size: 0.7rem;">2</span>
                                        </div>
                                        <span class="material-symbols-sharp text-warning" style="font-size: 1.6rem; text-shadow: 0 0 10px rgba(255, 193, 7, 0.3);">warning</span>
                                    </div>
                                </div>

                                <!-- Item 3: Stock 1 (Red Critical) -->
                                <div class="stock-card d-flex align-items-center bg-dark-subtle p-2 rounded-4 shadow-sm">
                                    <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                        <img src="<?= RUTA_BASE ?>src/Assets/img/icono.ico" alt="Torta" style="width: 35px; height: 35px; object-fit: contain;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 fw-semibold text-light" style="font-size: 0.95rem; letter-spacing: 0.5px;">Red Velvet</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">Postre</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 me-2">
                                        <div class="d-flex align-items-center justify-content-center text-danger" style="width: 22px; height: 22px; border: 2px solid #dc3545; border-radius: 50%; background: rgba(220, 53, 69, 0.1);">
                                            <span class="fw-bold" style="font-size: 0.9rem;">1</span>
                                        </div>
                                        <span class="material-symbols-sharp text-danger" style="font-size: 1.6rem; text-shadow: 0 0 10px rgba(220, 53, 69, 0.3);">warning</span>
                                    </div>
                                </div>

                                <!-- Item 4: Stock 1 (Red Critical) -->
                                <div class="stock-card d-flex align-items-center bg-dark-subtle p-2 rounded-4 shadow-sm">
                                    <div class="bg-white rounded-3 d-flex align-items-center justify-content-center shadow-inner" style="width: 45px; height: 45px;">
                                        <img src="<?= RUTA_BASE ?>src/Assets/img/icono.ico" alt="Torta" style="width: 35px; height: 35px; object-fit: contain;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="mb-0 fw-semibold text-light" style="font-size: 0.95rem; letter-spacing: 0.5px;">Tres Leches</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">Postre</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 me-2">
                                        <div class="d-flex align-items-center justify-content-center text-danger" style="width: 22px; height: 22px; border: 2px solid #dc3545; border-radius: 50%; background: rgba(220, 53, 69, 0.1);">
                                            <span class="fw-bold" style="font-size: 0.9rem;">1</span>
                                        </div>
                                        <span class="material-symbols-sharp text-danger" style="font-size: 1.6rem; text-shadow: 0 0 10px rgba(220, 53, 69, 0.3);">warning</span>
                                    </div>
                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Tortas más vendidas (Pie Chart)
            var tortasOptions = {
                series: [44, 55, 13, 43, 22],
                chart: {
                    type: 'pie',
                    height: 250,
                    background: 'transparent'
                },
                labels: ['Chocolate', 'Fresa', 'Vainilla', 'Red Velvet', 'Limón'],
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

            // 2. Flujo del Capital (Line Chart)
            var capitalOptions = {
                series: [{
                    name: "Capital",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
                }],
                chart: {
                    height: 250,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    background: 'transparent',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    borderColor: '#444'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                    labels: {
                        style: {
                            colors: '#8c98a5'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#8c98a5'
                        }
                    }
                },
                theme: {
                    mode: 'dark'
                }
            };

            var chart; // Global chart instance
            // Real Data from Controller
            var chartDataUsd = <?= isset($chartData) ? $chartData : '[]' ?>;
            var chartDataBs = <?= isset($chartDataBs) ? $chartDataBs : '[]' ?>;
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
                    }
                };
            }

        });
    </script>
</body>

</html>