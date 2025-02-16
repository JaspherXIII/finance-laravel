@extends('layouts.app')
@section('title', 'OSave | Dashboard')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-transparent card-block card-stretch card-height border-none">
                    <div class="card-body p-0 mt-lg-2 mt-0">
                        <h3 class="mb-3">Hi {{ Auth::user()->name }}, {{ $greeting }}! </h3>
                        <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business process.</p>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Monthly Sales Orders</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton001"
                                    data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none"
                                    aria-labelledby="dropdownMenuButton001">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlySalesChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Daily Completed Orders</h4>
                        </div>
                        <div class="card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle dropdown-bg btn" id="dropdownMenuButton001"
                                    data-toggle="dropdown">
                                    This Month<i class="ri-arrow-down-s-line ml-1"></i>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right shadow-none"
                                    aria-labelledby="dropdownMenuButton001">
                                    <a class="dropdown-item" href="#">Year</a>
                                    <a class="dropdown-item" href="#">Month</a>
                                    <a class="dropdown-item" href="#">Week</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyOrdersChart"></canvas>
                    </div>
                </div>
            </div>



        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const generateColors = (count) => {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
            }
            return colors;
        };

        fetch('https://pos.pup-qc-retail.online/api/dailyCompletedOrders')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('dailyOrdersChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Daily Completed Orders',
                            data: data.data,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Orders Count'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Days'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));

        fetch('https://pos.pup-qc-retail.online/api/getMonthlySalesOrders')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('monthlySalesChart').getContext('2d');
                const colors = generateColors(data.labels.length); // Generate colors dynamically

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels, // E.g., "2025 - January", "2025 - February"
                        datasets: [{
                            label: 'Monthly Sales Orders (in PHP)',
                            data: data.data, // Sales totals
                            backgroundColor: colors, // Vibrant bar colors
                            borderColor: colors.map(color => color.replace('0.7',
                            '1')), // Full-opacity borders
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Sales Totals (PHP)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Year - Month'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    </script>
@endsection
