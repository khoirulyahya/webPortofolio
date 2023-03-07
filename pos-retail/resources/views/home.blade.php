@extends('layouts.admin')

@section('title')
<title>Minargmnt-Apps | Dashboard</title>
@endsection

@section('header')
    <div class="col-sm-6 text-white">
        <h4>Dashboard</h4>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item accent-light"><a href="{{ url('home') }}">Dashboard</a></li>
            {{--  <li class="breadcrumb-item active">Edit</li>  --}}
        </ol>
    </div>
@endsection

@section('css')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
<!-- Info boxes (Stat box) -->
<div class="row justify-content-center">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Products Item</span>
                <span class="info-box-number">
                    {{ convert_number($total_products) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-truck"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Suppliers</span>
                <span class="info-box-number">
                    {{ convert_number($total_suppliers) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">
                    {{ convert_number($total_transactionSales) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">
                    {{ convert_number($total_members) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Products Stock</span>
                <span class="info-box-number">
                    {{ convert_number($total_allStok) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cash-register"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Transaction Sale Cash</span>
                <span class="info-box-number">
                    {{ convert_rupe($total_saleCash) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-truck"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Transaction Supply Cash</span>
                <span class="info-box-number">
                    {{ convert_rupe($total_supplyCash) }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<!-- /.row -->

<!-- Chart content -->
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- PIE CHART -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Product Sales by Categories</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pie_saleChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <div class="col-md-6">
        <!-- PIE CHART -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Product Supply by Categories</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pie_supplyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col (LEFT) -->
    <div class="col-md-6">
        <!-- STACKED BAR CHART -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Transaction by Type</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col (RIGHT) -->
</div>
<!-- /.row -->
@endsection

@section('js')
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
<!-- Page specific script -->

<script>
    var label_pie_transcationSales = '{!! json_encode($label_pie_transcationSales) !!}';
    var data_pie_transcationSales = '{!! json_encode($data_pie_transcationSales) !!}';
    var label_pie_transcationSuppliers = '{!! json_encode($label_pie_transcationSuppliers) !!}';
    var data_pie_transcationSuppliers = '{!! json_encode($data_pie_transcationSuppliers) !!}';
    var data_stackedBar = '{!! json_encode($data_stackedBar) !!}';
    $(function () {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pie_saleChartCanvas = $('#pie_saleChart').get(0).getContext('2d')
        var pie_saleData        = {
            labels: JSON.parse(label_pie_transcationSales),
            datasets: [
                {
                    data: JSON.parse(data_pie_transcationSales),
                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#e83e8c','#7344ff','#98d34a','#4b5a7f','#0048ff','#FFF000','#000555'],
                }
                ]
        }
        var pie_saleOptions     = {
            maintainAspectRatio : false,
            responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pie_saleChartCanvas, {
            type: 'pie',
            data: pie_saleData,
            options: pie_saleOptions
        })
        // Get context with jQuery - using jQuery's .get() method.
        var pie_supplyChartCanvas = $('#pie_supplyChart').get(0).getContext('2d')
        var pie_supplyData        = {
            labels: JSON.parse(label_pie_transcationSuppliers),
            datasets: [
                {
                    data: JSON.parse(data_pie_transcationSuppliers),
                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#e83e8c','#7344ff','#98d34a','#4b5a7f','#0048ff','#FFF000','#000555'],
                }
                ]
        }
        var pie_supplyOptions     = {
            maintainAspectRatio : false,
            responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pie_supplyChartCanvas, {
            type: 'pie',
            data: pie_supplyData,
            options: pie_supplyOptions
        })
        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = {
            labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','Desember'],
            datasets: JSON.parse(data_stackedBar)
        }

        var temp0 = stackedBarChartData.datasets[0]
        var temp1 = stackedBarChartData.datasets[1]
        stackedBarChartData.datasets[0] = temp1
        stackedBarChartData.datasets[1] = temp0

        var stackedBarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })
    })
</script>
@endsection

