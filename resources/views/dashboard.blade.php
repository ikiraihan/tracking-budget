@extends('layouts.main')

@section('content')
<style>
.blink {
    animation: blink-soft 2s ease-in-out infinite;
    /* color: red; */
}

@keyframes blink-soft {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.2;
    }
}

</style>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h4 class="mb-0">Dashboard</h4>
            {{-- <p class="mb-0 text-muted">Sales monitoring dashboard template.</p> --}}
        </div>
    </div>
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        @if($role == 'owner')
        <div class="col-sm-10 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons p-0">
                    <div class="clearfix px-4 pt-3">
                        <div class="text-center w-100">
                            <p class="card-text mb-1">{{ $countVerifikasiDataPerjalanan['nama'] }}</p>
                            <h4 class="{{ $countVerifikasiDataPerjalanan['count'] > 0 ? 'blink' : '' }}">
                                {{ $countVerifikasiDataPerjalanan['count'] }}
                            </h4>
                        </div>
                    </div>
                    @if($countVerifikasiDataPerjalanan['count'] > 0)
                        <div class="card-footer">
                            <a href="/perjalanan?status_slug=proses-reimburse" class="btn btn-outline-success d-grid">Lihat Semua</a>
                        </div>                    
                    @endif
                </div>
            </div>
        </div>
        @elseif($role == 'admin')
        <div class="col-sm-10 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons p-0">
                    <div class="clearfix px-4 pt-3">
                        <div class="text-center w-100">
                            <p class="card-text mb-1">{{ $countVerifikasiPembayaranPerjalanan['nama'] }}</p>
                            <h4 class="{{ $countVerifikasiPembayaranPerjalanan['count'] > 0 ? 'blink' : '' }}">
                                {{ $countVerifikasiPembayaranPerjalanan['count'] }}
                            </h4>
                        </div>
                    </div>
                    @if($countVerifikasiPembayaranPerjalanan['count'] > 0)
                        <div class="card-footer">
                            <a href="/perjalanan?status_slug=proses-pembayaran" class="btn btn-outline-success d-grid">Lihat Semua</a>
                        </div>                    
                    @endif
                </div>
            </div>
        </div>
        @endif
        <form action="" method="GET" class="ms-auto" style="max-width: 600px;">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                        <input type="text" class="form-control" id="date_range" name="date_range" value="{{ old('date_range', $default_range) }}" placeholder="Pilih Range Tanggal">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" id="applyFilterDashboard" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <!-- End Page Header -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Perjalanan per Truk</div>
                </div>
                <div class="card-body">
                    <canvas id="graphValuePerTruk" class="chartjs-chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Perjalanan per Status</div>
                </div>
                <div class="card-body">
                    <canvas id="graphValuePerStatus" class="chartjs-chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- <script>
    /* Doughnut chart */
    const data3 = {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(132, 90, 223)',
                'rgb(35, 183, 229)',
                'rgb(245, 184, 73)'
            ],
            hoverOffset: 4
        }]
    };

    const config4 = {
        type: 'doughnut',
        data: data3,
    };

    const myChart3 = new Chart(
        document.getElementById('chartjs-doughnut'),
        config4
    );
</script> --}}
<script>
    var graphValuePerTruk = @json($graphValuePerTruk);
    var graphValuePerStatus = @json($graphValuePerStatus);

    document.addEventListener("DOMContentLoaded", function() {
        createDoughnutValuePerTruk('graphValuePerTruk', graphValuePerTruk);
        createDoughnutValuePerStatus('graphValuePerStatus', graphValuePerStatus);
    });

    // Fungsi untuk membuat Doughnut Chart
    function createDoughnutValuePerTruk(canvasId, data) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        var labels = data.map(item => item.nama);
        var counts = data.map(item => item.count);
        var colors = data.map(item => item.color);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    datalabels: {  
                        color: '#fff', 
                        backgroundColor: 'rgba(0, 0, 0, 0.5)',
                        borderRadius: 5, 
                        padding: 6,
                        font: {
                            weight: 'bold',
                            size: 7
                        },
                        formatter: (value, ctx) => {
                            let label = ctx.chart.data.labels[ctx.dataIndex];
                            return `${label}\n${value}`;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin datalabels
        });
    }

    function createDoughnutValuePerStatus(canvasId, data) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        var labels = data.map(item => item.nama);
        var counts = data.map(item => item.count);
        var colors = data.map(item => item.color);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'left',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    datalabels: {  
                        color: '#fff', 
                        backgroundColor: 'rgba(0, 0, 0, 0.5)',
                        borderRadius: 5, 
                        padding: 6,
                        font: {
                            weight: 'bold',
                            size: 7
                        },
                        formatter: (value, ctx) => {
                            let label = ctx.chart.data.labels[ctx.dataIndex];
                            return `${label}\n${value}`;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin datalabels
        });
    }

    document.getElementById('applyFilterDashboard').addEventListener('click', function () {
        const dateRange = document.getElementById('date_range').value;
        const baseUrl = `/dashboard`; // Bangun URL dinamis

        let queryParams = [];
        if (dateRange) {
            queryParams.push(`date_range=${dateRange}`);
        }

        const queryString = queryParams.length > 0 ? `?${queryParams.join('&')}` : '';
        const finalUrl = baseUrl + queryString;

        // Redirect to the filtered URL
        window.location.href = finalUrl;
    });

    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>

@endsection