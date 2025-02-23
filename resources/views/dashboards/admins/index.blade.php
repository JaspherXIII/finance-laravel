@extends('layouts.app')
@section('title', 'OSave | Dashboard')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-transparent card-block card-stretch card-height border-none">
                    <div class="card-body p-0 mt-lg-2 mt-0">
                        <h3 class="mb-3">Hi {{ Auth::user()->name }}, {{ $greeting }}! </h3>
                        <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business process.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-info-light">
                                        <img src="../assets/images/product/1.png" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Purchase Order</p>
                                        <h4 id="totalOrders">Loading...</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-info iq-progress progress-1" data-percent="85"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-danger-light">
                                        <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Products Ordered</p>
                                        <h4 id="totalProducts">Loading...</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-danger iq-progress progress-1" data-percent="70"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4 card-total-sale">
                                    <div class="icon iq-icon-box-2 bg-success-light">
                                        <img src="../assets/images/product/3.png" class="img-fluid" alt="image">
                                    </div>
                                    <div>
                                        <p class="mb-2">Total Amount</p>
                                        <h4 id="totalAmount">Loading...</h4>
                                    </div>
                                </div>
                                <div class="iq-progress-bar mt-2">
                                    <span class="bg-success iq-progress progress-1" data-percent="75"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Monthly Sales Orders</h4>
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
        document.addEventListener("DOMContentLoaded", function() {
            fetch("https://pos.pup-qc-retail.online/api/getTotalOrdersSummary")
                .then(response => response.json())
                .then(data => {
                    if (data && data.data) {
                        document.getElementById("totalOrders").innerText = data.data.total_orders;
                        document.getElementById("totalProducts").innerText = data.data.total_products;
                        document.getElementById("totalAmount").innerText = "Php " + parseFloat(data.data
                            .total_amount).toLocaleString();
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        });
    </script>


    <script>
        const predefinedColors = [
            'rgba(255, 99, 132, 0.7)', // Red
            'rgba(54, 162, 235, 0.7)', // Blue
            'rgba(255, 206, 86, 0.7)', // Yellow
            'rgba(75, 192, 192, 0.7)', // Teal
            'rgba(153, 102, 255, 0.7)', // Purple
            'rgba(255, 159, 64, 0.7)', // Orange
            'rgba(46, 204, 113, 0.7)', // Green
            'rgba(231, 76, 60, 0.7)', // Dark Red
            'rgba(52, 152, 219, 0.7)', // Light Blue
            'rgba(155, 89, 182, 0.7)' // Dark Purple
        ];

        const getConsistentColors = (count) => {
            return Array.from({
                length: count
            }, (_, i) => predefinedColors[i % predefinedColors.length]);
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
                const colors = getConsistentColors(data.labels.length);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Monthly Sales Orders (in PHP)',
                            data: data.data,
                            backgroundColor: colors,
                            borderColor: colors.map(color => color.replace('0.7', '1')),
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
