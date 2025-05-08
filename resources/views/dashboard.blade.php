@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h4 class="mb-0">Dashboard</h4>
            {{-- <p class="mb-0 text-muted">Sales monitoring dashboard template.</p> --}}
        </div>
    </div>
    <!-- End Page Header -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Grafik Truk</div>
                </div>
                <div class="card-body">
                    <canvas id="graphValuePerTruk" class="chartjs-chart" width="400" height="400"></canvas>
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

    document.addEventListener("DOMContentLoaded", function() {
        createDoughnutValuePerTruk('graphValuePerTruk', graphValuePerTruk);
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

    document.getElementById('applyFilter').addEventListener('click', function () {
        const dateRange = document.getElementById('date_range').value;
        const baseUrl = `/admin_sdm/dashboard/`; // Bangun URL dinamis

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