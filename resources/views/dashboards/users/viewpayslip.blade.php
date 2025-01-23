@extends('layouts.app')
@section('title', 'OSave | Payslip')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between">
                    <div>
                        <h4 class="">Payslip</h4>
                    </div>
                    <button type="button" class="btn btn-primary" id="printPayslip"><i class="las la-print mr-3"></i>Print
                        Payslip</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="ttl-amt py-2 px-3 d-flex justify-content-end mt-2"></div>
            </div>
            <div class="col-lg-12" id="printableArea">
                <div class="text-dark">
                    <h6 class="text-center" style="text-transform: uppercase;"><u> FOR THE MONTH OF <span
                                id="currentMonthYear">{{ \Carbon\Carbon::parse($emppayroll->created_at)->format('F Y') }}</span></u>
                    </h6>

                    <div class="text-right">
                        <h4>PAYSLIP #{{ $emppayroll->id }}</h4>
                        <p>Salary Month : <span
                                id="salaryMonthYear">{{ \Carbon\Carbon::parse($emppayroll->created_at)->format('F Y') }}</span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <img src="/logistic-assets/images/logo2.png" class="img-fluid2 rounded-normal light-logo"
                                alt="logo">
                            <ul class="list-unstyled mt-2">
                                <li>O!Save Trading Philippines Corporation</li>
                                <li>Block No. 8, 888 Industrial Megacity</li>
                                <li>Sta. Ana, Taytay, Rizal, Taytay, Philippines, 1920</li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><strong><span>{{ $emppayroll->employee->name }}</span></strong></li>
                                <li><span>{{ $emppayroll->employee->job->title }}</span></li>
                                <li><span>{{ $emppayroll->employee->department->title }}</span></li>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h8 class="ml-3"><strong>Earnings</strong></h8>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Basic Salary</strong>
                                                        <span
                                                            class="float-right">₱{{ number_format($emppayroll->employee->monthly_salary, 2) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gross Salary</strong>
                                                        <span class="float-right"><strong>₱{{ number_format($emppayroll->gross_salary, 2) }}</strong></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div>
                                        <h8 class="ml-3"><strong>Deductions</strong></h8>
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach ($emppayroll->employee->empdeductions as $empdeduction)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $empdeduction->deduction->name }}</strong>
                                                            <span
                                                                class="float-right"> ₱{{ number_format(($empdeduction->deduction->amount / 100) * $emppayroll->gross_salary, 2) }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-sm-12 ml-3">
                                    <p><strong>Net Salary: ₱{{ number_format($emppayroll->net_salary, 2) }}</strong></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            document.querySelector('#printPayslip').addEventListener('click', function() {
                printSpecificDiv();
            });

            function printSpecificDiv() {
                var printContents = document.querySelector('#printableArea').innerHTML;
                var printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Payslip</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            .table { width: 100%; border-collapse: collapse; }
                            .table td { border: 1px solid #000; padding: 8px; }
                            .text-center { text-align: center; }
                            .text-right { text-align: right; }
                            .list-unstyled { list-style-type: none; padding: 0; }
                            img { max-width: 100%; }
                        </style>
                    </head>
                    <body>
                        ${printContents}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            }
        });
    </script>
@endsection
